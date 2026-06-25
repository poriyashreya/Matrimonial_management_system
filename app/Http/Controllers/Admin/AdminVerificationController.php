<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminVerificationController extends Controller
{
    public function index()
    {
        $query = DB::table('verifications')
            ->join('profiles', 'verifications.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->select(
                'verifications.id as verification_id',
                'verifications.doc_type',
                'verifications.doc_path',
                'verifications.status',
                'verifications.created_at',
                'users.name',
                'users.email',
                'users.role',
                'users.gender',
                'profiles.age',
                'profiles.religion',
                'profiles.city',
                'profiles.verified_by'
            );

        // Search
        if (request('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('verifications.doc_type', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if (request('status') !== null && request('status') !== '') {
            $query->where('verifications.status', request('status'));
        }

        // Document Type Filter
        if (request('doc_type')) {
            $query->where('verifications.doc_type', request('doc_type'));
        }

        // Sorting
        switch (request('sort')) {

            case 'name_asc':
                $query->orderBy('users.name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('users.name', 'desc');
                break;

            case 'verified':
                $query->orderBy('verifications.status', 'desc');
                break;

            case 'pending':
                $query->orderByRaw("
                CASE
                    WHEN verifications.status = 0 THEN 1
                    WHEN verifications.status = 1 THEN 2
                    ELSE 3
                END
            ");
                break;

            case 'oldest':
                $query->orderBy('verifications.created_at', 'asc');
                break;

            default:
                $query->orderBy('verifications.created_at', 'desc');
                break;
        }

        $verifications = $query
            ->paginate(7)
            ->withQueryString();

        return view(
            'admin.verification.admin-verification',
            compact('verifications')
        );
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
