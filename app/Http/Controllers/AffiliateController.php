<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\AffiliateClick;
use App\Models\ClientProposal;
use App\Models\ChatTemplate;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to login using the affiliate guard
        if (Auth::guard('affiliate')->attempt($credentials)) {
            $affiliate = Auth::guard('affiliate')->user();
            
            // Check if rejected
            if ($affiliate->status === 'rejected') {
                Auth::guard('affiliate')->logout();
                return redirect()->back()->with('error', 'Akun Anda telah ditolak oleh Admin.');
            }
            
            return redirect()->route('affiliate.dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau Password salah.'])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::guard('affiliate')->logout();
        return redirect()->route('affiliate.login');
    }

    public function dashboard(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user(); 
        
        $totalClicks = AffiliateClick::where('affiliate_id', $affiliate->id)->count();
        $totalProjects = \App\Models\Project::where('affiliate_id', $affiliate->id)->count();
        
        $withdrawals = \App\Models\Withdrawal::where('affiliate_id', $affiliate->id)->latest()->take(5)->get();

        $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|Windows Phone/i', $request->userAgent());
        
        if ($isMobile) {
            return view('affiliate.dashboard_mobile', compact('affiliate', 'totalClicks', 'totalProjects', 'withdrawals'));
        }

        return view('affiliate.dashboard', compact('affiliate', 'totalClicks', 'totalProjects', 'withdrawals'));
    }

    public function history(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        $commissions = \App\Models\Commission::where('affiliate_id', $affiliate->id)
            ->latest()
            ->paginate(10, ['*'], 'komisi_page');

        $withdrawals = \App\Models\Withdrawal::where('affiliate_id', $affiliate->id)
            ->latest()
            ->paginate(10, ['*'], 'tarik_page');

        $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|Windows Phone/i', $request->userAgent());
        
        if ($isMobile) {
            return view('affiliate.history_mobile', compact('affiliate', 'commissions', 'withdrawals'));
        }

        return view('affiliate.history', compact('affiliate', 'commissions', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
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

    public function markNotificationRead($id)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $notification = $affiliate->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead();
        }
        
        return redirect()->back();
    }

    public function clearNotifications()
    {
        $affiliate = Auth::guard('affiliate')->user();
        $affiliate->notifications()->delete();
        
        return redirect()->back();
    }

    public function proposals(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard')->with('error', 'Akun Anda belum disetujui.');
        }

        $query = ClientProposal::with('category')->latest();
        
        if ($request->filled('category_id')) {
            $query->where('business_category_id', $request->category_id);
        }
        
        $proposals = $query->simplePaginate(10)->withQueryString();
        $categories = \App\Models\BusinessCategory::all();
        $chatTemplates = ChatTemplate::all();

        return view('affiliate.proposals_mobile', compact('affiliate', 'proposals', 'categories', 'chatTemplates'));
    }

    public function generateProposal(Request $request)
    {
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
        ]);

        return redirect()->back()->with('success', 'Website & Proposal berhasil dibuat!');
    }

    public function magicLogin(Request $request, Affiliate $affiliate)
    {
        if (!$request->hasValidSignature()) {
            abort(401, 'Link login sudah kedaluwarsa atau tidak valid.');
        }

        Auth::guard('affiliate')->login($affiliate);

        return redirect()->route('affiliate.dashboard')->with('success', 'Berhasil login via QR Akses.');
    }

    public function magicLoginQr()
    {
        $affiliate = Auth::guard('affiliate')->user();
        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard');
        }

        $magicLoginUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute('affiliate.magic_login', now()->addDays(7), ['affiliate' => $affiliate->id]);

        return view('affiliate.magic_login_qr', compact('affiliate', 'magicLoginUrl'));
    }
}
