<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\AffiliateClick;
use App\Models\ClientProposal;
use App\Models\ChatTemplate;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Gemini\Laravel\Facades\Gemini;

class AffiliateController extends Controller
{
    public function registerForm()
    {
        return view('affiliate.register');
    }

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliates,email',
            'password' => 'required|min:6',
            'bank_info' => 'required|string',
        ]);

        $affiliate = Affiliate::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'affiliate_code' => strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $request->name), 0, 5)) . rand(10, 99),
            'bank_info' => $request->bank_info,
            'status' => 'pending',
            'balance' => 0,
        ]);

        $affiliate->notify(new \App\Notifications\AffiliateNotification(
            'Selamat Datang!',
            'Terima kasih telah bergabung sebagai Partner. Akun Anda sedang direview.',
            'info'
        ));

        Auth::guard('affiliate')->login($affiliate);

        return redirect()->route('affiliate.dashboard');
    }

    public function loginForm()
    {
        return view('affiliate.login');
    }

    public function loginSubmit(Request $request)
    {
        // 1. Cek jika partner login menggunakan Magic Link (Paste Link)
        if ($request->filled('magic_link')) {
            $magicLink = trim($request->input('magic_link'));

            // Validasi format link magic login
            if (str_contains($magicLink, '/partner/magic-login/')) {
                return redirect($magicLink);
            }

            return redirect()->back()->with('error', 'Format Magic Link tidak valid. Pastikan link lengkap disalin dengan benar.')->withInput();
        }

        // 2. Login konvensional dengan Email & Password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to login using the affiliate guard (true for permanent remember me)
        if (Auth::guard('affiliate')->attempt($credentials, true)) {
            /** @var \App\Models\Affiliate $affiliate */
            $affiliate = Auth::guard('affiliate')->user();

            // Check if rejected
            if ($affiliate->status === 'rejected') {
                Auth::guard('affiliate')->logout();
                return redirect()->route('affiliate.login')->with('error', 'Akun Partner Anda telah ditolak oleh Admin.');
            }

            return redirect()->intended(route('affiliate.dashboard'));
        }

        return redirect()->back()->withErrors(['email' => 'Email atau Password salah.'])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::guard('affiliate')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('affiliate.login')->with('success', 'Anda telah berhasil logout.');
    }

    public function dashboard(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        $totalClicks = AffiliateClick::where('affiliate_id', $affiliate->id)->count();
        $totalProjects = \App\Models\Commission::where('affiliate_id', $affiliate->id)->count();

        $withdrawals = \App\Models\Withdrawal::where('affiliate_id', $affiliate->id)->latest()->take(5)->get();
        $hasTemplates = \App\Models\ChatTemplate::where('affiliate_id', $affiliate->id)->exists();

        // Tampilkan dashboard terpadu (Responsive Desktop + Mobile)
        return view('affiliate.dashboard', compact('affiliate', 'totalClicks', 'totalProjects', 'withdrawals', 'hasTemplates'));
    }

    public function history(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        $commissions = \App\Models\Commission::where('affiliate_id', $affiliate->id)
            ->latest()
            ->paginate(10, ['*'], 'komisi_page');

        $withdrawals = \App\Models\Withdrawal::where('affiliate_id', $affiliate->id)
            ->latest()
            ->paginate(10, ['*'], 'tarik_page');

        return view('affiliate.history_mobile', compact('affiliate', 'commissions', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        $request->validate([
            'amount' => 'required|numeric|min:50000|max:' . $affiliate->balance,
        ]);

        // Kurangi balance
        $affiliate->decrement('balance', $request->amount);

        // Buat record withdrawal
        \App\Models\Withdrawal::create([
            'affiliate_id' => $affiliate->id,
            'amount' => $request->amount,
            'bank_info' => $affiliate->bank_info,
            'status' => 'Pending',
        ]);

        $affiliate->notify(new \App\Notifications\AffiliateNotification(
            'Penarikan Diajukan',
            'Pengajuan penarikan sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' sedang diproses.',
            'success'
        ));

        return redirect()->back()->with('success', 'Permintaan penarikan komisi berhasil diajukan dan sedang diproses.');
    }

    public function claimDailyPoints(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->back()->with('error', 'Akun Anda belum disetujui.');
        }

        $today = now()->format('Y-m-d');

        if ($affiliate->last_claim_date === $today) {
            return redirect()->back()->with('error', 'Anda sudah melakukan klaim hari ini.');
        }

        $yesterday = now()->subDay()->format('Y-m-d');
        $pointsEarned = 10;
        $description = 'Klaim Poin Harian';

        if ($affiliate->last_claim_date === $yesterday) {
            $affiliate->current_streak += 1;
        } else {
            $affiliate->current_streak = 1;
        }

        if ($affiliate->current_streak % 7 == 0) {
            $pointsEarned += 50; // Bonus mingguan
            $description = 'Klaim Poin Harian + Bonus Mingguan';
        }

        if ($affiliate->current_streak > $affiliate->highest_streak) {
            $affiliate->highest_streak = $affiliate->current_streak;
        }

        $affiliate->points += $pointsEarned;
        $affiliate->last_claim_date = $today;
        $affiliate->save();

        \App\Models\AffiliatePointHistory::create([
            'affiliate_id' => $affiliate->id,
            'points_earned' => $pointsEarned,
            'description' => $description,
        ]);

        return redirect()->back()->with('success', 'Berhasil klaim ' . $pointsEarned . ' poin! Streak Anda: ' . $affiliate->current_streak . ' hari.');
    }

    public function streak(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        $today = now()->format('Y-m-d');
        $yesterday = now()->subDay()->format('Y-m-d');
        $streak = $affiliate->current_streak;

        if ($affiliate->last_claim_date !== $today && $affiliate->last_claim_date !== $yesterday) {
            $streak = 0;
        }

        $currentWeekDay = $streak % 7;
        if ($currentWeekDay == 0 && $streak > 0) {
            $currentWeekDay = 7;
        }

        return view('affiliate.streak_mobile', compact('affiliate', 'streak', 'currentWeekDay', 'today'));
    }

    public function store(Request $request)
    {
        return view('affiliate.scalify_store');
    }

    public function guide()
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        return view('affiliate.guide', compact('affiliate'));
    }

    public function trackClick(Request $request)
    {
        $code = $request->cookie('affiliate_ref') ?? $request->input('ref');

        if ($code) {
            $affiliate = Affiliate::where('affiliate_code', $code)->first();
            if ($affiliate) {
                AffiliateClick::create([
                    'affiliate_id' => $affiliate->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function profile()
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        return view('affiliate.profile', compact('affiliate'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliates,email,' . $affiliate->id,
            'bank_info' => 'nullable|string',
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072' // 3MB Max
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'bank_info' => $request->bank_info,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($affiliate->avatar && Storage::disk('public')->exists($affiliate->avatar)) {
                Storage::disk('public')->delete($affiliate->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars/affiliates', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $affiliate->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function markNotificationRead($id)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $notification = $affiliate->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

    public function clearNotifications()
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $affiliate->notifications()->delete();

        return redirect()->back();
    }

    public function proposals(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard')->with('error', 'Akun Anda belum disetujui.');
        }

        // Force affiliate to create at least one personal chat template before accessing proposals
        $hasTemplates = \App\Models\ChatTemplate::where('affiliate_id', $affiliate->id)->exists();
        if (!$hasTemplates) {
            return redirect()->route('affiliate.chat_templates.index')->with('error', 'Silakan buat minimal satu Template Chat pribadi terlebih dahulu sebelum membagikan proposal.');
        }

        $tab = $request->get('tab', 'global'); // 'global' or 'follow_up'

        $query = \Illuminate\Support\Facades\DB::table('client_proposals')
            ->leftJoin('business_categories', 'client_proposals.business_category_id', '=', 'business_categories.id')
            ->select('client_proposals.*', 'business_categories.name as category_name')
            ->orderByDesc('client_proposals.created_at');

        if ($request->filled('category_id')) {
            $query->where('client_proposals.business_category_id', $request->category_id);
        }

        if ($tab === 'follow_up') {
            $query->where('client_proposals.affiliate_id', $affiliate->id);
        } else {
            $query->whereNull('client_proposals.affiliate_id');
        }

        $proposals = $query->simplePaginate(10)->withQueryString();
        $categories = \Illuminate\Support\Facades\DB::table('business_categories')->get();

        $chatTemplates = \Illuminate\Support\Facades\DB::table('chat_templates')
            ->whereNull('affiliate_id')
            ->orWhere('affiliate_id', $affiliate->id)
            ->get();

        return view('affiliate.proposals_mobile', compact('affiliate', 'proposals', 'categories', 'chatTemplates', 'tab'));
    }

    public function generateProposal(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard')->with('error', 'Akun Anda belum disetujui.');
        }

        $request->validate([
            'business_category_id' => 'required|exists:business_categories,id',
            'brand_name' => 'required|string|max:255',
            'wa_number' => 'required|string|max:20',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->brand_name);

        // Ensure slug is unique
        if (ClientProposal::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        ClientProposal::create([
            'business_category_id' => $request->business_category_id,
            'brand_name' => $request->brand_name,
            'slug' => $slug,
            'wa_number' => $request->wa_number,
            'project_price' => 4500000,
            'domain_price' => 1200000,
            'affiliate_id' => $affiliate->id,
            'status' => 'contacted',
        ]);

        return redirect()->back()->with('success', 'Website & Proposal berhasil dibuat!');
    }

    public function magicLogin(Request $request, Affiliate $affiliate)
    {
        if (!$request->hasValidSignature()) {
            return redirect()->route('affiliate.login')->with('error', 'Link akses Magic Login sudah kedaluwarsa atau tidak valid.');
        }

        if ($affiliate->status === 'rejected') {
            return redirect()->route('affiliate.login')->with('error', 'Akun Partner Anda telah dinonaktifkan/ditolak.');
        }

        // Set parameter kedua ke true agar 'Remember Me' aktif permanen (5 tahun)
        Auth::guard('affiliate')->login($affiliate, true);

        return redirect()->route('affiliate.dashboard')->with('success', 'Selamat datang kembali, ' . $affiliate->name . '!');
    }

    public function magicLoginQr()
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard');
        }

        $magicLoginUrl = \Illuminate\Support\Facades\URL::signedRoute('affiliate.magic_login', ['affiliate' => $affiliate->id]);

        return view('affiliate.magic_login_qr', compact('affiliate', 'magicLoginUrl'));
    }

    public function claimProposal(Request $request, $id)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $proposal = ClientProposal::findOrFail($id);

        if ($proposal->affiliate_id === null) {
            $proposal->affiliate_id = $affiliate->id;
            $proposal->status = 'contacted';
            $proposal->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Proposal sudah diklaim.'], 403);
    }

    public function generateAiChat(Request $request, $id)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $proposal = \App\Models\ClientProposal::findOrFail($id);

        $profileLink = "https://scalifyintellegence.my.id/sobat-scalify?ref=" . $affiliate->affiliate_code;
        $landingPageUrl = route('landing.dynamic', $proposal->slug) . '?ref=' . $affiliate->affiliate_code;
        $proposalUrl = route('proposal.dynamic', $proposal->slug) . '?ref=' . $affiliate->affiliate_code;

        $prompt = "Kamu adalah seorang UX Copywriter dan Content Strategist B2B profesional.\n";
        $prompt .= "Buatkan 1 pesan WhatsApp yang soft-selling, profesional namun ramah, menarik, dan pendek (maksimal 3-4 kalimat) untuk menawarkan solusi digital / website ke sebuah bisnis atau perusahaan.\n";
        $prompt .= "Informasi Prospek Bisnis:\n";
        $prompt .= "- Nama Bisnis/Brand: " . ($proposal->brand_name ?? 'Bapak/Ibu') . "\n";
        $prompt .= "- Kategori Bisnis: " . ($proposal->category->name ?? 'Bisnis') . "\n";
        $prompt .= "- Nama Saya (Pengirim): " . ($affiliate->name) . "\n\n";
        $prompt .= "Instruksi Khusus:\n";
        $prompt .= "1. Tawarkan solusi digital/website untuk membantu bisnis mereka berkembang, buat agar terkesan personal dan relevan dengan kategori bisnis mereka.\n";
        $prompt .= "2. Sertakan link landing page khusus untuk mereka ini di dalam pesan: " . $landingPageUrl . "\n";
        $prompt .= "3. Opsional, sertakan link proposal PDF jika dirasa pas: " . $proposalUrl . "\n";
        $prompt .= "4. Sertakan link profil ini di akhir pesan agar mereka lebih percaya: " . $profileLink . "\n";
        $prompt .= "5. Jangan berikan opsi, jangan tambahkan karakter markdown seperti bintang (**) atau pembuka/penutup, langsung berikan isi teksnya saja agar bisa langsung dikirim via WhatsApp.";

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
