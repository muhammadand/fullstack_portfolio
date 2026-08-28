<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentLead;
use Illuminate\Support\Facades\Auth;
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

        return view('affiliate.student_leads.index', compact('affiliate', 'leads', 'tab', 'chatTemplates'));
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

        $profileLink = "https://scalifyintellegence.my.id/sobat-scalify?ref=" . $affiliate->affiliate_code;

        $prompt = "Kamu adalah seorang UX Copywriter dan Content Strategist profesional.\n";
        $prompt .= "Buatkan 1 pesan WhatsApp yang soft-selling, ramah, menarik, dan pendek (maksimal 3-4 kalimat) untuk prospek mahasiswa yang butuh bantuan Tugas Akhir/Skripsi atau project IT lainnya.\n";
        $prompt .= "Informasi prospek:\n";
        $prompt .= "- Nama Mahasiswa: " . ($lead->name ?? 'Kak') . "\n";
        $prompt .= "- Universitas: " . ($lead->university ?? 'Kampusnya') . "\n";
        $prompt .= "- Kebutuhan/Project: " . ($lead->needs ?? 'Tugas Akhir / Skripsi') . "\n";
        $prompt .= "- Nama Saya (Pengirim): " . ($affiliate->name) . "\n\n";
        $prompt .= "Instruksi Khusus:\n";
        $prompt .= "1. Pesan harus terkesan personal, menawarkan bantuan untuk mengerjakan project/skripsi mereka dengan aman dan terpercaya, tanpa bertele-tele.\n";
        $prompt .= "2. Sertakan link profil ini di akhir pesan agar mereka lebih percaya: " . $profileLink . "\n";
        $prompt .= "3. Jangan berikan opsi, jangan tambahkan karakter markdown seperti bintang (**) atau pembuka/penutup, langsung berikan isi teksnya saja agar bisa langsung dikirim via WhatsApp.";

        try {
            $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
            $text = trim($response->text());

            return response()->json([
                'success' => true,
                'text' => $text
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate AI: ' . $e->getMessage()
            ], 500);
        }
    }
}
