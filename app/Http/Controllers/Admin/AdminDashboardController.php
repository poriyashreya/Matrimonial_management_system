<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ================= VERIFICATIONS =================

        $verifications = DB::table('verifications')
            ->join('profiles', 'verifications.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->select('verifications.*', 'users.name', 'users.email')
            ->orderBy('verifications.id', 'desc')
            ->get();


        // ================= USER REGISTRATIONS =================

        $registrations = DB::table('users')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        // ================= PROFILES CREATED =================

        $profiles_created = DB::table('profiles')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        // ================= PROFILES BY CITY =================

        $profilesByCity = DB::table('profiles')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->pluck('total', 'city')
            ->toArray();


        // ================= DASHBOARD COUNTS =================

        $totalUsers = DB::table('users')->count();

        $premiumUsers = DB::table('users')
            ->where('plan', 'premium')
            ->count();

        $proUsers = DB::table('users')
            ->where('plan', 'pro')
            ->count();

        $totalRevenue = DB::table('payments')
            ->where('payment_status', 'Paid')
            ->sum('amount');

        $pendingReports = DB::table('reports')
            ->where('status', 0)
            ->count();


        // ================= ADMIN LOGO =================

        $logo = DB::table('admin_images')
            ->where('Type_of_image', 'favicon')
            ->value('file_path');


        return view('admin.admindashboard', compact(
            'verifications',
            'registrations',
            'profiles_created',
            'profilesByCity',
            'totalUsers',
            'premiumUsers',
            'proUsers',
            'totalRevenue',
            'pendingReports',
            'logo'
        ));
    }
}