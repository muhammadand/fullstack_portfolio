<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigiflazzWebhook extends Model
{
    use HasFactory;

    protected $table = 'digiflazz_webhooks';

    protected $fillable = [
        'event',
        'signature',
        'user_agent',
        'ip_address',
        'ref_id',
        'customer_no',
        'buyer_sku_code',
        'status',
        'rc',
        'sn',
        'price',
        'payload',
        'headers',
        'is_processed',
        'processed_at',
    ];

    protected $casts = [
        'payload'      => 'array',
        'headers'      => 'array',
        'is_processed' => 'boolean',
        'processed_at' => 'datetime',
        'price'        => 'decimal:2',
    ];
}

