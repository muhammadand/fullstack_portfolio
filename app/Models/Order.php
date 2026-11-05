<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Status Order Constants
    public const STATUS_PENDING    = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SUCCESS    = 'success';
    public const STATUS_FAILED     = 'failed';
    public const STATUS_EXPIRED    = 'expired';
    public const STATUS_CANCELLED  = 'cancelled';

    // Payment Status Constants
    public const PAYMENT_UNPAID  = 'unpaid';
    public const PAYMENT_PAID    = 'paid';
    public const PAYMENT_EXPIRED = 'expired';
    public const PAYMENT_FAILED  = 'failed';

    protected $guarded = ['id'];

    protected $casts = [
        'account_data'   => 'array',
        'cost_price'     => 'decimal:2',
        'price'          => 'decimal:2',
        'admin_fee'      => 'decimal:2',
        'total_amount'   => 'decimal:2',
        'paid_at'        => 'datetime',
        'completed_at'   => 'datetime',
        'expires_at'     => 'datetime',
    ];

    /** Nomor order unik, contoh: TP-20261105-A1B2C3. */
    public static function generateOrderNo(): string
    {
        do {
            $no = 'TP-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (static::withTrashed()->where('order_no', $no)->exists());

        return $no;
    }

    /**
     * Relasi ke Customer pemesan (bisa null untuk guest checkout).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ke Produk Digital yang dipesan.
     */
    public function digitalProduct(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }

    /**
     * Helper apakah pembayaran sudah lunas.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    /**
     * Helper apakah order telah sukses terpenuhi.
     */
    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function isExpired(): bool
    {
        return !$this->isPaid() && $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Tandai lunas. Idempoten: webhook ganda tidak memproses ulang. Return true bila baru berubah menjadi paid.
     * Status order menjadi "processing" karena item belum dikirim ke akun game.
     */
    public function markAsPaid(?string $transactionId = null): bool
    {
        $changed = static::whereKey($this->id)
            ->where('payment_status', '!=', self::PAYMENT_PAID)
            ->update([
                'payment_status'    => self::PAYMENT_PAID,
                'status'            => self::STATUS_PROCESSING,
                'paid_at'           => now(),
                'payment_reference' => $transactionId ?? $this->payment_reference,
                'updated_at'        => now(),
            ]);

        $this->refresh();

        return $changed > 0;
    }

    public function markAsExpired(): void
    {
        if (!$this->isPaid()) {
            $this->update(['payment_status' => self::PAYMENT_EXPIRED, 'status' => self::STATUS_EXPIRED]);
        }
    }

    public function markAsFailed(): void
    {
        if (!$this->isPaid()) {
            $this->update(['payment_status' => self::PAYMENT_FAILED, 'status' => self::STATUS_FAILED]);
        }
    }
}
