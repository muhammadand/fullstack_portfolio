<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateReferralCommission;
use App\Services\ReviewCardReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralNetworkController extends Controller
{
    /**
     * Display Partner Referral Hub & Downline Network
     */
    public function index(Request $request)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        // 1. Ambil data jaringan 3 tingkat & total earnings
        $network = ReviewCardReferralService::getNetworkOverview($affiliate);

        // 2. Ambil riwayat komisi referral yang diperoleh (audit log)
        $historyQuery = AffiliateReferralCommission::with('downline')
            ->where('upline_id', $affiliate->id)
            ->orderBy('id', 'desc');

        if ($request->filled('level') && in_array((int) $request->level, [1, 2, 3])) {
            $historyQuery->where('level', (int) $request->level);
        }

        $referralLogs = $historyQuery->paginate(10)->withQueryString();

        return view('affiliate.referrals.index', compact('affiliate', 'network', 'referralLogs'));
    }
}
