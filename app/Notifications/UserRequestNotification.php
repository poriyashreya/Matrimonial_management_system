<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRequestNotification extends Notification
{
    use Queueable;

    public $message;
    public $requestId;
    public $url;

    public function __construct($message, $requestId, $url = null)
    {
        $this->message = $message;
        $this->requestId = $requestId;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'user_request',
            'message' => $this->message,
            'request_id' => $this->requestId,
            'url' => $this->url ?? route('request.index'),
        ];
    }
}