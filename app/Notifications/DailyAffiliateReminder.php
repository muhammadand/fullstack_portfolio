<?php

namespace App\Notifications;

use App\Models\ClientProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DailyAffiliateReminder extends Notification
{
    use Queueable;

    public $proposal;

    /**
     * Inisialisasi notifikasi.
     * Dapat menerima objek ClientProposal spesifik atau mengambil bisnis terbaru secara otomatis.
     *
     * @param ClientProposal|null $proposal
     */
    public function __construct($proposal = null)
    {
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification = null)
    {
        $proposal = $this->getResolvedProposal();

        if ($proposal) {
            $brand = $proposal->brand_name;
            $phone = $proposal->wa_number ?? 'Nomor Tersedia';
            $title = "Nomor Bisnis Baru Masuk: {$brand}";
            $body = "Nomor bisnis baru ditambahkan: {$brand} ({$phone}). Yuk tawarkan Google Review Card sekarang. Produk mudah closing & komisi instan sebelum diambil partner lain.";
            $targetUrl = route('affiliate.review_proposals', [
                'tab' => 'global',
                'search' => $brand,
            ]);
            $actionLabel = 'Tawarkan Sekarang';
        } else {
            $title = 'Peluang Cuan Google Review Card';
            $body = 'Ada nomor bisnis baru ditambahkan ke sistem. Yuk tawarkan Smart Google Review Card (Tap NFC & QR Standee) dan amankan komisimu hari ini.';
            $targetUrl = route('affiliate.review_proposals', ['tab' => 'global']);
            $actionLabel = 'Cek Nomor Bisnis';
        }

        return (new WebPushMessage)
            ->title($title)
            ->body($body)
            ->action($actionLabel, 'offer_review_card')
            ->data(['url' => $targetUrl]);
    }

    /**
     * Resolusi data bisnis yang baru saja ditambahkan.
     * Mengutamakan bisnis yang belum diklaim untuk produk Google Review Card.
     */
    protected function getResolvedProposal(): ?ClientProposal
    {
        if ($this->proposal instanceof ClientProposal) {
            return $this->proposal;
        }

        // Cari bisnis terbaru yang memiliki nomor WA dan belum ditawari review card oleh affiliate manapun
        $proposal = ClientProposal::whereNotNull('wa_number')
            ->where('wa_number', '!=', '')
            ->whereDoesntHave('offerings', function ($q) {
                $q->where('product_type', 'review_card');
            })
            ->latest('id')
            ->first();

        // Fallback ke bisnis terbaru dengan nomor WA jika seluruh leads telah diklaim
        if (!$proposal) {
            $proposal = ClientProposal::whereNotNull('wa_number')
                ->where('wa_number', '!=', '')
                ->latest('id')
                ->first();
        }

        return $proposal;
    }

    public function toArray($notifiable)
    {
        $proposal = $this->getResolvedProposal();

        return [
            'type' => 'daily_review_card_lead_reminder',
            'proposal_id' => $proposal?->id,
            'brand_name' => $proposal?->brand_name,
            'wa_number' => $proposal?->wa_number,
            'url' => route('affiliate.review_proposals', ['tab' => 'global']),
        ];
    }
}
