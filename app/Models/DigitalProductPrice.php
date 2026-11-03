<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Override harga jual manual per produk per level.
 */
class DigitalProductPrice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'selling_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class, 'digital_product_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(PriceLevel::class, 'price_level_id');
    }
}
