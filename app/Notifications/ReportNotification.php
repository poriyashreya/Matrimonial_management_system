<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportNotification extends Notification
{
    use Queueable;

    public $message;
    public $reportId;

    public function __construct($message, $reportId)
    {
        $this->message = $message;
        $this->reportId = $reportId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'report_id' => $this->reportId,
        ];
    }
}
