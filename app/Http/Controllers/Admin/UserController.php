<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('users')
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
            ->where('users.id', '!=', Auth::id())
            ->where('users.id', '!=', 1);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'users.name',
                    'like',
                    '%' . $request->search . '%'
                )
                    ->orWhere(
                        'users.email',
                        'like',
                        '%' . $request->search . '%'
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Plan Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('plan')) {

            $query->where(
                'users.plan',
                $request->plan
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Role Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('role')) {

            $query->where(
                'users.role',
                $request->role
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            if ($request->status == 'active') {

                $query->where('profiles.is_active', 1);

            } elseif ($request->status == 'inactive') {

                $query->where('profiles.is_active', 0);

            } elseif ($request->status == 'banned') {

                $query->where('users.status', 'banned');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        switch ($request->sort_by) {

            case 'name_asc':
                $query->orderBy('users.name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('users.name', 'desc');
                break;

            case 'oldest':
                $query->orderBy('users.id', 'asc');
                break;

            default:
                $query->orderBy('users.id', 'desc');
                break;
        }

        $users = $query
            ->paginate(7)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
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
