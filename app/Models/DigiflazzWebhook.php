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
        'is_valid_signature',
        'user_agent',
        'ip_address',
        'ref_id',
        'customer_no',
        'customer_name',
        'buyer_sku_code',
        'status',
        'message',
        'rc',
        'sn',
        'price',
        'buyer_last_saldo',
        'payload',
        'headers',
        'is_processed',
        'processed_at',
    ];

    protected $casts = [
        'payload'            => 'array',
        'headers'            => 'array',
        'is_valid_signature' => 'boolean',
        'is_processed'       => 'boolean',
        'processed_at'       => 'datetime',
        'price'              => 'decimal:2',
        'buyer_last_saldo'   => 'decimal:2',
    ];
}
