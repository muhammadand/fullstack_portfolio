<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCallback extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_callbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_number',
        'transaction_id',
        'transaction_status',
        'raw_response',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'raw_response' => 'array',
    ];

    /**
     * Get the associated booking based on order_number (matching booking_code).
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'order_number', 'booking_code');
    }

    /**
     * Scope a query to only include successful transactions.
     */
    public function scopeSuccessful($query)
    {
        return $query->whereIn('transaction_status', ['settlement', 'capture', 'success', 'paid']);
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending($query)
    {
        return $query->whereIn('transaction_status', ['pending']);
    }

    /**
     * Scope a query to only include failed or expired transactions.
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('transaction_status', ['deny', 'cancel', 'expire', 'failure']);
    }
}
