<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'serial_number',
        'slug',
        'activation_code',
        'business_name',
        'google_review_url',
        'status',
        'buy_price',
        'payment_status',
        'purchased_at',
        'owner_name',
        'owner_phone',
        'total_scans',
        'activated_at',
        'notes',
    ];

    protected $casts = [
        'total_scans' => 'integer',
        'buy_price' => 'integer',
        'activated_at' => 'datetime',
        'purchased_at' => 'datetime',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Helper to get full scan URL
     */
    public function getScanUrlAttribute(): string
    {
        return url('/r/' . $this->slug);
    }
}
