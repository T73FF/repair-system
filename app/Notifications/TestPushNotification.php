<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TestPushNotification extends Notification
{
    protected string $title;
    protected string $body;
    protected ?string $url;

    public function __construct(string $title = 'Тест уведомления', string $body = 'Это тестовое push-уведомление', ?string $url = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
    }

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(object $notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('/images/icons/icon-192x192.png')
            ->body($this->body)
            ->action('Открыть', 'open_app')
            ->data(['url' => $this->url ?? '/client/dashboard'])
            ->options(['TTL' => 600]); // живёт 10 минут
    }
}