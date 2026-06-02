<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminVerificationController extends Controller
{
    public function index()
    {
        $verifications = DB::table('verifications')
            ->join('profiles', 'verifications.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->select(
                'verifications.id as verification_id',
                'verifications.doc_type',
                'verifications.doc_path',
                'verifications.status',
                'users.name',
                'users.email',
                'users.role',
                'users.gender',
                'profiles.age',
                'profiles.religion',
                'profiles.city',
                'profiles.verified_by'
            )
            ->orderBy('verifications.created_at', 'desc')
            ->paginate(7);

        return view('admin.verification.admin-verification', compact('verifications'));
    }

    public function viewDocument($id)
    {
        $verification = DB::table('verifications')
            ->join('profiles', 'verifications.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->select(
                'verifications.id',
                'verifications.profile_id',
                'verifications.doc_type',
                'verifications.doc_path',
                'verifications.status',
                'users.name',
                'users.email',
                'users.role',
                'users.gender',
                'profiles.age',
                'profiles.religion',
                'profiles.city',
                'profiles.verified_by'
            )
            ->where('verifications.id', $id)
            ->first();

        if (!$verification) {
            abort(404);
        }

        return view('admin.verification.viewdoc', compact('verification'));
    }

    public function approve($id)
    {
        DB::table('verifications')
            ->where('id', $id)
            ->update(['status' => 1]);

        DB::table('profiles')
            ->where('id', function ($query) use ($id) {
                $query->select('profile_id')
                    ->from('verifications')
                    ->where('id', $id);
            })
            ->update(['verified_by' => true]);

        return back()->with('success', 'Profile approved successfully.');
    }

    public function reject($id)
    {
        DB::table('verifications')
            ->where('id', $id)
            ->update(['status' => 2]);

        return back()->with('error', 'Verification rejected.');
    }
}
