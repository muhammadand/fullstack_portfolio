<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Documentation;
use App\Models\DailyView;
use App\Models\GoogleCardVisit;
use App\Services\QrisPaymentService;
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

        return view('pages.blogs.index', compact('blogs', 'popular', 'categories', 'search', 'categorySlug'));
    }




    public function readBlog($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->with(['author', 'category'])
            ->firstOrFail();

        // Tambah view count
        $blog->increment('view_count');

        // Tambah view count harian
        $dailyView = DailyView::firstOrCreate(
            [
                'viewable_type' => Blog::class,
                'viewable_id' => $blog->id,
                'date' => now()->toDateString(),
            ]
        );
        $dailyView->increment('views_count');

        // Ambil artikel lain untuk rekomendasi
        $related = Blog::published()
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.blogs.read', compact('blog', 'related'));
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
     * Generate QRIS Pembelian Google Review Card via QrisPaymentService (Scalify Pay)
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
            $qrisResult = QrisPaymentService::createDynamicQris(
                $orderId,
                $amount,
                [
                    'name'  => $validated['customer_name'],
                    'phone' => $validated['phone'],
                ],
                'DANA'
            );

            if (!$qrisResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $qrisResult['message'] ?? 'Gagal membuat QRIS pembayaran. Silakan coba kembali.',
                ], 422);
            }

            $qrisData = $qrisResult['data'] ?? [];
            $payload  = $qrisData['qris_payload'] ?? '';
            $total    = (int) ($qrisData['total_amount'] ?? $amount);
            $imageUrl = !empty($payload)
                ? 'https://api.qrserver.com/v1/create-qr-code/?size=320x320&margin=8&data=' . urlencode($payload)
                : null;

            return response()->json([
                'success' => true,
                'data' => [
                    'order_id'       => $qrisData['order_id'] ?? $orderId,
                    'merchant_name'  => $qrisData['merchant_name'] ?? 'Scalify / Google Review Card',
                    'base_amount'    => (int) ($qrisData['base_amount'] ?? $amount),
                    'unique_code'    => (int) ($qrisData['unique_code'] ?? 0),
                    'amount'         => $total,
                    'qris_payload'   => $payload,
                    'qris_image_url' => $imageUrl,
                    'admin_phone'    => '085221694067',
                    'business_name'  => $validated['business_name'],
                    'customer_name'  => $validated['customer_name'],
                    'phone'          => $validated['phone'],
                    'google_maps_url'=> $validated['google_maps_url'] ?? '-',
                    'design_type'    => $validated['design_type'] ?? 'Standee Akrilik Meja & Stiker',
                    'theme'          => $validated['theme'] ?? 'Classic White',
                    'expires_at'     => $qrisData['expires_at'] ?? now()->addMinutes(30)->toIso8601String(),
                ]
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('generateGoogleCardQris error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi gangguan saat memproses pembayaran: ' . $e->getMessage(),
            ], 500);
        }
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

