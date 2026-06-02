<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use App\Http\Requests;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserSettingController extends Controller
{
    public function index()
    {
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
        return view('user.settings', compact('rating_status'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'contact_number' => 'required|string|max:10',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number, // ✅ FIXED HERE
        ]);

        return back()
            ->with('success', 'Profile updated successfully.')
            ->with('activeTab', 'profile')
            ->with('rating_status', 'nothing');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            // Get the first error message for password
            $errorMessage = $validator->errors()->first('password');
            $rating_status = "nothing";

            return back()
                ->with('error', $errorMessage)  // pass the error message
                ->with('activeTab', 'security')  // optional: keep tab active
                ->with('rating_status', $rating_status);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        $rating_status = "nothing";

        return back()
            ->with('success', 'Password updated successfully.')
            ->with('activeTab', 'security')
            ->with('rating_status', $rating_status);
    }


    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->with('openDeleteModal', true);
        }

        // 🔥 DELETE CHILD DATA FIRST
        if ($user->profile) {
            $user->profile->filters()->delete();
            $user->profile->delete();

        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $rating_status = "nothing";

        return redirect('/')
            ->with('success', 'Account deleted successfully!')
            ->with('rating_status', $rating_status);
    }


    public function checkPassword(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect password'
            ], 422);
        }

        return response()->json([
            'status' => true
        ]);
    }


}
