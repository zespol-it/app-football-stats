<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->body($this->body)
            ->icon('/pwa/icons/icon-192x192.png')
            ->badge('/pwa/icons/badge-72x72.png')
            ->action('Otwórz', 'open')
            ->data(['url' => '/dashboard']);
    }
} 