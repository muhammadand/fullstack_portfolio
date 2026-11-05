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

    public const STATUSES = [self::STATUS_PENDING, self::STATUS_PROCESSING, self::STATUS_SUCCESS, self::STATUS_FAILED, self::STATUS_EXPIRED, self::STATUS_CANCELLED];
    public const PAYMENT_STATUSES = [self::PAYMENT_UNPAID, self::PAYMENT_PAID, self::PAYMENT_EXPIRED, self::PAYMENT_FAILED];

    /** Label & warna badge (palet Tailwind) untuk tampilan admin. */
    public const STATUS_META = [
        'pending'    => ['Menunggu', 'amber'],
        'processing' => ['Diproses', 'blue'],
        'success'    => ['Berhasil', 'emerald'],
        'failed'     => ['Gagal', 'red'],
        'expired'    => ['Kedaluwarsa', 'slate'],
        'cancelled'  => ['Dibatalkan', 'slate'],
    ];
    public const PAYMENT_META = [
        'unpaid'  => ['Belum Bayar', 'amber'],
        'paid'    => ['Lunas', 'emerald'],
        'expired' => ['Kedaluwarsa', 'slate'],
        'failed'  => ['Gagal', 'red'],
    ];

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

    /**
     * Awalan nomor order per jenis produk. Dipakai untuk mengenali order di webhook pembayaran/Digiflazz.
     * Tambah jenis baru di sini (pulsa, listrik, dll.); alur pengiriman & status sama untuk semuanya.
     */
    public const ORDER_NO_PREFIXES = [
        'TP-'  => 'Top Up Game',
        'PL-'  => 'Pulsa & Paket Data',
        'PLN-' => 'Token Listrik PLN',
    ];

    public static function hasKnownPrefix(string $orderNo): bool
    {
        foreach (array_keys(self::ORDER_NO_PREFIXES) as $prefix) {
            if (str_starts_with($orderNo, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /** Nomor order unik, contoh: TP-20261105-A1B2C3. */
    public static function generateOrderNo(string $prefix = 'TP-'): string
    {
        if (!array_key_exists($prefix, self::ORDER_NO_PREFIXES)) {
            throw new \InvalidArgumentException("Awalan nomor order tidak dikenal: {$prefix}");
        }

        do {
            $no = $prefix . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
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

    /**
     * Terapkan hasil dari Digiflazz (webhook). Hanya order yang sudah lunas dan masih "processing"
     * yang bisa berubah, jadi webhook ulang/terlambat tidak menimpa hasil akhir.
     *
     * @return string success | failed | pending | ignored
     */
    public function applyProviderResult(string $providerStatus, ?string $sn = null, ?string $message = null): string
    {
        $new = match (strtolower($providerStatus)) {
            'sukses' => self::STATUS_SUCCESS,
            'gagal'  => self::STATUS_FAILED,
            default  => null, // Pending: belum ada hasil akhir
        };

        $query = static::whereKey($this->id)
            ->where('payment_status', self::PAYMENT_PAID)
            ->where('status', self::STATUS_PROCESSING);

        $values = ['provider_message' => $message ?? $this->provider_message, 'updated_at' => now()];
        if ($sn !== null && $sn !== '') {
            $values['sn'] = $sn;
        }

        if ($new === null) {
            $query->update($values);
            $this->refresh();

            return 'pending';
        }

        $changed = $query->update($values + [
            'status'       => $new,
            'completed_at' => $new === self::STATUS_SUCCESS ? now() : null,
        ]);
        $this->refresh();

        return $changed > 0 ? $new : 'ignored';
    }
}
