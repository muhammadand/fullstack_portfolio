<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $category
 * @property string $name
 * @property string $slug
 * @property string|null $logo
 * @property bool $is_active
 * @property int $display_order
 */
class DigitalProductBrand extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(DigitalProduct::class);
    }
}
