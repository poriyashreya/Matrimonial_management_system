<?php

namespace App\Notifications;

use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlanActivatedNotification extends Notification
{
    use Queueable;

    protected $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Activated Successfully')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your subscription has been activated successfully.')
            ->line('Activated Plan: ' . $this->plan->name)
            ->line('Thank you for your payment.')
            ->line('Enjoy all premium features available in your plan.');
    }
}