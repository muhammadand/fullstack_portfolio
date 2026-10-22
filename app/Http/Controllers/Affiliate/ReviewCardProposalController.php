<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\BusinessCategory;
use App\Models\ChatTemplate;
use App\Models\ClientProposal;
use App\Models\LeadOffering;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReviewCardProposalController extends Controller
{
    /**
     * Display Google Review Card leads page for affiliates (Mobile View).
     */
    public function index(Request $request)
    {
        /** @var Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard')->with('error', 'Akun Anda belum disetujui.');
        }

        $tab = $request->get('tab', 'global'); // 'global' or 'follow_up'
        $search = $request->get('search');

        $query = ClientProposal::with(['category', 'offerings.affiliate'])
            ->orderByDesc('created_at');

        if ($request->filled('category_id')) {
            $query->where('business_category_id', $request->category_id);
        }

        if ($tab === 'follow_up') {
            // Tampilkan bisnis yang sudah di-follow up kartu review oleh affiliate yang login
            $query->whereHas('offerings', function ($q) use ($affiliate) {
                $q->where('product_type', 'review_card')
                  ->where('affiliate_id', $affiliate->id);
            });

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brand_name', 'like', "%{$search}%")
                      ->orWhere('wa_number', 'like', "%{$search}%");
                });
            }
        } else {
            // Global Leads: Bisnis yang BELUM ditawari Google Review Card oleh siapapun
            $query->whereDoesntHave('offerings', function ($q) {
                $q->where('product_type', 'review_card');
            });
        }

        $proposals = $query->simplePaginate(10)->withQueryString();
        $categories = BusinessCategory::all();

        // Ambil template chat khusus review_card (global atau milik affiliate yang login)
        $chatTemplates = ChatTemplate::where('product_type', 'review_card')
            ->where(function ($q) use ($affiliate) {
                $q->whereNull('affiliate_id')
                  ->orWhere('affiliate_id', $affiliate->id);
            })
            ->get();

        return view('affiliate.review_cards.proposals_mobile', compact(
            'affiliate',
            'proposals',
            'categories',
            'chatTemplates',
            'tab',
            'search'
        ));
    }

    /**
     * Claim a lead specifically for Google Review Card offering.
     */
    public function claim(Request $request, $id)
    {
        /** @var Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $proposal = ClientProposal::findOrFail($id);

        $existing = LeadOffering::where('client_proposal_id', $id)
            ->where('product_type', 'review_card')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Bisnis ini sudah diklaim untuk penawaran kartu review oleh partner lain.'
            ], 403);
        }

        LeadOffering::create([
            'client_proposal_id' => $id,
            'affiliate_id'       => $affiliate->id,
            'product_type'       => 'review_card',
            'status'             => 'contacted',
            'contacted_at'       => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Search follow-up leads for autocomplete.
     */
    public function search(Request $request)
    {
        /** @var Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        $search = $request->get('q');
        if (!$search || strlen($search) < 3) {
            return response()->json([]);
        }

        $leads = ClientProposal::leftJoin('business_categories', 'client_proposals.business_category_id', '=', 'business_categories.id')
            ->select('client_proposals.id', 'client_proposals.brand_name', 'client_proposals.wa_number', 'business_categories.name as category_name')
            ->whereHas('offerings', function ($q) use ($affiliate) {
                $q->where('product_type', 'review_card')
                  ->where('affiliate_id', $affiliate->id);
            })
            ->where(function ($q) use ($search) {
                $q->where('client_proposals.brand_name', 'like', "%{$search}%")
                  ->orWhere('client_proposals.wa_number', 'like', "%{$search}%");
            })
            ->orderByDesc('client_proposals.created_at')
            ->limit(10)
            ->get();

        return response()->json($leads);
    }

    /**
     * Generate AI WhatsApp Copy specifically for Smart Google Review Card.
     */
    public function generateAiChat(Request $request, $id)
    {
        /** @var Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $proposal = ClientProposal::with('category')->findOrFail($id);

        $brandName = ($proposal->brand_name && $proposal->brand_name !== 'Bapak/Ibu') ? $proposal->brand_name : 'Bapak/Ibu';
        $categoryName = $proposal->category->name ?? 'Bisnis';
        $senderName = $affiliate->name;
        $profileLink = "https://scalifyintellegence.my.id/sobat-scalify?ref=" . $affiliate->affiliate_code;

        $cacheKey = "ai_review_card_chat_" . $proposal->id;

        // Server-Side Smart Cache (14 hari)
        $template = Cache::remember($cacheKey, now()->addDays(14), function () use ($categoryName, $brandName) {
            $prompt = "Kamu adalah seorang Konsultan Marketing B2B dan Mitra Solusi Bisnis Lokal profesional untuk Scalify Partner.\n";
            $prompt .= "Buatkan 1 template pesan WhatsApp yang ramah, sopan, persuasif, dan to the point (maksimal 3 paragraf pendek) untuk menawarkan produk: Smart Google Review Card (Kartu Review Google Maps NFC & QR Code untuk meja kasir toko/merchant).\n\n";
            $prompt .= "Informasi Target Bisnis:\n";
            $prompt .= "- Nama Bisnis/Toko: {$brandName}\n";
            $prompt .= "- Kategori Bisnis: {$categoryName}\n\n";
            $prompt .= "Value Proposition Produk:\n";
            $prompt .= "1. Kartu fisik tap NFC & scan QR diletakkan di kasir untuk meminta ulasan Google Maps bintang 5 secara instan dalam 3 detik tanpa ribet cari nama toko.\n";
            $prompt .= "2. Membantu toko/resto selalu muncul di urutan teratas pencarian Google Maps lokal.\n";
            $prompt .= "3. Sekali beli aktif selamanya tanpa biaya langganan bulanan.\n\n";
            $prompt .= "Instruksi Format:\n";
            $prompt .= "- Gunakan placeholder [NAMA_BISNIS] dan [PENGIRIM].\n";
            $prompt .= "- JANGAN gunakan format markdown tebal ganda (**), berikan teks pesan WhatsApp langsung yang siap kirim tanpa kata pengantar.";

            try {
                $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
                return trim($response->text());
            } catch (\Exception $e) {
                // Fallback template jika API bermasalah
                return "Halo Tim [NAMA_BISNIS], salam kenal dari [PENGIRIM].\n\nSaya perhatikan bisnis [NAMA_BISNIS] di Google Maps punya potensi besar untuk dapat lebih banyak pelanggan baru. Salah satu kuncinya adalah jumlah ulasan bintang 5 yang aktif di Google Maps.\n\nKami ada solusi praktis untuk ditaruh di kasir: *Smart Google Review Card (NFC & QR)*. Pelanggan cukup tap HP ke kartu, langsung terbuka form review bintang 5 dalam 3 detik tanpa repot.\n\nApakah boleh saya kirimkan preview kartu & promo khusus merchant minggu ini kak? Terima kasih 🙏";
            }
        });

        $finalText = str_replace(
            ['[NAMA_BISNIS]', '[PENGIRIM]', '[NAMA_PENGIRIM]', '[LINK_PROFIL]'],
            [$brandName, $senderName, $senderName, $profileLink],
            $template
        );

        return response()->json([
            'success' => true,
            'text'    => $finalText
        ]);
    }
}
