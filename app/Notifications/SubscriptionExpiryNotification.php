<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionExpiryNotification extends Notification
{
    use Queueable;

    protected $daysLeft;

    public function __construct($daysLeft)
    {
        $this->daysLeft = $daysLeft;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Subscription Expiring Soon')
            ->greeting('Hello ' . $notifiable->name)
            ->line("Your subscription will expire in {$this->daysLeft} day(s).")
            ->action('Renew Subscription', url('/plans'))
            ->line('Renew now to continue enjoying premium features.');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Subscription Expiring Soon',
            'message' => "Your subscription will expire in {$this->daysLeft} day(s).",
        ];
    }
}