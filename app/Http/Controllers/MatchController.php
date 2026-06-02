<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Rating;
use carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())
            ->first();

        if (!$myProfile) {
            return redirect()->route('profile.create')
                ->with('error', 'Create your profile first.');
        }

        /* MY GENDER */
        $myGender = ucfirst(strtolower($myProfile->user->gender));
        $targetGender = $myGender === 'Male' ? 'Female' : 'Male';

        /*  GET ALL REQUEST RELATIONS */
        $relations = UserRequest::where(function ($q) use ($myProfile) {
            $q->where('sender_id', $myProfile->id)
                ->orWhere('receiver_id', $myProfile->id);
        })->get();

        /* GET PROFILES */
        $profiles = Profile::where('visibility', 'public')
            ->where('user_id', '!=', Auth::id())
            ->whereHas('user', function ($q) {
                $q->where('status', '!=', 'banned')
                    ->whereNotNull('gender');
            })
            ->where('is_active', 1)
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('gender', $targetGender)
            )
            ->get();



        /* CALCULATE MATCH SCORE */
        $matches = [];

        foreach ($profiles as $profile) {

            // ❌ Skip blocked users
            if ($profile->is_blocked) {
                continue;
            }

            $score = $this->calculateMatch($myProfile, $profile);

            if ($score >= 40) {
                $matches[] = [
                    'profile' => $profile,
                    'score' => $score
                ];
            }
        }

        /* SORT BY SCORE */
        usort($matches, fn($a, $b) => $b['score'] <=> $a['score']);

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


        return view('matches.show-matches', compact('matches', 'rating_status'));
    }

    /* MATCH SCORE LOGIC */

    private function calculateMatch($me, $candidate)
    {
        $score = 0;

        /* AGE (20%) */
        if (
            isset($me->preferences['age_min'], $me->preferences['age_max']) &&
            $candidate->age >= $me->preferences['age_min'] &&
            $candidate->age <= $me->preferences['age_max']
        ) {
            $score += 20;
        }

        /* RELIGION (20%) */
        if (
            empty($me->preferences['religion']) ||
            $me->preferences['religion'] === $candidate->religion
        ) {
            $score += 20;
        }

        /* CASTE (10%) */
        if (
            empty($me->preferences['cast']) ||
            $me->preferences['cast'] === $candidate->community
        ) {
            $score += 10;
        }

        /* MARITAL STATUS (10%) */
        if (
            empty($me->preferences['marital_status']) ||
            in_array($candidate->marital_status, (array) $me->preferences['marital_status'])
        ) {
            $score += 10;
        }

        /* PROFESSION (15%) */
        if (
            empty($me->preferences['profession']) ||
            in_array($candidate->profession, (array) $me->preferences['profession'])
        ) {
            $score += 15;
        }

        /* PERSONALITY (15%) */
        if (
            !empty($me->preferences['personality']) &&
            !empty($candidate->preferences['personality'])
        ) {
            $common = array_intersect(
                (array) $me->preferences['personality'],
                (array) $candidate->preferences['personality']
            );

            if (count($common) > 0) {
                $score += 15;
            }
        }

        /* LOCATION (10%) */
        if (
            !empty($me->preferences['location'])
        ) {
            if (!empty($candidate->country) && $me->preferences['location'][0] === $candidate->country) {
                $score += 10;
            }
            $score += 10;
        }

        return $score;
    }
}
