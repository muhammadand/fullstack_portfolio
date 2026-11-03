<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $lynk_slug
 * @property string|null $category
 * @property float $price
 * @property string|null $thumbnail
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $demo_url
 * @property bool $is_active
 * @property int $display_order
 * @property string $provider lynk|digiflazz
 * @property string|null $sku_code
 * @property int|null $digital_product_brand_id
 * @property float $cost_price
 * @property bool $is_missing
 * @property \Illuminate\Support\Carbon|null $last_synced_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class DigitalProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'cost_price' => 'decimal:2',
        'buyer_product_status' => 'boolean',
        'seller_product_status' => 'boolean',
        'unlimited_stock' => 'boolean',
        'multi' => 'boolean',
        'is_missing' => 'boolean',
        'stock' => 'integer',
        'raw_payload' => 'array',
        'last_synced_at' => 'datetime',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(DigitalProductBrand::class, 'digital_product_brand_id');
    }

    public function priceOverrides(): HasMany
    {
        return $this->hasMany(DigitalProductPrice::class);
    }

    public function costHistories(): HasMany
    {
        return $this->hasMany(DigitalProductCostHistory::class);
    }

    public function scopeLynk($query)
    {
        return $query->where('provider', 'lynk');
    }

    public function scopeDigiflazz($query)
    {
        return $query->where('provider', 'digiflazz');
    }

    /**
     * Produk Digiflazz yang boleh tampil ke customer (belum memperhitungkan jam cut-off).
     */
    public function scopeSellable($query)
    {
        return $query->where('provider', 'digiflazz')
            ->where('is_active', true)
            ->where('is_missing', false)
            ->where('buyer_product_status', true)
            ->where('seller_product_status', true);
    }

    /**
     * Harga jual untuk sebuah level: override manual jika ada, selain itu modal + margin level.
     * Gunakan eager load `priceOverrides` saat memanggil di dalam loop.
     */
    public function priceFor(PriceLevel $level): float
    {
        $override = $this->priceOverrides->firstWhere('price_level_id', $level->id);

        return $override
            ? (float) $override->selling_price
            : $level->applyMargin((float) $this->cost_price);
    }

    /**
     * Cek apakah sekarang masuk jam cut-off supplier. Mendukung rentang lintas tengah malam (23:40 -> 00:10).
     */
    public function isInCutOff(?Carbon $now = null): bool
    {
        if (!$this->start_cut_off || !$this->end_cut_off) {
            return false;
        }

        $now ??= now();
        $time = $now->format('H:i:s');
        $start = $this->start_cut_off;
        $end = $this->end_cut_off;

        if ($start === $end) {
            return false;
        }

        return $start < $end
            ? ($time >= $start && $time < $end)
            : ($time >= $start || $time < $end);
    }

    /**
     * Produk boleh dijual: kita aktifkan, supplier & buyer aktif, tidak hilang dari katalog, tidak sedang cut-off.
     */
    public function isSellable(?Carbon $now = null): bool
    {
        return $this->is_active
            && !$this->is_missing
            && $this->buyer_product_status
            && $this->seller_product_status
            && !$this->isInCutOff($now);
    }

    /**
     * Hitung nominal komisi berdasarkan rate affiliate tertentu (default 10%)
     */
    public function calculateCommission(?Affiliate $affiliate = null): float
    {
        $affiliate = $affiliate ?: auth('affiliate')->user();
        $rate = $affiliate && $affiliate->lynk_commission_rate ? (float)$affiliate->lynk_commission_rate : 10.00;

        return round(($this->price * $rate) / 100, 2);
    }

    /**
     * Generate link Lynk.id spesifik untuk affiliate tertentu
     */
    public function getAffiliateUrl(?Affiliate $affiliate = null): ?string
    {
        $affiliate = $affiliate ?: auth('affiliate')->user();
        if (!$affiliate || !$affiliate->lynk_id_link) {
            return null;
        }

        return rtrim($affiliate->lynk_id_link, '/') . '/' . ltrim($this->lynk_slug, '/');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->latest();
    }
}
