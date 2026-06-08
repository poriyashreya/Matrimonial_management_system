<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StripeWebhookController extends CashierController
{

    public function handleWebhook(Request $request)
    {
        return parent::handleWebhook($request);
    }

    public function handleCheckoutSessionCompleted(array $payload)
    {
        try {

            $session = $payload['data']['object'];

            $userId = $session['metadata']['user_id'] ?? null;
            $planId = $session['metadata']['plan_id'] ?? null;

            if (!$userId || !$planId) {
                return parent::successMethod();
            }

            $user = User::find($userId);
            $plan = Plan::find($planId);

            if (!$user || !$plan) {
                return parent::successMethod();
            }

            $user->update([
                'role' => 'User',
                'plan' => $plan->name,
            ]);

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
                    'role' => 'Free',
                    'plan' => 'free',
                ]);
            }

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Invoice Payment Succeeded */
    public function handleInvoicePaymentSucceeded(array $payload)
    {
        try {

            $invoice = $payload['data']['object'];

            $user = User::where(
                'stripe_id',
                $invoice['customer']
            )->first();

            if (!$user) {
                return parent::successMethod();
            }

            $subscription = $user->subscription('default');

            if (!$subscription) {
                return parent::successMethod();
            }

            $plan = Plan::where(
                'stripe_price_id',
                $subscription->stripe_price
            )->first();

            if (!$plan) {
                return parent::successMethod();
            }

            Payment::updateOrCreate([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'stripe_payment_id' => $invoice['payment_intent'] ?? $invoice['id'],
                'amount' => ($invoice['amount_paid'] ?? 0) / 100,
                'payment_status' => 'Paid',
                'paid_at' => now(),
            ]);

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Invoice Payment Failed */
    public function handleInvoicePaymentFailed(array $payload)
    {
        try {

            $invoice = $payload['data']['object'];

            $user = User::where(
                'stripe_id',
                $invoice['customer']
            )->first();

            if (!$user) {
                return parent::successMethod();
            }

            Payment::updateOrCreate([
                'user_id' => $user->id,
                'plan_id' => null,
                'stripe_payment_id' => $invoice['id'],
                'amount' => ($invoice['amount_due'] ?? 0) / 100,
                'payment_status' => 'Failed',
                'paid_at' => null,
            ]);

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }
}