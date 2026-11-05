<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoogleCardOrder extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_id',
        'customer_id',
        'business_name',
        'customer_name',
        'phone',
        'google_maps_url',
        'design_type',
        'theme',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'qris_payload',
        'qris_image_url',
        'expires_at',
        'paid_at',
        'raw_response',
        'affiliate_id',
        'review_card_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'raw_response' => 'array',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reviewCard()
    {
        return $this->belongsTo(ReviewCard::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::STATUS_PAID;
    }

    /**
     * Create and activate a corresponding ReviewCard for this order,
     * converting the google_maps_url with GoogleMapsService to placeid write review link.
     */
    public function createOrActivateReviewCard(): ReviewCard
    {
        if ($this->review_card_id && $this->reviewCard) {
            return $this->reviewCard;
        }

        // 1. Konversi Google Maps URL menjadi direct Place ID Write Review URL
        $rawUrl = trim((string) $this->google_maps_url);
        $finalReviewUrl = null;

        if (!empty($rawUrl)) {
            try {
                $finalReviewUrl = app(\App\Services\GoogleMapsService::class)->convertToWriteReviewUrl($rawUrl);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning("GoogleMapsService conversion failed for Order #{$this->order_id}: " . $e->getMessage());

                // Fallback jika berupa valid URL biasa
                if (filter_var($rawUrl, FILTER_VALIDATE_URL)) {
                    $finalReviewUrl = $rawUrl;
                }
            }
        }

        // Fallback jika belum punya link maps atau gagal: buat query pencarian Google Maps resmi
        if (empty($finalReviewUrl)) {
            $finalReviewUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($this->business_name);
        }

        // 2. Generate Serial Number unik (format standar Scalify: SCL-YYMM-XXXX)
        do {
            $serialNumber = 'SCL-' . date('ym') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
        } while (ReviewCard::where('serial_number', $serialNumber)->exists());

        // 3. Generate Slug unik untuk URL public scan: /r/{slug}
        do {
            $slug = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
        } while (ReviewCard::where('slug', $slug)->exists());

        $pin = (string) random_int(100000, 999999);
        $now = $this->paid_at ?? now();

        // 4. Create ReviewCard yang langsung ACTIVE dan berstatus Terjual (is_sold = true)
        $card = ReviewCard::create([
            'serial_number'     => $serialNumber,
            'slug'              => $slug,
            'activation_code'   => $pin,
            'business_name'     => trim($this->business_name),
            'google_review_url' => $finalReviewUrl,
            'status'            => 'active',
            'is_sold'           => true,
            'buy_price'         => (int) $this->amount,
            'payment_status'    => 'paid',
            'purchased_at'      => $now,
            'activated_at'      => $now,
            'owner_name'        => trim($this->customer_name),
            'owner_phone'       => trim($this->phone),
            'affiliate_id'      => $this->affiliate_id,
            'total_scans'       => 0,
            'notes'             => "Order #{$this->order_id} - Google Review Card Promo ({$this->design_type} / {$this->theme})",
        ]);

        $this->update(['review_card_id' => $card->id]);

        return $card;
    }

    public function markAsPaid(?string $transactionId = null, ?array $rawResponse = null): ReviewCard
    {
        $updateData = [
            'payment_status' => self::STATUS_PAID,
            'paid_at'        => now(),
        ];

        if ($transactionId) {
            $updateData['transaction_id'] = $transactionId;
        }

        if ($rawResponse) {
            $updateData['raw_response'] = $rawResponse;
        }

        $this->update($updateData);

        // Langsung buat dan aktifkan ReviewCard dengan Place ID Google Review
        return $this->createOrActivateReviewCard();
    }
}

