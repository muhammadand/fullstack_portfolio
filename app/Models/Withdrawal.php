<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $affiliate_id
 * @property string $source
 * @property float $amount
 * @property string $bank_info
 * @property string $status
 * @property string|null $proof_of_payment
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Withdrawal extends Model
{
    public const SOURCE_COMMISSION = 'commission';
    public const SOURCE_WALLET = 'wallet';

    public const STATUS_PENDING = 'Pending';
    public const STATUS_COMPLETED = 'Completed';

    public const MIN_AMOUNT = 50000;
    public const PROCESSING_DAYS = 3;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public static function sourceLabel(?string $source): string
    {
        return $source === self::SOURCE_WALLET ? 'Saldo Wallet' : 'Saldo Komisi';
    }
}
