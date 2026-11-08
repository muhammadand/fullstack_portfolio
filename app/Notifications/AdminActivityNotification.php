<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

/** Push ke HP admin saat ada kejadian penting (order, pendaftaran, penarikan, ...). */
class AdminActivityNotification extends Notification
{
    public function __construct(
        public string $title,
        public string $body,
        public string $url,
        public string $tag = 'admin',
    ) {
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification = null): WebPushMessage
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->body($this->body)
            ->icon('/scalify.png')
            ->tag($this->tag)
            ->data(['url' => $this->url]);
    }
}
