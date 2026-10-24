<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateReferralCommission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function upline()
    {
        return $this->belongsTo(Affiliate::class, 'upline_id');
    }

    public function downline()
    {
        return $this->belongsTo(Affiliate::class, 'downline_id');
    }
}
