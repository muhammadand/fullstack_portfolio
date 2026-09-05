<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentLead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Gemini\Laravel\Facades\Gemini;

class StudentLeadController extends Controller
{
    public function index(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard')->with('error', 'Akun Anda belum disetujui.');
        }

        $tab = $request->get('tab', 'global'); // 'global' or 'my_leads'

        $query = \Illuminate\Support\Facades\DB::table('student_leads')
            ->leftJoin('client_proposals', 'student_leads.client_proposal_id', '=', 'client_proposals.id')
            ->select(
                'student_leads.id',
                'student_leads.name',
                'student_leads.university',
                'student_leads.wa_number',
                'student_leads.needs',
                'student_leads.status',
                'client_proposals.slug as proposal_slug'
            );

        if ($tab === 'my_leads') {
            $query->where('student_leads.affiliate_id', $affiliate->id)
                ->orderByDesc('student_leads.updated_at');
        } else {
            $query->whereNull('student_leads.affiliate_id')
                ->orderByDesc('student_leads.created_at');
        }

        $leads = $query->simplePaginate(10)->withQueryString();

        $chatTemplates = \Illuminate\Support\Facades\DB::table('chat_templates')
            ->select('name', 'content')
            ->whereNull('affiliate_id')
            ->orWhere('affiliate_id', $affiliate->id)
            ->get();

        $digitalProducts = \App\Models\DigitalProduct::active()->ordered()->get();

