<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $margin_type percent|fixed
 * @property float $margin_value
 * @property bool $is_default
 */
class PriceLevel extends Model
{
    public const RETAIL = 'retail';
    public const PARTNER = 'partner';

    protected $guarded = [];

    protected $casts = [
        'margin_value' => 'decimal:2',
        'is_default' => 'boolean',
    ];

    public function affiliates(): HasMany
    {
        return $this->hasMany(Affiliate::class);
    }

    public static function retail(): ?self
    {
        return static::where('code', self::RETAIL)->first();
    }

    /**
     * Terapkan margin level ini ke harga modal.
     */
    public function applyMargin(float $cost): float
    {
        $margin = $this->margin_type === 'fixed'
            ? (float) $this->margin_value
            : $cost * (float) $this->margin_value / 100;

        return round($cost + $margin, 2);
    }
}
