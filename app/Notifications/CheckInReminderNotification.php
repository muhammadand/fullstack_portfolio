<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class CheckInReminderNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Waktunya Check-in Harian!')
            ->icon(url('/scalify.png'))
            ->body('Anda belum menyalakan API (check-in) hari ini. Yuk check-in sekarang untuk mulai melacak klik dan dapatkan poin!')
            ->action('Buka Dashboard', 'open')
            ->data(['url' => route('affiliate.dashboard')]);
    }
}
