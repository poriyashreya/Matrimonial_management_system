<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\RefundProcessedMail;
use App\Notifications\CancelSubscriptionNotification;

class SubscriptionController extends Controller
{
    public function plans()
    {
        // Fetch active plans
        $plans = Plan::where('status', 1)
            ->orderBy('price', 'asc')
            ->get();

        $rating_status = "nothing";

        $user = auth()->user();

        if ($user) {

            $rating = DB::table('ratings')
                ->where('user_id', $user->id)
                ->latest('updated_at')
                ->first();

            // Never rated before
            if (!$rating) {

                $rating_status = "show";

            } else {

                // User already rated
                if ($rating->status == "rated") {

                    if (
                        Carbon::parse($rating->updated_at)
                            ->lte(now()->subDays(30))
                    ) {

                        $rating_status = "show";

                    } else {

                        $rating_status = "nothing";
                    }
                }

                // User skipped
                elseif ($rating->status == "skipped") {

                    if (
                        Carbon::parse($rating->updated_at)
                            ->lte(now()->subDays(3))
                    ) {

                        $rating_status = "show";

                    } else {

                        $rating_status = "nothing";
                    }
                }

                // User cancelled popup
                elseif ($rating->status == "cancelled") {

                    if (
                        Carbon::parse($rating->updated_at)
                            ->lte(now()->subDays(1))
                    ) {

                        $rating_status = "show";

                    } else {

                        $rating_status = "nothing";
                    }
                } elseif ($rating->status === "pending") {
                    $rating_status = "show";
                }
            }
        }

        return view('subscription.plans', compact('plans', 'rating_status'));
    }

