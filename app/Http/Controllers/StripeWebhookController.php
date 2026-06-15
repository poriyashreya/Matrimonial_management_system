<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PlanActivatedNotification;
use function Laravel\Prompts\notify;

class StripeWebhookController extends CashierController
{

    public function handleWebhook(Request $request)
    {
        return parent::handleWebhook($request);
    }

    public function handleCheckoutSessionCompleted(array $payload)
    {
        \Log::info("this is checkout session");
        \Log::info(json_encode($payload));
        $session = $payload['data']['object'];

        try {
            if (isset($session['metadata']['upgrade'])) {
                if (
                    $session['metadata']['upgrade'] === "true" ||
                    $session['metadata']['upgrade'] === true
                ) {

                    \Log::info('Upgrade' . $session['metadata']['upgrade']);

                    $user = User::find(
                        $session['metadata']['user_id']
                    );

                    $plan = Plan::find(
                        $session['metadata']['plan_id']
                    );

                    if ($user && $plan) {

                        $subscription =
                            $user->subscription('default');

                        if ($subscription) {

                            $subscription->swap(
                                $plan->stripe_price_id
                            );
                        }

                        $user->update([
                            'role' => 'User',
                            'plan' => $plan->name,
                        ]);

                        Payment::create([
                            'user_id' => $user->id,
                            'plan_id' => $plan->id,
                            'stripe_payment_id' =>
                                $session['payment_intent'],
                            'amount' =>
                                ($session['amount_total'] ?? 0) / 100,
                            'payment_status' => 'Paid',
                            'paid_at' => now(),
                        ]);

                        if ($plan) {
                            $user->notify(new PlanActivatedNotification($plan));
                        }

                    }

                    return parent::successMethod();
                } else {

                    $session = $payload['data']['object'];

                    $userId = $session['metadata']['user_id'] ?? null;
                    $planId = $session['metadata']['plan_id'] ?? null;

                    if (!$userId || !$planId) {
                        return parent::successMethod();
                    }

                    \Log::info('user_id' . $session['metadata']['user_id']);

                    $user = User::find($userId);
                    $plan = Plan::find($planId);

                    if (!$user || !$plan) {
                        return parent::successMethod();
                    }

                    // CREATE PENDING PAYMENT
                    Payment::create([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'stripe_payment_id' => $session['id'],
                        'amount' => 0,
                        'payment_status' => 'Pending',
                        'paid_at' => null,
                        'failure_reason' => null,
                    ]);



                    $user->update([
                        'role' => 'User',
                        'plan' => $plan->name,
                    ]);

                }
            }

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Subscription Deleted */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        try {

            $subscription = $payload['data']['object'];

            $user = User::where(
                'stripe_id',
                $subscription['customer']
            )->first();

            if ($user) {

                $user->update([
                    'role' => 'User',
                    'plan' => 'free',
                ]);
            }

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Invoice Payment Succeeded */
    public function handlePaymentIntentSucceeded(array $payload)
    {

        $paymentIntent = $payload['data']['object'];

        try {

            $user = User::where('stripe_id', $paymentIntent['customer'])->first();

            if (!$user)
                return parent::successMethod();

            $payment = Payment::where('user_id', $user->id)
                ->where('payment_status', 'Pending')
                ->latest()
                ->first();

            \Log::info('Payment', [
                'payment_id' => $payment
            ]);

            if ($payment) {
                $payment->update([
                    'stripe_payment_id' => $paymentIntent['id'],
                    'payment_status' => 'Paid',
                    'amount' => ($paymentIntent['amount_received'] ?? 0) / 100,
                    'paid_at' => now(),
                ]);
            }

            $plan = Plan::find($payment->plan_id);

            if ($plan) {
                $user->notify(new PlanActivatedNotification($plan));
            }


            \Log::info('Payment updated successfully');

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return parent::successMethod();
    }

    /* Invoice Payment Failed */
    public function handleInvoicePaymentFailed(array $payload)
    {
        try {

            $invoice = $payload['data']['object'];

            $user = User::where('stripe_id', $invoice['customer'])->first();

            if (!$user) {
                return parent::successMethod();
            }

            Payment::updateOrCreate(
                [
                    'stripe_payment_id' => $invoice['payment_intent'] ?? $invoice['id']
                ],
                [
                    'user_id' => $user->id,
                    'plan_id' => null,
                    'amount' => ($invoice['amount_due'] ?? 0) / 100,
                    'payment_status' => 'Failed',
                    'failure_reason' =>
                        $invoice['last_finalization_error']['message']
                        ?? 'Payment failed',
                    'paid_at' => null,
                ]
            );

            $user->notify(new PaymentFailedNotification());

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }
}