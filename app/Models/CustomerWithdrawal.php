<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerWithdrawal extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_REJECTED = 'rejected';

    /** status => [label, warna] */
    public const STATUS_META = [
        self::STATUS_PENDING   => ['Diproses', 'amber'],
        self::STATUS_COMPLETED => ['Selesai', 'emerald'],
        self::STATUS_REJECTED  => ['Ditolak', 'red'],
    ];

    public const EWALLETS = ['DANA', 'OVO', 'GoPay', 'ShopeePay', 'LinkAja'];

    public const FEE_PERCENT = 2;
    public const MIN_AMOUNT = 10000;

    protected $fillable = [
        'withdrawal_no', 'customer_id', 'amount', 'fee', 'net_amount', 'ewallet', 'account_no', 'account_name',
        'status', 'admin_note', 'transfer_reference', 'processed_by', 'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2', 'fee' => 'decimal:2', 'net_amount' => 'decimal:2', 'processed_at' => 'datetime',
    ];

    public static function feeFor(float $amount): float
    {
        return round($amount * self::FEE_PERCENT / 100);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function statusLabel(): string
    {
        return self::STATUS_META[$this->status][0] ?? ucfirst($this->status);
    }
}
