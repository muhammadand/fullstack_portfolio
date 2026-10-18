<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    // Booking Types
    public const TYPE_REGULER = 'reguler';
    public const TYPE_CHARTER = 'charter';

    public const TYPES = [
        self::TYPE_REGULER,
        self::TYPE_CHARTER,
    ];

    // Payment Statuses
    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_REFUNDED = 'refunded';
    public const PAYMENT_CANCELLED = 'cancelled';

    public const PAYMENT_STATUSES = [
        self::PAYMENT_UNPAID,
        self::PAYMENT_PAID,
        self::PAYMENT_REFUNDED,
        self::PAYMENT_CANCELLED,
    ];

    // Booking Statuses
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'booking_code',
        'customer_id',
        'schedule_id',
        'booking_type',
        'total_passengers',
        'charter_date',
        'duration_days',
        'pickup_address',
        'dropoff_address',
        'destination_note',
        'total_amount',
        'payment_status',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'charter_date' => 'date',
        'duration_days' => 'integer',
        'total_passengers' => 'integer',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the booking.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the schedule for this booking (if reguler).
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the details / line items for this booking.
     */
    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }
}

