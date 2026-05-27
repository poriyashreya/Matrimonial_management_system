<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRequestNotification extends Notification
{
    use Queueable;

    public $message;
    public $requestId;

    public function __construct($message, $requestId)
    {
        $this->message = $message;
        $this->requestId = $requestId;
    }

    public function via($notifiable)
    {
        return ['database']; // later you can add 'mail'
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'request_id' => $this->requestId,
            'url' => $this->url ?? route('request.index'), // 👈 fallback
        ];
    }

}
