<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvReview extends Model
{
    protected $fillable = [
        'name',
        'role',
        'rating',
        'note',
        'ip_address',
        'is_featured',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
    ];
}
