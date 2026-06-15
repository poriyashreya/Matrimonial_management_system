<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelSubscriptionNotification extends Notification
{
    use Queueable;

    protected $planName;

    public function __construct($planName)
    {
        $this->planName = $planName;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Cancelled')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your subscription has been cancelled successfully.')
            ->line('Cancelled Plan: ' . $this->planName)
            ->line('You will continue to have access until the end of your current billing period.')
            ->line('After that, your account will be switched to the Free plan.')
            ->line('Thank you for being with us.');
    }
}