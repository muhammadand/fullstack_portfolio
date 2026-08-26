<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class DailyAffiliateReminder extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Semangat Pagi! 🚀')
            ->icon('/logo.png') // Ganti dengan logo aplikasi Anda jika ada
            ->body('Sudah cek prospek mahasiswa hari ini? Yuk bantu mereka dan kumpulkan poinmu!')
            ->action('Cek Prospek', 'check_leads')
            ->data(['url' => url('/partner/student-leads')]);
    }
}
