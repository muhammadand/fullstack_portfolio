<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $deposit_no
 * @property int $affiliate_id
 * @property int $wallet_id
 * @property float $amount
 * @property float $fee
 * @property int $unique_code
 * @property float $total_amount
 * @property string $payment_method
 * @property string $payment_status
 * @property string|null $payment_reference
 * @property string|null $payment_url
 * @property array|null $gateway_response
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class WalletDeposit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'unique_code' => 'integer',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Tandai deposit sudah dibayar secara atomik dan idempoten (Anti Double-Credit)
     */
    public function markAsPaid(?string $reference = null, ?array $gatewayResponse = null): bool
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($reference, $gatewayResponse) {
            // Kunci baris deposit dengan lockForUpdate untuk mencegah race condition (misal webhook retries simultan)
            $lockedDeposit = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

            if ($lockedDeposit->payment_status === 'paid') {
                return false; // Idempoten: sudah pernah diproses sebelumnya
            }

            $lockedDeposit->payment_status = 'paid';
            $lockedDeposit->paid_at = now();
            if ($reference) {
                $lockedDeposit->payment_reference = $reference;
            }
            if ($gatewayResponse) {
                $lockedDeposit->gateway_response = $gatewayResponse;
            }
            $lockedDeposit->save();

            // Perbarui state instance saat ini
            $this->payment_status = 'paid';
            $this->paid_at = $lockedDeposit->paid_at;
            if ($reference) {
                $this->payment_reference = $reference;
            }

            // Ambil wallet dan kreditkan saldo secara atomik
            $wallet = Wallet::where('id', $lockedDeposit->wallet_id)->firstOrFail();
            $wallet->credit(
                (float) $lockedDeposit->amount,
                'DEPOSIT',
                "Top up saldo via {$lockedDeposit->payment_method} #{$lockedDeposit->deposit_no}",
                $lockedDeposit
            );

            return true;
        });
    }

    /**
     * Tandai deposit kadaluwarsa secara aman jika masih berstatus pending
     */
    public function markAsExpired(?array $gatewayResponse = null): bool
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($gatewayResponse) {
            $locked = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

            if ($locked->payment_status !== 'pending') {
                return false; // Idempoten: jangan ubah jika sudah paid, expired, atau failed
            }

            $locked->payment_status = 'expired';
            if ($gatewayResponse) {
                $locked->gateway_response = $gatewayResponse;
            }
            $locked->save();

            $this->payment_status = 'expired';
            return true;
        });
    }

    /**
     * Tandai deposit gagal atau dibatalkan jika masih berstatus pending
     */
    public function markAsFailed(string $reason = 'failed', ?array $gatewayResponse = null): bool
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($reason, $gatewayResponse) {
            $locked = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

            if ($locked->payment_status !== 'pending') {
                return false; // Idempoten: jangan sentuh jika sudah paid
            }

            $locked->payment_status = 'failed';
            $locked->notes = $reason;
            if ($gatewayResponse) {
                $locked->gateway_response = $gatewayResponse;
            }
            $locked->save();

            $this->payment_status = 'failed';
            return true;
        });
    }
}

