<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin_images;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{

    public function index()
    {
        // Verifications
        $verifications = DB::table('verifications')
            ->join('profiles', 'verifications.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->select('verifications.*', 'users.name', 'users.email')
            ->orderBy('verifications.id', 'desc')
            ->get();

        // Users per month for last 6 months
        $registrations = DB::table('users')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $profiles_created = DB::table('profiles')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $profilesByCity = DB::table('profiles')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->pluck('total', 'city')
            ->toArray();
        $logo=DB::table('admin_images')
                ->select('file_path')
                ->where('Type_of_image','favicon');

        return view('admin.admindashboard', compact('verifications', 'registrations', 'profiles_created', 'profilesByCity'));


        // return view('admin.admindashboard', compact('verifications', 'registrations', 'profiles_created'));
    }

}
