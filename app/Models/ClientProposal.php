<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProposal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function getSilverPriceAttribute()
    {
        return $this->price_silver ?? 700000;
    }

    public function getGoldPriceAttribute()
    {
        return $this->price_gold ?? 1600000;
    }

    public function getDiamondPriceAttribute()
    {
        return $this->price_diamond ?? 2000000;
    }

    public function getPlatinumPriceAttribute()
    {
        return $this->price_platinum ?? 3000000;
    }

    public function getSilverRenewalAttribute()
    {
        return $this->renewal_silver ?: '500rb/tahun';
    }

    public function getGoldRenewalAttribute()
    {
        return $this->renewal_gold ?: '600rb/tahun';
    }

    public function getDiamondRenewalAttribute()
    {
        return $this->renewal_diamond ?: '1juta/tahun';
    }

    public function getPlatinumRenewalAttribute()
    {
        return $this->renewal_platinum ?: '50% per tahun';
    }

    public static function formatPackagePill($price)
    {
        if ($price >= 1000000) {
            $formatted = number_format($price / 1000000, ($price % 1000000 === 0) ? 0 : 1, ',', '.');
            return "IDR " . $formatted . ($price % 1000000 === 0 ? "JUTA" : " JUTA");
        } elseif ($price >= 1000) {
            return "IDR. " . ($price / 1000) . "K";
        }
        return "IDR " . number_format($price, 0, ',', '.');
    }
}
