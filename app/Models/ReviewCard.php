<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'slug',
        'activation_code',
        'business_name',
        'google_review_url',
        'status',
        'owner_name',
        'owner_phone',
        'total_scans',
        'activated_at',
        'notes',
    ];

    protected $casts = [
        'total_scans' => 'integer',
        'activated_at' => 'datetime',
    ];

    /**
     * Helper to get full scan URL
     */
    public function getScanUrlAttribute(): string
    {
        return url('/r/' . $this->slug);
    }
}
