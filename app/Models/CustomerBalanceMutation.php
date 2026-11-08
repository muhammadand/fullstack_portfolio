<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Mutasi saldo customer. Append-only: tidak bisa diubah/dihapus lewat model. */
class CustomerBalanceMutation extends Model
{
    public const UPDATED_AT = null;

    public const CREDIT = 'CREDIT';
    public const DEBIT = 'DEBIT';

    public const ORDER_REFUND = 'ORDER_REFUND';
    public const WITHDRAWAL = 'WITHDRAWAL';
    public const WITHDRAWAL_REVERSAL = 'WITHDRAWAL_REVERSAL';

    public const LABELS = [
        self::ORDER_REFUND        => 'Refund pesanan gagal',
        self::WITHDRAWAL          => 'Penarikan saldo',
        self::WITHDRAWAL_REVERSAL => 'Penarikan ditolak, saldo kembali',
    ];

    protected $fillable = [
        'customer_id', 'type', 'category', 'amount', 'balance_before', 'balance_after',
        'reference_type', 'reference_id', 'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2', 'balance_before' => 'decimal:2', 'balance_after' => 'decimal:2', 'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(fn () => throw new \LogicException('Mutasi saldo bersifat append-only.'));
        static::deleting(fn () => throw new \LogicException('Mutasi saldo bersifat append-only.'));
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function label(): string
    {
        return self::LABELS[$this->category] ?? $this->category;
    }
}
