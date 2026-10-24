<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateReferralCommission;
use App\Models\Commission;
use App\Notifications\AffiliateNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewCardReferralService
{
    /**
     * Konfigurasi komisi per unit kartu (maksimal 3 kedalaman level)
     * Level 1: Rp 500 per kartu
     * Level 2: Rp 250 per kartu
     * Level 3: Rp 125 per kartu
     */
    public const RATES_PER_UNIT = [
        1 => 500,
        2 => 250,
        3 => 125,
    ];

    /**
     * Distribusikan komisi referral 3 level ketika pesanan review card lunas / disetujui.
     *
     * @param int $buyerAffiliateId
     * @param int $quantity
     * @param string $orderId
     * @return array
     */
    public static function distributeCommission(int $buyerAffiliateId, int $quantity, string $orderId): array
    {
        $buyer = Affiliate::find($buyerAffiliateId);
        if (!$buyer || !$buyer->referred_by_id || $quantity <= 0) {
            return [];
        }

        // Hindari duplikasi distribusi untuk order_id yang sama
        $alreadyDistributed = AffiliateReferralCommission::where('order_id', $orderId)->exists();
        if ($alreadyDistributed) {
            return [];
        }

        $distributed = [];
        $currentUpline = $buyer->referredBy;
        $visited = [$buyer->id]; // Cegah circular loop

        for ($level = 1; $level <= 3; $level++) {
            if (!$currentUpline || in_array($currentUpline->id, $visited)) {
                break;
            }

            $visited[] = $currentUpline->id;
            $rate = self::RATES_PER_UNIT[$level] ?? 0;
            $totalAmount = $rate * $quantity;

            if ($totalAmount > 0) {
                try {
                    DB::transaction(function () use ($currentUpline, $buyer, $orderId, $level, $quantity, $rate, $totalAmount, &$distributed) {
                        // 1. Catat audit log referral
                        $refLog = AffiliateReferralCommission::create([
                            'upline_id'     => $currentUpline->id,
                            'downline_id'   => $buyer->id,
                            'order_id'      => $orderId,
                            'level'         => $level,
                            'card_quantity' => $quantity,
                            'rate_per_unit' => $rate,
                            'total_amount'  => $totalAmount,
                        ]);

                        // 2. Catat ke tabel komisi global agar muncul di riwayat mutasi
                        Commission::create([
                            'affiliate_id' => $currentUpline->id,
                            'amount'       => $totalAmount,
                            'description'  => "Bonus Referral Review Card Tier {$level} ({$quantity} Unit) dari {$buyer->name} [Pesanan #{$orderId}]",
                            'status'       => 'Paid',
                        ]);

                        // 3. Tambahkan saldo balance ke upline
                        $currentUpline->increment('balance', $totalAmount);

                        // 4. Kirim notifikasi real-time
                        $currentUpline->notify(new AffiliateNotification(
                            "Bonus Referral Tier {$level} Masuk!",
                            "Anda menerima bonus Rp " . number_format($totalAmount, 0, ',', '.') . " dari pembelian {$quantity} kartu oleh {$buyer->name} (Downline Tier {$level}).",
                            'success'
                        ));

                        $distributed[] = [
                            'upline_id'    => $currentUpline->id,
                            'upline_name'  => $currentUpline->name,
                            'level'        => $level,
                            'total_amount' => $totalAmount,
                        ];
                    });
                } catch (\Throwable $e) {
                    Log::error("Failed to distribute referral commission for order {$orderId} at level {$level}: " . $e->getMessage());
                }
            }

            // Naik ke upline berikutnya
            $currentUpline = $currentUpline->referredBy;
        }

        return $distributed;
    }

    /**
     * Ambil data statistik dan daftar downline 3 tingkat untuk satu affiliate
     */
    public static function getNetworkOverview(Affiliate $affiliate): array
    {
        // Level 1: downline langsung
        $tier1 = Affiliate::where('referred_by_id', $affiliate->id)
            ->select(['id', 'name', 'email', 'avatar', 'created_at', 'status'])
            ->get();
        $tier1Ids = $tier1->pluck('id')->toArray();

        // Level 2: downline dari Level 1
        $tier2 = !empty($tier1Ids)
            ? Affiliate::whereIn('referred_by_id', $tier1Ids)
                ->select(['id', 'name', 'email', 'avatar', 'created_at', 'status', 'referred_by_id'])
                ->get()
            : collect();
        $tier2Ids = $tier2->pluck('id')->toArray();

        // Level 3: downline dari Level 2
        $tier3 = !empty($tier2Ids)
            ? Affiliate::whereIn('referred_by_id', $tier2Ids)
                ->select(['id', 'name', 'email', 'avatar', 'created_at', 'status', 'referred_by_id'])
                ->get()
            : collect();

        // Total pendapatan referral yang sudah diperoleh
        $totalEarned = (float) AffiliateReferralCommission::where('upline_id', $affiliate->id)->sum('total_amount');

        // Total pendapatan per tier
        $earnedByTier = [
            1 => (float) AffiliateReferralCommission::where('upline_id', $affiliate->id)->where('level', 1)->sum('total_amount'),
            2 => (float) AffiliateReferralCommission::where('upline_id', $affiliate->id)->where('level', 2)->sum('total_amount'),
            3 => (float) AffiliateReferralCommission::where('upline_id', $affiliate->id)->where('level', 3)->sum('total_amount'),
        ];

        return [
            'total_earned' => $totalEarned,
            'earned_by_tier' => $earnedByTier,
            'counts' => [
                'total'  => $tier1->count() + $tier2->count() + $tier3->count(),
                'tier_1' => $tier1->count(),
                'tier_2' => $tier2->count(),
                'tier_3' => $tier3->count(),
            ],
            'tier1' => $tier1,
            'tier2' => $tier2,
            'tier3' => $tier3,
        ];
    }
}
