<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    // Service Types
    public const SERVICE_TYPE_REGULER = 'reguler';
    public const SERVICE_TYPE_PREMIUM_SOPIR = 'premium_sopir';

    public const SERVICE_TYPES = [
        self::SERVICE_TYPE_REGULER,
        self::SERVICE_TYPE_PREMIUM_SOPIR,
    ];

    // Statuses
    public const STATUS_WAITING_QUOTA = 'waiting_quota';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_DEPARTED = 'departed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_WAITING_QUOTA,
        self::STATUS_CONFIRMED,
        self::STATUS_DEPARTED,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'route_id',
        'departure_date',
        'departure_time',
        'service_type',
        'min_quota',
        'status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'min_quota' => 'integer',
    ];

    /**
     * Get the route for this schedule.
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Get the bookings for this schedule.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
