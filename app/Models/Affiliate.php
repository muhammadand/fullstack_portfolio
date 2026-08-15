<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Affiliate extends Authenticatable
{
    use HasFactory, Notifiable, HasPushSubscriptions;
    
    protected $guarded = [];
    
    public function clicks()
    {
        return $this->hasMany(AffiliateClick::class);
    }
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function pointHistories()
    {
        return $this->hasMany(AffiliatePointHistory::class);
    }
}
