<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $guarded = [];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
