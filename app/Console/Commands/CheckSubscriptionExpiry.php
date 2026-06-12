<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Payment;
use App\Notifications\SubscriptionExpiryNotification;

class CheckSubscriptionExpiry extends Command
{
    protected $signature = 'subscription:check-expiry';

    protected $description = 'Check subscription expiry from payments and notify users';

    public function handle()
    {
        // Get only successful payments
        $payments = Payment::where('status', 'success')->get();

        foreach ($payments as $payment) {

            // Subscription expiry = payment date + 1 month
            $expiryDate = Carbon::parse($payment->created_at)->addMonth();

            // Calculate remaining days
            $daysLeft = Carbon::now()->diffInDays($expiryDate, false);

            // Notify user 3 days before expiry
            if ($daysLeft == 3) {

                $payment->user->notify(
                    new SubscriptionExpiryNotification(3)
                );
            }
        }

        $this->info('Subscription expiry check completed successfully');
    }
}