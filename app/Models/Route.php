<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'origin',
        'destination',
        'base_price',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    /**
     * Get the schedules for this route.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

