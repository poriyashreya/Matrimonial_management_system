<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Notifications\SubscriptionExpiryNotification;

class SubscriptionExpiryNotificationCommand extends Command
{
    protected $signature = 'subscriptions:check-expiry';

    protected $description = 'Notify users when subscription is expiring';

    public function handle()
    {
        $daysBefore = [7, 3, 1];

        foreach ($daysBefore as $days) {

            $subscriptions = Subscription::whereDate(
                'ends_at',
                Carbon::today()->addDays($days)
            )->get();

            foreach ($subscriptions as $subscription) {

                $subscription->user->notify(
                    new SubscriptionExpiryNotification($days)
                );

                $this->info(
                    "Notification sent to User ID {$subscription->user_id}"
                );
            }
        }
    }
}