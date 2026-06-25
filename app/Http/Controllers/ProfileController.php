<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\State;
use App\Models\City;
use App\Models\Filter;
use App\Models\Country;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\UserRequest;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\Payment;

class ProfileController extends Controller
{
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();


        if ($myProfile) {
            // All public profiles except logged-in user
            $profiles = Profile::with(['user', 'images'])
                ->where('visibility', 'public')
                ->where('user_id', '!=', Auth::id())
                // ->where('gender', '!=', $myProfile->gender)
                ->where('is_active', 1)
                ->whereHas('user', function ($q) {
                    $q->where('status', '!=', 'banned');
                })
                ->get();

            $myFilters = collect();
            $myFilters = Filter::where('profile_id', $myProfile->id)->get();

            $relations = [];
            if ($myProfile) {
                $relations = UserRequest::where(function ($q) use ($myProfile) {
                    $q->where('sender_id', $myProfile->id)
                        ->orWhere('receiver_id', $myProfile->id);
                })->get();
            }

            $profiles = $profiles->transform(function ($profile) use ($relations, $myProfile) {

                $profile->requestStatus = null;

                foreach ($relations as $relation) {

                    $isMatch =
                        ($relation->sender_id == $myProfile->id && $relation->receiver_id == $profile->id) ||
                        ($relation->sender_id == $profile->id && $relation->receiver_id == $myProfile->id);

                    if ($isMatch) {
                        if ($relation->is_accepted) {
                            $profile->requestStatus = 'friends';
                        } elseif ($relation->is_pending) {
                            $profile->requestStatus =
                                $relation->sender_id == $myProfile->id ? 'sent' : 'received';
                        } elseif ($relation->is_rejected) {
                            $profile->requestStatus = 'rejected';
                        } elseif ($relation->is_blocked) {
                            $profile->requestStatus = 'blocked';
                        }
                        break;
                    }
                }

                return $profile;
            });

            /* ✅ FILTER HERE */
            $profiles = $profiles
                ->filter(fn($profile) => $profile->requestStatus === null)
                ->values(); // reset index

            $countries = DB::table('countries')
                ->get();

            // Rating Popup Logic
            $rating_status = "nothing";

            $rating = DB::table('ratings')
                ->where('user_id', Auth::id())
                ->latest('updated_at')
                ->first();

            if (!$rating) {

                $rating_status = "show";

            } else {

                if (
                    ($rating->status == 'rated' &&
                        Carbon::parse($rating->updated_at)->lte(now()->subDays(30)))
                    ||
                    ($rating->status == 'skipped' &&
                        Carbon::parse($rating->updated_at)->lte(now()->subDays(3)))
                    ||
                    ($rating->status == 'cancelled' &&
                        Carbon::parse($rating->updated_at)->lte(now()->subDays(1)))
                    ||
                    $rating->status == 'pending'
                ) {
                    $rating_status = "show";
                } else {
                    $rating_status = "nothing";
                }
            }

            // dd($rating);

            return view('profile.index', compact('profiles', 'myFilters', 'countries', 'rating_status'));

        } else {
            return redirect()->route('profile.create');
        }

    }

    public function getStates($country_id)
    {
        return State::where('country_id', $country_id)
            ->orderBy('name')
            ->get();
    }

    public function getCities($state_id)
    {
        return City::where('state_id', $state_id)
            ->orderBy('name')
            ->get();
    }


    public function show($id, $page)
    {

        // dd($page);
        $profile = Profile::with(['user', 'images'])
            ->where('id', $id)   // user_id from route
            ->firstOrFail();

        $city = DB::table('cities')->where('id', $profile->city)->first();
        if ($city) {
            $profile->city = $city->name;
        }

        $country = DB::table('countries')->where('id', $profile->country)->first();
        if ($country) {
            $profile->country = $country->name;
        }

        $state = DB::table('states')->where('id', $profile->state)->first();
        if ($state) {
            $profile->state = $state->name;
        }

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

        // dd($rating_status);


        return view('profile.show', compact('profile', 'rating_status', 'page'));
    }



    // Show profile creation form
    public function create()
    {
        $countries = DB::table('countries')
            ->get();
        $rating_status = "nothing";
        return view('profile.create', compact('countries', 'rating_status'));
    }

    public function submit(Request $request)
    {
        return $request->skills; // array
    }


    // Store profile data
    public function store(Request $request)
    {
        $request->validate(
            [
                'age' => 'required|integer|min:18|max:100',
                'religion' => 'required|string|max:50',
                'community' => 'required|string|max:50',
                'marital_status' => 'required|in:single,divorced,widow',
                'education' => 'required|string|max:100',
                'profession' => 'required|string|max:100',

                /* ---------- PREFERENCES ---------- */
                'preferences' => 'required|array',
                'preferences.age_min' => 'required|integer|min:18',
                'preferences.age_max' => 'required|integer|max:100',
                'preferences.religion' => 'required|string|max:50',
                'preferences.cast' => 'required|string|max:50',

                'preferences.marital_status' => 'required|array',
                'preferences.marital_status.*' => 'required|string',

                'preferences.profession' => 'required|array',
                'preferences.profession.*' => 'required|string',

                'preferences.personality' => 'required|array',
                'preferences.personality.*' => 'required|string',


                'preferences.location' => 'required|array',
                'preferences.location.*' => 'required|string',

                'country' => 'required|string|max:50',
                'state' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'visibility' => 'required|in:public,private',

                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'preferences.personality.*.required' =>
                    'Please enter at least one personality trait.',

                'preferences.location.*.required' =>
                    'Please enter Location.',

                'preferences.marital_status.*.required' =>
                    'Please Select prefered marital_status.',

                'preferences.profession.*.required' =>
                    'Please Enter Profession.',
            ]
        );

        /*NORMALIZE & CLEAN PREFERENCES */
        $preferences = $request->preferences ?? [];

        // Convert comma-separated profession to array
        if (!empty($preferences['profession'][0])) {
            $preferences['profession'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['profession'][0]))
            ));
        }

        $preferences['personality'] = array_values(
            array_filter($preferences['personality'] ?? [])
        );
        // city, state, country

        if (!empty($preferences['location'][0])) {

            $preferences['location'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['location'][0]))
            ));

        }

        // Remove empty preference values
        $preferences = array_filter($preferences, function ($value) {
            return $value !== null && $value !== '' && $value !== [];
        });


        /*CREATE PROFILE*/
        $profile = Profile::create([
            'user_id' => Auth::id(),
            'age' => $request->age,
            'religion' => $request->religion,
            'community' => $request->community,
            'marital_status' => $request->marital_status,
            'education' => $request->education,
            'profession' => $request->profession,
            'preferences' => $preferences,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'visibility' => $request->visibility,
        ]);

        /* PROFILE IMAGE UPLOAD */

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/profiles', $fileName, 'public');

            $profile->images()->create([
                'user_id' => Auth::id(),
                'file_name' => $fileName,
                'file_path' => $path,
                'Type_of_image' => 'profile',
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Profile created successfully!');
    }


    public function edit(Request $request): View
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        $countries = DB::table('countries')
            ->get();
        $rating_status = "nothing";

        $user = auth()->user();

        // dd($user->contact_number);

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

        return view('profile.edit', [
            'user' => $request->user(),
            'profile' => $profile,
            'countries' => $countries,
            'rating_status' => $rating_status,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                // User
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:255',
                'phone' => 'required|digits_between:10,15',

                // Profile
                'age' => 'required|integer|min:18|max:100',
                'religion' => 'required|string|max:50',
                'community' => 'required|string|max:50',
                'marital_status' => 'required|in:single,divorced,widow',
                'profession' => 'required|string|max:100',

                'country' => 'required',
                'state' => 'required',
                'city' => 'required',

                'visibility' => 'required|in:public,private',

                // Image (optional while editing)
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

                /* ---------- PREFERENCES ---------- */

                'preferences.age_min' => 'required|integer|min:18|max:100',
                'preferences.age_max' => 'required|integer|min:18|max:100|gte:preferences.age_min',

                'preferences.religion' => 'required|string|max:50',
                'preferences.cast' => 'required|string|max:50',

                'preferences.marital_status' => 'required|array',
                'preferences.marital_status.*' => 'string',

                'preferences.profession' => 'required|array',
                'preferences.profession.*' => 'string',

                'preferences.personality' => 'required|array',
                'preferences.personality.*' => 'string',

                'preferences.location' => 'required|array',
                'preferences.location.*' => 'string',
            ],
            [
                'preferences.age_max.gte' =>
                    'Maximum age must be greater than or equal to minimum age.',

                'preferences.personality.*.required' =>
                    'Please select at least one personality trait.',

                'preferences.location.*.required' =>
                    'Please select a preferred location.',

                'preferences.marital_status.*.required' =>
                    'Please select a preferred marital status.',

                'preferences.profession.*.required' =>
                    'Please enter preferred profession.',
            ]
        );

        // dd($request->cast);
        $user = $request->user();

        $profile = Profile::firstOrCreate([
            'user_id' => $user->id
        ]);



        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->phone,
        ]);

        $preferences = $request->preferences ?? [];

        // Profession
        if (!empty($preferences['profession'][0])) {
            $preferences['profession'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['profession'][0]))
            ));
        }

        // Personality
        $preferences['personality'] = array_values(
            array_filter($preferences['personality'] ?? [])
        );

        // Location
        if (!empty($preferences['location'][0])) {
            $preferences['location'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['location'][0]))
            ));
        }

        $preferences = array_filter($preferences, function ($value) {
            return $value !== null && $value !== '' && $value !== [];
        });


        $profile->update([
            'age' => $request->age,
            'religion' => $request->religion,
            'community' => $request->community,
            'marital_status' => $request->marital_status,
            'profession' => $request->profession,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'visibility' => $request->visibility,
            'preferences' => $preferences,
        ]);


        if ($request->hasFile('profile_image')) {

            $file = $request->file('profile_image');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs(
                'uploads/profiles',
                $fileName,
                'public'
            );

            $oldImage = $profile->images()->first();

            if ($oldImage) {

                if (Storage::disk('public')->exists($oldImage->file_path)) {
                    Storage::disk('public')->delete($oldImage->file_path);
                }

                $oldImage->update([
                    'file_name' => $fileName,
                    'file_path' => $path,
                    'Type_of_image' => 'profile',
                ]);

            } else {

                $profile->images()->create([
                    'user_id' => $user->id,
                    'profile_id' => $profile->id,
                    'file_name' => $fileName,
                    'file_path' => $path,
                    'Type_of_image' => 'profile',
                ]);
            }
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }



    public function changeActivation(Request $request): RedirectResponse
    {
        $profile = Profile::where('user_id', Auth::id())->first();


        if (!$profile) {
            return redirect()->route('dashboard')->with('error', 'Profile not found.');
        }

        $statusMessage = '';
        if ($request->activation_action === 'activate') {
            $profile->update(['is_active' => 1]);
            $statusMessage = 'Profile activated successfully!';
        } elseif ($request->activation_action === 'deactivate') {
            $profile->update(['is_active' => 0]);
            $statusMessage = 'Profile deactivated successfully!';
        } else {
            $statusMessage = 'Invalid action.';
        }

        return redirect()->route('profile.edit')->with('status', $statusMessage);
    }
    public function deleteForm(Request $request): View
    {
        $rating_status = "nothing";
        return view('profile.partials.delete-user-form', compact('rating_status'));
    }



    public function destroyProfile(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ]);
        }

        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return back()->with('error', 'Profile not found.');
        }

        Subscription::where('user_id', $user->id)
            ->where('stripe_status', 'active')
            ->update([
                'stripe_status' => 'cancelled',
            ]);

        Payment::where('user_id', $user->id)
            ->where('payment_status', 'success')
            ->update([
                'payment_status' => 'cancelled',
            ]);

        $user->update([
            'plan' => 'free',
        ]);


        foreach ($profile->images as $image) {

            $filePath = public_path($image->file_path);

            if (is_file($filePath)) {
                unlink($filePath);
            }

            $image->delete();
        }

        $profile->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile deleted and subscription cancelled successfully.');
    }

    public function search(Request $request)
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        $query = Profile::with('user', 'images')
            ->where('is_active', 1)
            ->where('user_id', '!=', Auth::id())
            ->whereHas('user', fn($q) => $q->where('status', '!=', 'banned'));

        if ($request->name) {
            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', '%' . $request->name . '%')
            );
        }

        if ($request->age_from) {
            $query->where('age', '>=', $request->age_from);
        }

        if ($request->age_to) {
            $query->where('age', '<=', $request->age_to);
        }

        if ($request->filled('gender')) {
            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('gender', $request->gender)
            );
        }

        if ($request->marital_status) {
            $query->where('marital_status', $request->marital_status);
        }

        if ($request->religion) {
            $query->where('religion', $request->religion);
        }

        if ($request->community) {
            $query->where('community', $request->community);
        }

        if ($request->profession) {
            $query->where('profession', 'like', '%' . $request->profession . '%');
        }

        if ($request->country) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->state) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $profiles = $query->get();

        /* ✅ ACTIVE FILTER ONLY (SoftDeletes respected) */
        $myFilters = Filter::where('profile_id', $profile->id)->get();

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


        return view('profile.index', compact('profiles', 'myFilters', 'rating_status'));
    }

    public function myProfile()
    {
        $profile = Profile::with('user', 'images')->where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('profile.create')->with('info', 'Please create your profile first.');
        }

        $user = DB::table('users')->where('id', Auth::id())->first();
        if ($user->contact_number) {
            $profile->contact_number = $user->contact_number;
        }

        $role = DB::table('users')->where('id', Auth::id())->first();

        // dd($role->plan);
        if ($role->plan) {
            $profile->plan = $role->plan;
        }

        $city = DB::table('cities')->where('id', $profile->city)->first();
        if ($city) {
            $profile->city = $city->name;
        }

        $country = DB::table('countries')->where('id', $profile->country)->first();
        if ($country) {
            $profile->country = $country->name;
        }

        $state = DB::table('states')->where('id', $profile->state)->first();
        if ($state) {
            $profile->state = $state->name;
        }

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

        $subscription = auth()->user()
            ->subscriptions()
            ->where('stripe_status', 'active')
            ->latest()
            ->first();

        $profile->expire_date = ($subscription?->updated_at)->addMonth();

        // dd($profile->expire_date);

        return view('profile.myprofile', compact('profile', 'rating_status'));
    }

    // Soft delete a filter

    public function softDeleteFilter($id)
    {
        $filter = Filter::findOrFail($id);

        // Ensure the filter belongs to the logged-in user
        if ($filter->profile->user_id != Auth::id()) {
            abort(403);
        }

        $filter->delete(); // soft delete

        return redirect()->back()->with('success', 'Filter removed successfully!');
    }

    // Restore a soft deleted filter
    public function restoreFilter($id)
    {
        $filter = Filter::withTrashed()->findOrFail($id);
        $filter->restore();
        return redirect()->back()->with('success', 'Filter restored successfully!');
    }

    // Optional: View deleted filters (Trash)
    public function deletedFilters()
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        $filters = Filter::onlyTrashed()->where('profile_id', $profile->id)->get();
        return view('profile.deleted-filters', compact('filters'));
    }

}




