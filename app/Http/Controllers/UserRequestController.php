<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\Profile;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserRequestNotification;

class UserRequestController extends Controller
{
    /* ===== RECEIVED REQUESTS ===== */
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $requests = UserRequest::with('sender.user', 'sender.images')
            ->where('receiver_id', $myProfile->id)
            ->where('is_pending', 1)
            ->latest()
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

        return view('requests.index', [
            'requests' => $requests,
            'rating_status' => $rating_status
        ]);
    }

    /* ===== SENT REQUESTS ===== */
    public function viewrequests()
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $requests = UserRequest::with('receiver.user', 'receiver.images')
            ->where('sender_id', $myProfile->id)
            ->latest()
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

        return view('requests.sent', [
            'requests' => $requests,
            'rating_status' => $rating_status
        ]);
    }

    /* ===== SEND REQUEST ===== */
    /* ===== SEND REQUEST ===== */
    public function send($receiverProfileId)
    {
        $user = Auth::user();

        // FREE USER BLOCK
        if ($user->isFree()) {
            return redirect()->route('plans')
                ->with('error', 'Free users cannot send requests. Upgrade your plan.');
        }



        // PLAN LIMITS
        if (strtolower($user->role) === 'pro') {
            $limit = PHP_INT_MAX; // Unlimited
        } elseif (strtolower($user->role) === 'premium') {
            $limit = 10; // Premium
        } else {
            $limit = 5; // Default
        }


        $todayRequests = UserRequest::whereDate('created_at', today())
            ->whereHas('sender', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->count();

        // dd($todayRequests);

        // PRO USER → UNLIMITED
        if (!$user->isPro() && $todayRequests >= $limit) {
            return redirect()->route('plans')
                ->with(
                    'error',
                    "Daily request limit reached ({$limit} requests/day). Upgrade to Pro for unlimited requests."
                );
        }

        $senderProfile = Profile::where('user_id', $user->id)->first();

        if (!$senderProfile) {
            return redirect()->route('profile.create');
        }

        $receiverProfile = Profile::findOrFail($receiverProfileId);

        $request = UserRequest::updateOrCreate(
            [
                'sender_id' => $senderProfile->id,
                'receiver_id' => $receiverProfile->id,
            ],
            [
                'is_pending' => 1,
                'is_accepted' => 0,
                'is_rejected' => 0,
                'is_canceled' => 0,
                'is_blocked' => 0,
            ]
        );

        $receiverProfile->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' sent you a request 💌',
                $request->id,
                route('request.index')
            )
        );

        return redirect()->route('profile.index')->with('success', 'Request sent 💌');
    }

    /* ===== ACCEPT ===== */
    public function accept($id)
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $request = UserRequest::where('id', $id)
            ->where('receiver_id', $myProfile->id)
            ->firstOrFail();

        $request->update(['is_accepted' => 1]);

        // ✅ NOTIFY SENDER
        $request->sender->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' accepted your request 💖',
                $request->id,
                route('request.view')
            )
        );

        return back()->with('success', 'Request accepted 💖');
    }

    /* ===== REJECT ===== */
    public function reject($id)
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $request = UserRequest::where('id', $id)
            ->where('receiver_id', $myProfile->id)
            ->firstOrFail();

        $request->update(['is_rejected' => 1]);

        // ✅ NOTIFY SENDER
        $request->sender->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' rejected your request ❌',
                $request->id,
                route('request.view')
            )
        );

        return back()->with('info', 'Request rejected ❌');
    }

    /* ===== CANCEL ===== */
    public function cancel($id)
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $request = UserRequest::where('id', $id)
            ->where('sender_id', $myProfile->id)
            ->firstOrFail();

        $request->update(['is_canceled' => 1]);

        // ✅ NOTIFY RECEIVER
        $request->receiver->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' canceled the request 🚫',
                $request->id,
                route('request.index')
            )
        );

        return back()->with('info', 'Request canceled 🚫');
    }

    /* ===== BLOCK ===== */
    public function block($requestId)
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $request = UserRequest::where('id', $requestId)
            ->where('receiver_id', $myProfile->id)
            ->firstOrFail();

        $request->update(['is_blocked' => 1]);

        // ✅ NOTIFY SENDER
        $request->sender->user->notify(
            new UserRequestNotification(
                'You have been blocked ⛔',
                $request->id,
                route('dashboard')
            )
        );

        return back()->with('success', 'User blocked successfully ⛔');
    }

    /* ===== REMOVE ===== */
    public function remove($requestId)
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return redirect()->route('profile.create');
        }

        $request = UserRequest::where('id', $requestId)
            ->where('sender_id', $myProfile->id)
            ->firstOrFail();

        $request->delete();

        return back()->with('success', 'Request removed 🗑️');
    }

    /* ===== RATING STATUS (EXTRACTED CLEANLY) ===== */
    private function getRatingStatus()
    {
        $user = auth()->user();

        if (!$user)
            return "";

        $rating = DB::table('ratings')
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$rating) {
            return $user->created_at->gte(now()->subDays(7)) ? "new" : "null";
        }

        if ($rating->skip == 1) {
            return Carbon::parse($rating->updated_at)->gte(now()->subHours(24))
                ? "nothing"
                : "skip";
        }

        return Carbon::parse($rating->updated_at)->gte(now()->subDays(3))
            ? "rated"
            : "nothing";
    }
}