    public function checkout($id)
    {
        $plan = Plan::findOrFail($id);

        $user = auth()->user();

        $subscription = $user->subscription('default');

        // Create pending payment FIRST
        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'stripe_payment_id' => "Stripe_session",
            'amount' => 0,
            'payment_status' => 'Pending',
            'paid_at' => null,
        ]);


        if ($subscription && $subscription->active()) {

            $currentPlan = Plan::where(
                'stripe_price_id',
                $subscription->stripe_price
            )->first();

            if (
                $currentPlan &&
                strtolower($currentPlan->name) === 'premium' &&
                strtolower($plan->name) === 'pro'
            ) {

                return redirect()
                    ->route(
                        'upgrade.checkout',
                        $plan->id
                    );
            }
        }

        return $user
            ->newSubscription(
                'default',
                $plan->stripe_price_id
            )
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('subscription.cancel'),

                'metadata' => [
                    'payment_id' => $payment->id,
                    'upgrade' => false,
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'type' => $plan->name,
                ],
            ]);
    }

    public function previewUpgrade(Plan $plan)
    {
        try {

            $user = auth()->user();

            $subscription = $user->subscription('default');

            if (!$subscription && strtolower($user->plan) !== 'free') {

                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found.'
                ]);
            }

            $currentPlan = Plan::where(
                'name',
                $user->plan
            )->first();

            if (!$currentPlan) {

                return response()->json([
                    'success' => false,
                    'message' => 'Current plan not found.'
                ]);
            }

            if (strtolower($user->plan) === 'free') {

                return response()->json([
                    'success' => true,
                    'credit' => 0,
                    'amount_due' => $plan->price,
                    'new_plan' => $plan->name,
                ]);
            }


            $startDate = Carbon::parse(
                $subscription->created_at
            );

            $endDate = $startDate->copy()->addMonth();

            $totalDays = $startDate->diffInDays($endDate);

            $remainingDays = max(
                now()->diffInDays($endDate, false),
                0
            );

            $credit =
                ($currentPlan->price / $totalDays)
                * $remainingDays;

            $newPlanCost =
                ($plan->price / $totalDays)
                * $remainingDays;

            $amountDue =
                max($plan->price - $credit, 0);

            if (strtolower($user->plan) === 'free') {

                return response()->json([
                    'success' => true,
                    'credit' => 0,
                    'amount_due' => $plan->price,
                    'new_plan' => $plan->name,
                ]);
            }

            return response()->json([
                'success' => true,
                'credit' => round($credit, 2),
                'amount_due' => round($amountDue, 2),
                'new_plan' => $plan->name,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function upgradeCheckout($id)
    {
        $plan = Plan::findOrFail($id);

        $user = auth()->user();

        $subscription = $user->subscription('default');

        $isplan = $user->plan;

        if (!$isplan) {
            return back()->with('error', 'No active subscription found.');
        }

        $currentPlan = Plan::where(
            'name',
            $user->plan
        )->first();

        if (!$currentPlan) {
            return back()->with('error', 'Current plan not found.');
        }

        if (strtolower($user->plan) === 'free') {

            return redirect()->route(
                'checkout',
                $plan->id
            );
        }

        // Remaining credit calculation
        $startDate = $subscription->created_at;

        $endDate = $startDate->copy()->addMonth();

        $totalDays = $startDate->diffInDays($endDate);

        $remainingDays = max(
            now()->diffInDays($endDate, false),
            0
        );

        $credit =
            ($currentPlan->price / $totalDays)
            * $remainingDays;

        $newPlanCost =
            ($plan->price / $totalDays)
            * $remainingDays;

        $amountDue =
            max($plan->price - $credit, 0);

        $stripe = new StripeClient(config('cashier.secret'));

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',

            'customer' => $user->stripe_id,

            'success_url' => route('subscription.success'),

            'cancel_url' => route('subscription.cancel'),

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',

                        'product_data' => [
                            'name' =>
                                'Upgrade to ' . $plan->name,
                        ],

                        'unit_amount' =>
                            round($amountDue * 100),
                    ],

                    'quantity' => 1,
                ]
            ],

            'metadata' => [

                'upgrade' => true,

                'user_id' => $user->id,

                'subscription_id' =>
                    $subscription->id,

                'plan_id' =>
                    $plan->id,

                'type' => $plan->name,
            ]
        ]);

        return redirect($session->url);
    }

    public function success()
    {

        $user = auth()->user();

        $pendingPayment = Payment::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subSeconds(5))
            ->latest()
            ->first();

        if (!$pendingPayment) {
            return redirect()
                ->route('plans')
                ->with(
                    'error',
                    'Server is runing low. please try after some times'
                );
        }

        return redirect()
            ->route('plans')
            ->with(
                'info',
                'Thank you. Your payment is in process. We will inform you once completed.'
            );
    }




    public function cancel()
    {
        $user = auth()->user();

        $subscription = $user->subscription('default');

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        $payment = Payment::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->latest()
            ->first();


        $payments = Payment::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->get();

        if (!$payments || !$payments->stripe_payment_id) {
            return back()->with('error', 'No valid payment found for refund.');
        }

        $planName = DB::table('plans')
            ->where('id', $payment->plan_id)
            ->value('name');

        // dd($refundAmount);

        try {

            // CALCULATE REFUND

            $refundAmounts = [];
            $i = 0;

            foreach ($payments as $payment) {

                $startDate = Carbon::parse($payment->updated_at);
                $endDate = $startDate->copy()->addDays(30);

                $totalDays = $startDate->diffInDays($endDate);
                $usedDays = $startDate->diffInDays(now());
                $remainingDays = max($totalDays - $usedDays, 0);

                // dd(\Schema::getColumnListing('payments'));
                $amount = (float) $payment->amount;

                if ($amount <= 0) {
                    return back()->with('error', 'Invalid payment amount.');
                }

                $refundAmounts[$i] = ($amount / $totalDays) * $remainingDays;

                $i++;
            }

            $refundAmount = array_sum($refundAmounts);

            // CANCEL SUBSCRIPTION

            $subscription->cancelNow();

            //STRIPE REFUND

            \Stripe\Stripe::setApiKey(config('cashier.secret'));

            $refund = \Stripe\Refund::create([
                'payment_intent' => $payment->stripe_payment_id,
                'amount' => (int) round($refundAmount),
            ]);

            // UPDATE DATABASE

            $payments = Payment::where('user_id', $user->id)
                ->where('payment_status', 'Paid')
                ->get();

            $i = 0;
            foreach ($payments as $payment) {

                $payment->update([
                    'payment_status' => 'Refunded',
                    'amount_refunded' => $refundAmounts[$i],
                    'refund_at' => now(),
                ]);

                $i++;
            }

            // Mail::to($user->email)
            //     ->send(new RefundProcessedMail(
            //         $user,
            //         (int) $refundAmount
            //     ));

            $user->update([
                'role' => 'User',
                'plan' => 'free',
            ]);

            auth()->user()->notify(
                new CancelSubscriptionNotification($planName)
            );

            return redirect()
                ->route('profile.myprofile')
                ->with('success', "Your subscription has been canceled successfully. A refund of ₹{$refundAmount} has been initiated and will be credited to your original payment method shortly. We appreciate your trust in our platform and hope to serve you again in the future.");

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function activateFreePlan(Plan $plan)
    {
        $user = auth()->user();

        // Check if user already has subscription
        if ($user->subscriptions()->where('stripe_status', 'active')->exists()) {
            return back()->with('warning', 'You already have an active higher-tier plan. Upgrade is not required at this time.');
        }

        // Ensure only free plan can use this
        if ($plan->price > 0) {
            return back()->with('error', 'Invalid free plan.');
        }

        // Create local subscription without Stripe
        $user->subscriptions()->create([
            'type' => 'free',
            'stripe_id' => 'free_plan_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price' => $plan->stripe_price_id,
            'quantity' => 1,
        ]);

        return redirect()->route('plans')
            ->with('success', 'Free plan activated successfully.');
    }
}
