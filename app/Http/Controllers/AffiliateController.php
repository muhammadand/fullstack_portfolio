<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\AffiliateClick;
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
}
