<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Affiliate;

class AffiliateController extends Controller
{
    public function index()
    {
        $affiliates = Affiliate::withCount('clicks')->latest()->get();
        
        $totalPartners = $affiliates->count();
        $totalClicks = \App\Models\AffiliateClick::count();
        $totalPending = $affiliates->where('status', 'pending')->count();
        $totalCommissions = $affiliates->sum('balance');

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
            'password' => \Hash::make($request->password),
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
        $commissions = \App\Models\Commission::where('affiliate_id', $affiliate->id)->latest()->paginate(10);
        $withdrawals = \App\Models\Withdrawal::where('affiliate_id', $affiliate->id)->latest()->paginate(10);
        
        return view('admin.affiliates.show', compact('affiliate', 'commissions', 'withdrawals'));
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

        $affiliate->increment('balance', $request->amount);

        $affiliate->notify(new \App\Notifications\AffiliateNotification(
            'Komisi Baru!', 
            'Anda mendapatkan komisi sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' (' . $request->description . ').', 
            'success'
        ));

        return back()->with('success', 'Komisi berhasil ditambahkan ke partner ' . $affiliate->name);
    }
}
