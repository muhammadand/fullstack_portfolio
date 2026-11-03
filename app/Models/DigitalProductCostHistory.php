<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalProductCostHistory extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'old_cost' => 'decimal:2',
        'new_cost' => 'decimal:2',
        'changed_at' => 'datetime',
    ];
}
