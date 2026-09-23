<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvPageVisit extends Model
{
    protected $fillable = [
        'visited_at',
        'ip_address',
        'user_agent',
        'device_type',
        'referer',
    ];

    protected $casts = [
        'visited_at' => 'date',
    ];
}
