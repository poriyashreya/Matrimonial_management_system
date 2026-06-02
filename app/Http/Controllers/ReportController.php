<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create($profileId)
    {
        $profile = Profile::findOrFail($profileId);

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
        return view('profile.report', compact('profile', 'rating_status'));
    }

    public function store(Request $request, $profileId)
    {

        $request->validate([
            'reason' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $count = Report::where('reported_profile_id', $profileId)->count();

        $reporterProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        Report::create([
            'reporter_id' => $reporterProfile->id,
            'reported_profile_id' => $profileId,
            'reason' => $request->reason,
            'message' => $request->message,
        ]);

        $statusmsg = 'Profile reported successfully!';


        return redirect()->route('user.show', $profileId)
            ->with('status', $statusmsg);
    }
}
