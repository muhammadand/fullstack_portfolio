<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Documentation;
use App\Models\DailyView;
use App\Models\GoogleCardVisit;
use App\Models\GoogleCardOrder;
use App\Models\PaymentCallback;
use App\Services\ScalifyPayService;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function landing()
    {
        $latestBlogs = Blog::published()
            ->latest('published_at')
            ->take(3)
            ->get();
        $latestPortfolios = Portfolio::active()
            ->orderBy('completion_date', 'desc')
            ->take(3)
            ->get();

        return view('pages.landing.index', compact('latestBlogs', 'latestPortfolios'));
    }

    public function indexCompanyProfile()
    {
        return response()
            ->view('company.landing')
            ->setStatusCode(200);
    }



    public function blogs(Request $request)
    {
        $search = $request->query('search');
        $categorySlug = $request->query('category');

        $query = Blog::published()->with(['author', 'category']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // 1 blog paling populer / highlight
        $popular = Blog::published()
            ->with(['author', 'category'])
            ->orderByDesc('view_count')
            ->first();

        $blogs = (clone $query)
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = BlogCategory::where('is_active', 1)
            ->orderBy('display_order')
            ->get();

        // Topik populer (tag dengan >= 2 artikel): tautan internal ke halaman tag, bagus untuk SEO & navigasi.
        $popularTags = \App\Support\BlogTags::popular(12);

        return view('pages.blogs.index', compact('blogs', 'popular', 'categories', 'search', 'categorySlug', 'popularTags'));
    }




    public function readBlog($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->with(['author', 'category'])
            ->firstOrFail();

        // Hitung view SETELAH halaman terkirim ke browser, supaya pengunjung (dan Googlebot) tidak menunggu
        // query tulis. Hanya 2 query: update langsung (tanpa event model) + upsert harian.
        $blogId = $blog->id;
        dispatch(function () use ($blogId) {
            Blog::whereKey($blogId)->increment('view_count');

            $now = now();
            DailyView::upsert(
                [[
                    'viewable_type' => Blog::class,
                    'viewable_id'   => $blogId,
                    'date'          => $now->toDateString(),
                    'views_count'   => 1,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]],
                ['viewable_type', 'viewable_id', 'date'],
                ['views_count' => \Illuminate\Support\Facades\DB::raw('views_count + 1'), 'updated_at' => $now]
            );
        })->afterResponse();

        $related = $this->relatedBlogs($blog);

        return view('pages.blogs.read', compact('blog', 'related'));
    }

    /**
     * Halaman topik/tag: /s/blogs/tag/{tag}. Semua artikel dengan tag yang sama + meta SEO sendiri.
     * Slug tidak baku (huruf besar, spasi, "#") diarahkan 301 ke slug baku agar tidak ada URL ganda.
     */
    public function blogTag(Request $request, string $tag)
    {
        $slug = \App\Support\BlogTags::slug(urldecode($tag));
        $info = $slug !== '' ? \App\Support\BlogTags::find($slug) : null;
        abort_if($info === null, 404);

        if ($tag !== $info['slug']) {
            return redirect()->route('blogs.tag', array_filter(['tag' => $info['slug'], 'page' => $request->query('page')]), 301);
        }

        $blogs = Blog::published()
            ->whereIn('id', $info['blog_ids'])
            ->with('category')
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        abort_if($blogs->isEmpty() && $blogs->currentPage() > 1, 404);

        $name = $info['name'];
        $pageSuffix = $blogs->currentPage() > 1 ? " — Halaman {$blogs->currentPage()}" : '';
        $canonical = $blogs->currentPage() > 1 ? $blogs->url($blogs->currentPage()) : route('blogs.tag', $info['slug']);
        $latestTitles = $blogs->getCollection()->take(3)->pluck('title')->implode('; ');

        $seo = [
            'title'       => "#{$name}: {$info['count']} Artikel & Panduan tentang {$name}{$pageSuffix}",
            'description' => \Illuminate\Support\Str::limit("Kumpulan {$info['count']} artikel tentang {$name} dari Scalify Intelligence. Terbaru: {$latestTitles}", 158),
            'canonical'   => $canonical,
            'robots'      => \App\Support\BlogTags::isIndexable($info) ? 'index, follow, max-image-preview:large' : 'noindex, follow',
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@graph'   => [
                [
                    '@type'       => 'CollectionPage',
                    'name'        => $seo['title'],
                    'url'         => $canonical,
                    'description' => $seo['description'],
                    'about'       => ['@type' => 'Thing', 'name' => $name],
                    'isPartOf'    => ['@type' => 'Blog', 'name' => 'Blog Scalify Intelligence', 'url' => route('landing.blogs')],
                    'mainEntity'  => [
                        '@type'           => 'ItemList',
                        'numberOfItems'   => $info['count'],
                        'itemListElement' => $blogs->getCollection()->values()->map(fn ($b, $i) => [
                            '@type'    => 'ListItem',
                            'position' => ($blogs->firstItem() ?? 1) + $i,
                            'url'      => route('blogs.read', $b->slug),
                            'name'     => $b->title,
                        ])->all(),
                    ],
                ],
                [
                    '@type'           => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('landing.blogs')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => "#{$name}", 'item' => route('blogs.tag', $info['slug'])],
                    ],
                ],
            ],
        ];

        return view('pages.blogs.tag', [
            'tag'         => $info,
            'blogs'       => $blogs,
            'seo'         => $seo,
            'schema'      => $schema,
            'relatedTags' => \App\Support\BlogTags::relatedTo($info['slug'], 10),
        ]);
    }

    /** Artikel terkait: utamakan yang berbagi tag terbanyak, lalu isi dari kategori yang sama. */
    private function relatedBlogs(Blog $blog, int $limit = 3)
    {
        $scores = [];
        foreach ($blog->tag_list as $name) {
            foreach (\App\Support\BlogTags::find(\App\Support\BlogTags::slug($name))['blog_ids'] ?? [] as $id) {
                if ($id !== $blog->id) {
                    $scores[$id] = ($scores[$id] ?? 0) + 1;
                }
            }
        }
        arsort($scores);

        $byTag = $scores
            ? Blog::published()->whereIn('id', array_slice(array_keys($scores), 0, $limit))->get()
                ->sortByDesc(fn ($b) => [$scores[$b->id], $b->published_at?->timestamp])->values()
            : collect();

        if ($byTag->count() < $limit) {
            $byTag = $byTag->concat(
                Blog::published()
                    ->where('category_id', $blog->category_id)
                    ->whereNotIn('id', $byTag->pluck('id')->push($blog->id))
                    ->latest('published_at')
                    ->take($limit - $byTag->count())
                    ->get()
            );
        }

        return $byTag;
    }

    public function portfolio(Request $request)
    {
        $search = $request->query('search');
        $categorySlug = $request->query('category');

        $query = Portfolio::active()->with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('technologies', 'like', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $portfolios = (clone $query)
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        $popularPortfolios = Portfolio::active()
            ->with('category')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $featuredPortfolio = Portfolio::active()
            ->with('category')
            ->where('is_featured', true)
            ->first() ?? Portfolio::active()->with('category')->orderByDesc('view_count')->first();

        $categories = PortfolioCategory::where('is_active', 1)
            ->orderBy('display_order')
            ->get();

        return view('pages.portfolio.index', compact('portfolios', 'popularPortfolios', 'featuredPortfolio', 'categories', 'categorySlug', 'search'));
    }


    public function readPortfolio($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->active()->with('category')->firstOrFail();

        // Increment view count
        $portfolio->increment('view_count');

        // Tambah view count harian
        $dailyView = DailyView::firstOrCreate(
            [
                'viewable_type' => Portfolio::class,
                'viewable_id' => $portfolio->id,
                'date' => now()->toDateString(),
            ]
        );
        $dailyView->increment('views_count');

        // Pastikan technologies selalu array
        if (!is_array($portfolio->technologies)) {
            $portfolio->technologies = $portfolio->technologies
                ? json_decode($portfolio->technologies, true)
                : [];
        }

        // Ambil portfolio populer
        $popularPortfolios = Portfolio::active()->orderBy('view_count', 'desc')->take(5)->get();

        return view('pages.portfolio.read', compact('portfolio', 'popularPortfolios'));
    }


    public function service()
    {
        return view('pages.service.index');
    }
    public function about()
    {
        return view('pages.about.index');
    }
    public function contact()
    {
        return view('pages.contact');
    }

    public function portfolio_1()
    {
        return view('portfolio.landingPage.index');
    }


    public function SobatScalify()
    {
        $documentation = Documentation::get();
        return view('company.SobatScalify', compact('documentation'));
    }

    public function partnerProgram()
    {
        return view('company.partner_program');
    }

    public function scmService()
    {
        return view('company.services.scm');
    }

    /**
     * API for tracking affiliate links clicked from inside a blog
     */
    /**
     * Dedicated Landing Page: Beli Google Review Card (Rp 20.000)
     * Sangat mudah dibagikan di Threads, Facebook, Instagram, WhatsApp.
     */
    public function googleReviewCard(Request $request)
    {
        // Track kunjungan dengan deteksi sumber (SEO, Media Sosial, Link Dibagikan, Direct)
        GoogleCardVisit::track($request);

        return view('company.google_card_page');
    }

    /**
     * Generate QRIS Pembelian Google Review Card via ScalifyPayService (pay.scalifyintellegence.my.id)
     */
    public function generateGoogleCardQris(Request $request)
    {
        $validated = $request->validate([
            'business_name'   => 'required|string|max:150',
            'customer_name'   => 'required|string|max:100',
            'phone'           => 'required|string|max:30',
            'google_maps_url' => 'nullable|string|max:500',
            'design_type'     => 'nullable|string|max:50',
            'theme'           => 'nullable|string|max:50',
        ]);

        $amount = 20000;
        $orderId = 'GRC-' . date('ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        try {
            // 0. Catat pembeli sebagai customer (kunci: no. HP + source google_card)
            [$customer] = \App\Models\Customer::findOrCreateByPhone(
                $validated['phone'],
                \App\Models\Customer::SOURCE_GOOGLE_CARD,
                trim($validated['customer_name'])
            );

            // 1. Simpan order ke database (Best Practice)
            $order = GoogleCardOrder::create([
                'order_id'        => $orderId,
                'customer_id'     => $customer->id,
                'business_name'   => $validated['business_name'],
                'customer_name'   => $validated['customer_name'],
                'phone'           => $validated['phone'],
                'google_maps_url' => $validated['google_maps_url'] ?? null,
                'design_type'     => $validated['design_type'] ?? 'Standee Meja Akrilik',
                'theme'           => $validated['theme'] ?? 'Classic White',
                'amount'          => $amount,
                'payment_method'  => 'qris',
                'payment_status'  => GoogleCardOrder::STATUS_PENDING,
                'affiliate_id'    => session('affiliate_id') ?? request()->cookie('scalify_affiliate_id'),
            ]);

            // 2. Request Charge QRIS via ScalifyPayService (pay.scalifyintellegence.my.id/api/v1/payments/charge)
            $chargeResult = ScalifyPayService::chargeQris(
                $orderId,
                $amount,
                [
                    'name'  => $validated['customer_name'],
                    'phone' => $validated['phone'],
                ],
                [
                    [
                        'id'       => 'GRC-PROMO-20K',
                        'name'     => 'Google Review Card (' . ($validated['design_type'] ?? 'Standee') . ')',
                        'price'    => $amount,
                        'quantity' => 1,
                    ]
                ],
                'gopay',
                30
            );

            // Jika ScalifyPay charge berhasil
            if (!empty($chargeResult['success'])) {
                $chargeData = $chargeResult['data'] ?? [];
                // Ambil URL QR Code langsung dari actions Midtrans
                $qrisImageUrl = $chargeData['qr_image_url'] ?? '';

                $order->update([
                    'transaction_id' => $chargeData['transaction_id'] ?? null,
                    'qris_image_url' => $qrisImageUrl,
                    'expires_at'     => now()->addMinutes(30),
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'order_id'        => $order->order_id,
                        'merchant_name'   => 'Scalify / Google Review Card',
                        'base_amount'     => $amount,
                        'amount'          => $amount,
                        'qris_image_url'  => $qrisImageUrl,
                        'admin_phone'     => '085221694067',
                        'business_name'   => $order->business_name,
                        'customer_name'   => $order->customer_name,
                        'phone'           => $order->phone,
                        'google_maps_url' => $order->google_maps_url ?? '-',
                        'design_type'     => $order->design_type,
                        'theme'           => $order->theme,
                        'expires_at'      => now()->addMinutes(30)->toIso8601String(),
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $chargeResult['message'] ?? 'Gagal memproses QRIS dari server payment gateway.',
            ], 422);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('generateGoogleCardQris error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi gangguan saat memproses pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check Payment Status for Google Review Card Order
     */
    public function checkGoogleCardOrderStatus($orderId)
    {
        $order = GoogleCardOrder::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Cek sinkronisasi callback terbaru di tabel payment_callbacks
        if (!$order->isPaid()) {
            $callback = PaymentCallback::where(function ($q) use ($order, $orderId) {
                $q->where('order_number', $orderId);
                if (!empty($order->transaction_id)) {
                    $q->orWhere('order_number', $order->transaction_id)
                        ->orWhere('transaction_id', $order->transaction_id);
                }
            })->latest()->first();

            if ($callback && in_array(strtolower((string) $callback->transaction_status), ['settlement', 'capture', 'success', 'paid'])) {
                $order->markAsPaid($callback->transaction_id, $callback->raw_response);
            }
        } elseif (!$order->review_card_id) {
            $order->createOrActivateReviewCard();
        }

        $order->refresh();
        $card = $order->reviewCard;

        return response()->json([
            'success' => true,
            'data' => [
                'order_id'        => $order->order_id,
                'payment_status'  => $order->payment_status,
                'is_paid'         => $order->isPaid(),
                'paid_at'         => $order->paid_at ? $order->paid_at->toIso8601String() : null,
                'amount'          => (int) $order->amount,
                'business_name'   => $order->business_name,
                'customer_name'   => $order->customer_name,
                'phone'           => $order->phone,
                'google_maps_url' => $order->google_maps_url,
                'design_type'     => $order->design_type,
                'theme'           => $order->theme,
                'review_card'     => $card ? [
                    'id'                => $card->id,
                    'serial_number'     => $card->serial_number,
                    'slug'              => $card->slug,
                    'scan_url'          => $card->scan_url,
                    'google_review_url' => $card->google_review_url,
                    'status'            => $card->status,
                ] : null,
            ],
        ]);
    }

    /**
     * Simulate Payment for Testing / Verification
     */
    public function simulateGoogleCardPayment(Request $request, $orderId)
    {
        $order = GoogleCardOrder::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        $card = $order->markAsPaid('SIM-' . strtoupper(\Illuminate\Support\Str::random(6)), [
            'mode' => 'simulation_test',
            'simulated_at' => now()->toIso8601String(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Simulasi pembayaran lunas berhasil!',
            'data' => [
                'order_id'    => $order->order_id,
                'is_paid'     => true,
                'review_card' => [
                    'id'                => $card->id,
                    'serial_number'     => $card->serial_number,
                    'slug'              => $card->slug,
                    'scan_url'          => $card->scan_url,
                    'google_review_url' => $card->google_review_url,
                    'status'            => $card->status,
                ],
            ],
        ]);
    }

    /**
     * API for tracking affiliate links clicked from inside a blog
     */
    public function trackBlogClick(\App\Models\Blog $blog)
    {
        $blog->increment('link_clicks');
        return response()->json(['status' => 'success']);
    }
}
