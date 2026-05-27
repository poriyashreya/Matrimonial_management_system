<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::with(['user', 'images'])
            ->where('visibility', 'public')
            ->whereHas('user', function ($q) {
                $q->where('status', '!=', 'banned');
            })
            ->where('is_active', 1)
            ->where('user_id', '!=', auth()->id());

        $profiles = $query->paginate(4);
        $testimonials = Testimonial::where('is_active', 1)->latest()->get();

        $user = auth()->user();
        $rating_status = "";

        if ($user) {

            $rating = DB::table('ratings')
                ->select('rating', 'skip', 'user_id', 'created_at', 'updated_at')
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            //No rating exists
            if (!$rating) {

                if ($user->created_at->lt(now()->subDays(7))) {
                    $rating_status = "new";
                } else {
                    $rating_status = "nothing";
                }

            } else {

                //User skipped rating
                if ($rating->skip == 1) {

                    if (Carbon::parse($rating->updated_at)->gte(now()->subHours(24)))  {
                        $rating_status = "nothing"; // skip within 42h
                    } else {
                        $rating_status = "skip"; // can show again
                    }

                }
                // User rated
                else {

                    if (Carbon::parse($rating->updated_at)->gte(now()->subDays(3))) {
                        $rating_status = "rated";
                    } else {
                        $rating_status = "nothing";
                    }

                }
            }
        }

        // dd($rating_status);

        return view('user.dashboard', compact('profiles', 'testimonials', 'rating_status'));
    }

    public function about()
    {
        $user = auth()->user();
        $rating_status = "";

        if ($user) {

            $rating = DB::table('ratings')
                ->select('rating', 'skip', 'user_id', 'created_at', 'updated_at')
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            //No rating exists
            if (!$rating) {

                if ($user->created_at->gte(now()->subDays(7))) {
                    $rating_status = "new";
                } else {
                    $rating_status = "null";
                }

            } else {
                //User skipped rating
                if ($rating->skip == 1) {

                    if (Carbon::parse($rating->updated_at)->gte(now()->subHours(24))) {
                        $rating_status = "nothing"; // skip within 42h
                    } else {
                        $rating_status = "skip"; // can show again
                    }

                }
                // User rated
                else {

                    if (Carbon::parse($rating->updated_at)->gte(now()->subDays(3))) {
                        $rating_status = "rated";
                    } else {
                        $rating_status = "nothing";
                    }

                }
            }
        }

        // dd($rating_status);

        return view('user.about', compact('rating_status'));
    }
}
