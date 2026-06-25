<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\CancelSubscriptionNotification;

class SubscriptionManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'plan']);

        if ($request->filled('username')) {

            $query->whereHas('user', function ($q) use ($request) {
                $q->where(
                    'name',
                    'like',
                    '%' . $request->username . '%'
                );
            });
        }


        if ($request->filled('status')) {

            $query->where(
                'payment_status',
                $request->status
            );
        }

        if ($request->filled('expiry_date')) {

            $selectedDate = Carbon::parse(
                $request->expiry_date
            )->format('Y-m-d');

            $query->whereDate(
                DB::raw('DATE_ADD(paid_at, INTERVAL 1 MONTH)'),
                $selectedDate
            );
        }

        if ($request->filled('sort_by')) {

            switch ($request->sort_by) {

                case 'amount_asc':
                    $query->orderBy('amount', 'asc');
                    break;

                case 'amount_desc':
                    $query->orderBy('amount', 'desc');
                    break;

                case 'status_asc':
                    $query->orderBy('payment_status', 'asc');
                    break;

                case 'status_desc':
                    $query->orderBy('payment_status', 'desc');
                    break;

                default:
                    $query->latest();
            }

        } else {

            $query->latest();
        }

        $subscriptions = $query
            ->paginate(7)
            ->withQueryString();

        $subscriptions->getCollection()->transform(function ($subscription) {

            $purchaseDate = Carbon::parse(
                $subscription->paid_at
            );

            $subscription->purchase_date =
                $purchaseDate->format('d M Y');

            $subscription->expiry_date =
                $purchaseDate->copy()
                    ->addMonth()
                    ->format('d M Y');

            return $subscription;
        });

        $totalRevenue = Payment::where(
            'payment_status',
            'Paid'
        )->sum('amount');

        $premiumUsers = User::whereRaw(
            'LOWER(plan) = ?',
            ['premium']
        )->count();

        $proUsers = User::whereRaw(
            'LOWER(plan) = ?',
            ['pro']
        )->count();

        return view(
            'admin.subscriptions.index',
            compact(
                'subscriptions',
                'totalRevenue',
                'premiumUsers',
                'proUsers'
            )
        );
    }

    /*  Cancel Subscription*/
    public function cancel($id)
    {
        $payment = Payment::findOrFail($id);
        $user = User::find($payment->user_id);

        $subscription = $user->subscription('default');

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        $payment = Payment::where('id', $id)
            ->where('payment_status', 'Paid')
            ->latest()
            ->first();

        // dd($payment);

        if (!$payment || !$payment->stripe_payment_id) {
            return back()->with('error', 'No valid payment found for refund.');
        }

        $planName = DB::table('plans')
            ->where('id', $payment->plan_id)
            ->value('name');

        // dd($refundAmount);

        try {
            $startDate = Carbon::parse($payment->updated_at);
            $endDate = $startDate->copy()->addDays(30);

            $totalDays = $startDate->diffInDays($endDate);
            $usedDays = $startDate->diffInDays(now());
            $remainingDays = max($totalDays - $usedDays, 0);

            $price = $payment->amount + $payment->credit;

            if ($price <= 0) {
                return back()->with('error', 'Invalid payment amount.');
            }

            $refundAmounts = ($price / $totalDays) * $remainingDays;

            // CANCEL SUBSCRIPTION

            $subscription->cancelNow();

            //STRIPE REFUND

            \Stripe\Stripe::setApiKey(config('cashier.secret'));

            $refund = \Stripe\Refund::create([
                'payment_intent' => $payment->stripe_payment_id,
                'amount' => (int) round($refundAmounts),
            ]);

            // UPDATE DATABASE

            $payments = Payment::where('user_id', $user->id)
                ->where('payment_status', 'Paid')
                ->get();

            $payment->update([
                'payment_status' => 'Refunded',
                'amount_refunded' => $refundAmounts,
                'refund_at' => now(),
            ]);


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

            return back()->with('refund_amount', number_format($refundAmounts, 2))
                ->with('success', 'Subscription cancelled successfully.');
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', $e->getMessage());
        }
    }
}