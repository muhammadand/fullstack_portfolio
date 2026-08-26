<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Affiliate;

class AffiliateController extends Controller
{
    public function index()
    {
        // Gunakan DB query langsung untuk kalkulasi statistik agar lebih cepat
        // Menggunakan DB::table dan selectRaw untuk menggabungkan 3 query menjadi 1 query agar lebih cepat
        $stats = \Illuminate\Support\Facades\DB::table('affiliates')
            ->selectRaw('COUNT(*) as total_partners')
            ->selectRaw('SUM(balance) as total_commissions')
            ->selectRaw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as total_pending')
            ->first();

        $totalPartners = $stats->total_partners ?? 0;
        $totalCommissions = $stats->total_commissions ?? 0;
        $totalPending = $stats->total_pending ?? 0;

        $totalClicks = \Illuminate\Support\Facades\DB::table('affiliate_clicks')->count();

        // Gunakan paginate() alih-alih get() untuk mencegah load ribuan data ke RAM
        $affiliates = Affiliate::withCount('clicks')->latest()->paginate(15);

        return view('admin.affiliates.index', compact('affiliates', 'totalPartners', 'totalClicks', 'totalPending', 'totalCommissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:affiliates',
            'password' => 'required|string|min:8',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        Affiliate::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'affiliate_code' => strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $request->name), 0, 4) . rand(10, 99)),
            'balance' => 0
        ]);

        return back()->with('success', 'Partner baru berhasil ditambahkan.');
    }

    public function approve(Affiliate $affiliate)
    {
        $affiliate->update(['status' => 'approved']);
        return back()->with('success', 'Partner berhasil disetujui.');
    }

    public function reject(Affiliate $affiliate)
    {
        $affiliate->update(['status' => 'rejected']);
        return back()->with('success', 'Pendaftaran partner ditolak.');
    }

    public function show(Affiliate $affiliate)
    {
        $affiliate->loadCount('clicks');
        $commissions = \App\Models\Commission::where('affiliate_id', $affiliate->id)->latest()->paginate(10, ['*'], 'komisi_page');
        $withdrawals = \App\Models\Withdrawal::where('affiliate_id', $affiliate->id)->latest()->paginate(10, ['*'], 'tarik_page');
        $chatTemplates = \App\Models\ChatTemplate::with('businessCategory')->where('affiliate_id', $affiliate->id)->latest()->get();
        $pointHistories = \App\Models\AffiliatePointHistory::where('affiliate_id', $affiliate->id)->latest()->paginate(5, ['*'], 'poin_page');

        return view('admin.affiliates.show', compact('affiliate', 'commissions', 'withdrawals', 'chatTemplates', 'pointHistories'));
    }

    public function addCommission(Request $request, Affiliate $affiliate)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'required|string|max:255'
        ]);

        \App\Models\Commission::create([
            'affiliate_id' => $affiliate->id,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'Paid' // Mark as Paid because it goes straight to balance
        ]);

        // Tambah saldo komisi
        $affiliate->increment('balance', $request->amount);

        // Tambah bonus poin (100 Poin) setiap kali deal project (komisi turun)
        $affiliate->increment('points', 100);

        // Catat di riwayat poin
        \App\Models\AffiliatePointHistory::create([
            'affiliate_id' => $affiliate->id,
            'points_earned' => 100,
            'description' => 'Bonus Closing Project: ' . $request->description,
        ]);

        $affiliate->notify(new \App\Notifications\AffiliateNotification(
            'Komisi Baru!',
            'Anda mendapatkan komisi sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' dan Bonus +100 Poin!',
            'success'
        ));

        return back()->with('success', 'Komisi dan Bonus Poin berhasil ditambahkan ke partner ' . $affiliate->name);
    }
}
