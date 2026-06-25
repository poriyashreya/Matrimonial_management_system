<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Payment;
use App\Models\Plan;
use App\Notifications\PlanActivatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandlePaymentIntentSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $payload)
    {
    }

    public function handle(): void
    {
        $paymentIntent = $this->payload['data']['object'];

        $user = User::where('stripe_id', $paymentIntent['customer'])->first();

        if (!$user) {
            return;
        }

        $payment = Payment::where('user_id', $user->id)
            ->where('payment_status', 'Pending')
            ->latest()
            ->first();

        if ($payment) {
            $payment->update([
                'stripe_payment_id' => $paymentIntent['id'],
                'payment_status' => 'Paid',
                'amount' => ($paymentIntent['amount_received'] ?? 0) / 100,
                'paid_at' => now(),
            ]);

            $plan = Plan::find($payment->plan_id);

            if ($plan) {
                // $user->notify(new PlanActivatedNotification($plan));
            }
        }
    }
}