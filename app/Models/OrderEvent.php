<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Request;
use LogicException;

/**
 * Jejak audit order (append-only, hash berantai per order).
 *
 * - Tidak bisa di-update/di-hapus lewat Eloquent (lempar exception).
 * - hash = sha256(prev_hash | data baris); prev_hash = hash event sebelumnya untuk order yang sama.
 *   Pakai OrderEvent::verifyChain($orderId) untuk mendeteksi baris yang diubah/dihapus.
 */
class OrderEvent extends Model
{
    public const UPDATED_AT = null;

    // Event
    public const ORDER_CREATED       = 'order.created';
    public const WALLET_DEBITED      = 'wallet.debited';
    public const WALLET_REFUNDED     = 'wallet.refunded';
    public const REFUND_FAILED       = 'wallet.refund_failed';
    public const PROVIDER_SENT       = 'provider.sent';
    public const PROVIDER_SEND_FAIL  = 'provider.send_failed';
    public const PROVIDER_RESULT     = 'provider.result';
    public const NOTIFICATION_SENT   = 'notification.sent';
    public const NOTIFICATION_FAILED = 'notification.failed';

    // Aktor
    public const ACTOR_AFFILIATE = 'affiliate';
    public const ACTOR_SYSTEM    = 'system';
    public const ACTOR_DIGIFLAZZ = 'digiflazz';

    protected $guarded = ['id'];

    protected $casts = [
        'context'    => 'array',
        'amount'     => 'decimal:2',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(fn () => throw new LogicException('OrderEvent bersifat append-only dan tidak boleh diubah.'));
        static::deleting(fn () => throw new LogicException('OrderEvent bersifat append-only dan tidak boleh dihapus.'));
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }

    /**
     * Catat satu event untuk order. IP & user agent diambil dari request bila ada (HTTP),
     * kecuali diberikan eksplisit lewat $attributes.
     */
    public static function record(Order $order, string $event, array $attributes = []): self
    {
        $prevHash = static::where('order_id', $order->id)->orderByDesc('id')->value('hash');

        $row = array_merge([
            'order_id'           => $order->id,
            'order_no'           => $order->order_no,
            'event'              => $event,
            'status_from'        => null,
            'status_to'          => null,
            'amount'             => null,
            'wallet_mutation_id' => null,
            'actor_type'         => self::ACTOR_SYSTEM,
            'actor_id'           => null,
            'ip_address'         => Request::ip(),
            'user_agent'         => Request::userAgent() ? mb_substr(Request::userAgent(), 0, 255) : null,
            'context'            => null,
        ], $attributes);

        $row['created_at'] = now()->startOfSecond();
        $row['prev_hash'] = $prevHash;
        $row['hash'] = self::computeHash($row);

        return static::create($row);
    }

    /**
     * Versi best-effort untuk alur yang tidak boleh gagal karena audit (webhook, email).
     * Mutasi uang (debit/refund) WAJIB memakai record() di dalam transaksi DB yang sama (fail-closed).
     */
    public static function safeRecord(Order $order, string $event, array $attributes = []): ?self
    {
        try {
            return static::record($order, $event, $attributes);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Gagal mencatat jejak audit {$event} untuk order #{$order->order_no}.", [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /** Hash deterministik dari isi baris + hash sebelumnya. */
    public static function computeHash(array $row): string
    {
        $amount = $row['amount'] ?? null;
        $createdAt = $row['created_at'] ?? null;

        $payload = [
            'order_id'           => (int) $row['order_id'],
            'order_no'           => (string) $row['order_no'],
            'event'              => (string) $row['event'],
            'status_from'        => $row['status_from'] ?? null,
            'status_to'          => $row['status_to'] ?? null,
            'amount'             => $amount === null ? null : number_format((float) $amount, 2, '.', ''),
            'wallet_mutation_id' => isset($row['wallet_mutation_id']) ? (int) $row['wallet_mutation_id'] : null,
            'actor_type'         => (string) $row['actor_type'],
            'actor_id'           => isset($row['actor_id']) ? (int) $row['actor_id'] : null,
            'ip_address'         => $row['ip_address'] ?? null,
            'user_agent'         => $row['user_agent'] ?? null,
            'context'            => self::normalize($row['context'] ?? null),
            'created_at'         => $createdAt ? \Illuminate\Support\Carbon::parse($createdAt)->format('Y-m-d H:i:s') : null,
        ];

        return hash('sha256', ($row['prev_hash'] ?? '') . '|' . json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /** Urutkan key secara rekursif: kolom JSON MySQL tidak mempertahankan urutan key. */
    private static function normalize(mixed $value): mixed
    {
        // Angka disamakan jadi string (5253.0 dan 5253 bisa bolak-balik saat disimpan di kolom JSON).
        if (is_int($value) || is_float($value)) {
            return floor((float) $value) == (float) $value ? (string) (int) $value : (string) $value;
        }

        if (!is_array($value)) {
            return $value;
        }

        if (!array_is_list($value)) {
            ksort($value);
        }

        return array_map(fn ($v) => self::normalize($v), $value);
    }

    /**
     * Cek integritas rantai hash satu order. Return true bila tidak ada baris yang diubah/dihapus/disisipkan.
     */
    public static function verifyChain(int $orderId): bool
    {
        $prev = null;

        foreach (static::where('order_id', $orderId)->orderBy('id')->get() as $event) {
            $row = $event->getAttributes();
            $row['context'] = $event->context;

            if ($event->prev_hash !== $prev || self::computeHash($row) !== $event->hash) {
                return false;
            }

            $prev = $event->hash;
        }

        return true;
    }
}
