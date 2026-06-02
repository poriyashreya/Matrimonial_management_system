<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        // Join users with profiles
        $users = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->select(
                'users.id as user_id',
                'users.name',
                'users.email',
                'users.role',
                'users.plan',
                'users.status',
                'users.gender',
                'profiles.id as profile_id',
                'profiles.age',
                'profiles.religion',
                'profiles.community',
                'profiles.marital_status',
                'profiles.profession',
                'profiles.country',
                'profiles.state',
                'profiles.city',
                'profiles.is_active'
            )
            ->orderBy('users.id', 'desc')
            ->where('users.id', '!=', Auth::id())
            ->where('users.id', '!=', 1)
            ->paginate(7);

        return view('admin.users.index', compact('users'));
    }

    public function show(Profile $profile)
    {
        $profile->load('user');

        $city = DB::table('cities')
            ->where('id', $profile->city)
            ->value('name');

        $profile->city = $city;

        $country = DB::table('countries')
            ->where('id', $profile->country)
            ->value('name');

        $profile->country = $country;

        $state = DB::table('states')
            ->where('id', $profile->state)
            ->value('name');

        $profile->state = $state;

        return view('admin.users.show', compact('profile'));
    }

    public function makeAdmin(User $user)
    {

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'role' => 'admin',
                'updated_at' => now()
            ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User has been promoted to admin successfully.');
    }

    public function demoteAdmin1(User $user)
    {

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'role' => 'free',
                'updated_at' => now()
            ]);

        if ($user->id == Auth::id()) {
            Auth::logout();
            return redirect('/')
                ->with('danger', 'You have been demoted to user successfully. Please log in again.');
        }


        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User has been demoted to user successfully.');
    }



    public function demoteAdmin(User $user)
    {
        // Update the role to 'free'
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'role' => 'free',
                'updated_at' => now()
            ]);

        // If the admin is demoting themselves
        if ($user->id == Auth::id()) {
            Auth::logout();
            return redirect('/')
                ->with('danger', 'You have been demoted to user successfully. Please log in again.');
        }

        // If the demoted user is currently logged in, force logout
        if (config('session.driver') === 'database') {
            // Delete all sessions of this user
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }


        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User has been demoted to user successfully and logged out if they were online.');
    }

    public function ban($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 'banned',
                'updated_at' => now()
            ]);


        DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 'banned',
                'updated_at' => now()
            ]);

        return back()->with(
            'success',
            'User banned successfully.'
        );
    }

    public function unban($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 'None',
                'updated_at' => now()
            ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 'None',
                'updated_at' => now()
            ]);

        return back()->with(
            'success',
            'User unbanned successfully.'
        );
    }


}
