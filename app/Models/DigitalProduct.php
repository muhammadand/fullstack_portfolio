<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

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
