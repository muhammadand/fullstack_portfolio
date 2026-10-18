<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetail extends Model
{
    use HasFactory, SoftDeletes;

    // Item Types
    public const ITEM_TYPE_SEAT = 'seat';
    public const ITEM_TYPE_CHARTER_UNIT = 'charter_unit';
    public const ITEM_TYPE_EXTRA_CHARGE = 'extra_charge';

    public const ITEM_TYPES = [
        self::ITEM_TYPE_SEAT,
        self::ITEM_TYPE_CHARTER_UNIT,
        self::ITEM_TYPE_EXTRA_CHARGE,
    ];

    protected $fillable = [
        'booking_id',
        'item_type',
        'item_name',
        'seat_number',
        'passenger_name',
        'passenger_phone',
        'pickup_point',
        'drop_point',
        'price',
        'qty',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the booking that owns this detail item.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

