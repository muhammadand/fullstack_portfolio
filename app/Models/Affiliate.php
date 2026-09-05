<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $avatar
 * @property string $password
 * @property string $affiliate_code
 * @property string|null $lynk_id_link
 * @property float $lynk_commission_rate
 * @property float $balance
 * @property string|null $bank_info
 * @property string $status
 * @property int $points
 * @property int $streak_count
 * @property string|null $last_activity_date
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method \NotificationChannels\WebPush\PushSubscription updatePushSubscription($endpoint, $key = null, $token = null, $contentEncoding = null)
 */
class Affiliate extends Authenticatable
{
    use HasFactory, Notifiable, HasPushSubscriptions;

    protected $guarded = [];

    protected $casts = [
        'lynk_commission_rate' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

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

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'affiliate_id');
    }

    /**
     * Generate link Lynk.id spesifik untuk produk digital tertentu
     * 
     * @param \App\Models\DigitalProduct|string $productOrSlug
     * @return string|null
     */
    public function getLynkProductUrl($productOrSlug): ?string
    {
        if (!$this->lynk_id_link) {
            return null;
        }

        $slug = $productOrSlug instanceof DigitalProduct
            ? ($productOrSlug->lynk_slug ?: $productOrSlug->slug)
            : $productOrSlug;

        return rtrim($this->lynk_id_link, '/') . '/' . ltrim($slug, '/');
    }
}