        return view('affiliate.student_leads.index', compact('affiliate', 'leads', 'tab', 'chatTemplates', 'digitalProducts'));
    }

    public function claim(Request $request, $id)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $lead = StudentLead::findOrFail($id);

        if ($lead->affiliate_id && $lead->affiliate_id !== $affiliate->id) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Data ini sudah diklaim oleh partner lain.'], 403);
            }
            return redirect()->back()->with('error', 'Data ini sudah diklaim oleh partner lain.');
        }

        if (!$lead->affiliate_id) {
            $lead->update([
                'affiliate_id' => $affiliate->id,
                'status' => 'contacted'
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Data Mahasiswa berhasil diklaim.']);
        }

        return redirect()->route('affiliate.student_leads.index', ['tab' => 'my_leads'])->with('success', 'Data Mahasiswa berhasil diklaim.');
    }

    public function store(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();

        $request->validate([
            'wa_number' => 'required|string',
            'name' => 'nullable|string|max:255',
            'needs' => 'nullable|string|max:255',
        ]);

        StudentLead::create([
            'wa_number' => $request->wa_number,
            'name' => $request->name,
            'needs' => $request->needs ?? 'Belum Diketahui',
            'affiliate_id' => $affiliate->id,
            'status' => 'new',
        ]);

        if ($request->has('redirect_to') && $request->redirect_to === 'student_services') {
            return redirect()->route('affiliate.student_services.index')->with('success', 'Prospek Mahasiswa berhasil ditambahkan.');
        }

        return redirect()->route('affiliate.student_leads.index', ['tab' => 'my_leads'])->with('success', 'Prospek Mahasiswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $lead = StudentLead::where('id', $id)->where('affiliate_id', $affiliate->id)->firstOrFail();

        $request->validate([
            'wa_number' => 'required|string',
            'name' => 'nullable|string|max:255',
            'needs' => 'nullable|string|max:255',
        ]);

        $lead->update([
            'wa_number' => $request->wa_number,
            'name' => $request->name,
            'needs' => $request->needs ?? 'Belum Diketahui',
        ]);

        return redirect()->route('affiliate.student_leads.index', ['tab' => 'my_leads'])->with('success', 'Data Prospek berhasil diperbarui.');
    }

    public function generateAiChat(Request $request, $id)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $lead = StudentLead::findOrFail($id);

        $productId = $request->input('digital_product_id');
        $product = null;
        if ($productId) {
            $product = \App\Models\DigitalProduct::find($productId);
        }

        $profileLink = "https://scalifyintellegence.my.id/sobat-scalify?ref=" . $affiliate->affiliate_code;
        $studentName = ($lead->name && $lead->name !== 'Anonim') ? $lead->name : 'Kak';
        $senderName = $affiliate->name;

        if ($product) {
            $productUrl = $product->getAffiliateUrl($affiliate) ?: $profileLink;
            $cacheKey = "ai_template_product_" . $product->id;

            // Server-Side Smart Cache (disimpan selama 14 hari)
            $template = Cache::remember($cacheKey, now()->addDays(14), function () use ($product) {
                $prompt = "Kamu adalah seorang konsultan mahasiswa dan copywriter WhatsApp yang ramah, santai, dan persuasif (bukan robot).\n";
                $prompt .= "Buatkan 1 template pesan WhatsApp yang soft-selling dan ringkas (maksimal 3-4 kalimat) untuk merekomendasikan produk source code/template berikut:\n";
                $prompt .= "- Nama Produk: {$product->name}\n";
                $prompt .= "- Deskripsi Singkat: {$product->short_description}\n\n";
                $prompt .= "Instruksi Format Template:\n";
                $prompt .= "1. Gunakan placeholder [NAMA] untuk nama mahasiswa, [LINK] untuk link produk, dan [PENGIRIM] untuk nama pengirim.\n";
                $prompt .= "2. Awali sapaan santai menanyakan kabar/skripsi [NAMA].\n";
                $prompt .= "3. Rekomendasikan *{$product->name}* sebagai solusi/referensi yang sudah jadi dan siap pakai untuk mempermudah pengerjaannya, lalu cantumkan [LINK].\n";
                $prompt .= "4. WAJIB DI AKHIR: Tambahkan penutup ramah bahwa kalau butuh fitur yang beda atau mau dibikinin custom sesuai judul/kebutuhan sendiri, mereka bisa banget request / konsultasi langsung.\n";
                $prompt .= "5. Berikan isi template saja tanpa kata pengantar.";

                try {
                    $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
                    return trim($response->text());
                } catch (\Exception $e) {
                    // Fallback template jika API bermasalah/kuota habis
                    return "Halo [NAMA], lagi sibuk ngerjain tugas akhir atau skripsi ya?\n\nKebetulan aku ada rekomendasi *{$product->name}* nih, sistemnya sudah lengkap, rapi, dan siap pakai buat referensi kamu. Detail dan demonya bisa langsung kamu cek di sini ya: [LINK]\n\nKalau misalnya butuh fitur yang berbeda atau mau dibikinin custom sesuai judul kamu sendiri, bisa banget request langsung ke aku ya [NAMA]!";
                }
            });

            // Gantikan placeholder dengan data spesifik affiliate & mahasiswa saat ini
            $finalText = str_replace(
                ['[NAMA]', '[PRODUK]', '[LINK]', '[PENGIRIM]'],
                [$studentName, '*' . $product->name . '*', $productUrl, $senderName],
                $template
            );
        } else {
            $cacheKey = "ai_template_custom_service";

            // Server-Side Smart Cache (disimpan selama 14 hari)
            $template = Cache::remember($cacheKey, now()->addDays(14), function () {
                $prompt = "Kamu adalah seorang konsultan mahasiswa dan copywriter WhatsApp yang ramah dan santai.\n";
                $prompt .= "Buatkan 1 template pesan WhatsApp yang soft-selling dan ringkas (maksimal 3-4 kalimat) untuk menawarkan bantuan pengerjaan tugas akhir/skripsi IT.\n";
                $prompt .= "Gunakan placeholder [NAMA] untuk nama mahasiswa, [LINK] untuk link profil, dan [PENGIRIM] untuk nama pengirim.\n";
                $prompt .= "WAJIB DI AKHIR: Beritahu bahwa kalau butuh request khusus atau custom sesuai judulnya sendiri, bisa konsultasi langsung.\n";
                $prompt .= "Berikan isi template saja tanpa pengantar.";

                try {
                    $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
                    return trim($response->text());
                } catch (\Exception $e) {
                    // Fallback template jika API bermasalah
                    return "Halo [NAMA], lagi sibuk ngerjain project atau skripsi kuliah ya?\n\nKalau kamu lagi butuh bantuan atau bimbingan pembuatan website dan aplikasi skripsi, aku dan tim siap bantu pengerjaannya sampai tuntas, amanah, dan bergaransi revisi. Info lengkapnya bisa cek di: [LINK]\n\nKalau ada kebutuhan metode atau judul khusus, kamu bisa langsung request/konsultasi bebas ya [NAMA]!";
                }
            });

            $finalText = str_replace(
                ['[NAMA]', '[LINK]', '[PENGIRIM]'],
                [$studentName, $profileLink, $senderName],
                $template
            );
        }

        return response()->json([
            'success' => true,
            'text' => $finalText,
            'product_name' => $product ? $product->name : null
        ]);
    }
}
