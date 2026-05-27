<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileVerificationController extends Controller
{
    public function verification()
    {
        $profile = DB::table('profiles')
            ->select('id')
            ->where('user_id', Auth::id())
            ->first();

        // ✅ Handle profile not found
        if (!$profile) {
            return redirect()
                ->route('profile.create')
                ->with('error', 'Please complete your profile first.');
        }

        $rating_status = "nothing";

        $verification = DB::table('verifications')
            ->select('status')
            ->where('profile_id', $profile->id)
            ->first();

        return view('profile.verification', compact('profile', 'verification','rating_status'));
    }

    public function submitVerification(Request $request)
    {
        $request->validate([
            'document_type' => 'required',
            'document_file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        $profile = DB::table('profiles')
        ->select('id')
        ->where('user_id', Auth::id())
        ->first();

        $verification = DB::table('verifications')
            ->where('profile_id', $profile->id)
            ->first();

        if ($verification) {
            // Handle already submitted verification
            return redirect()
                ->route('profile.verification')
                ->with('error', 'You have already submitted your verification.');
        }

        // ✅ Handle profile not found
        if (!$profile) {
            return redirect()
                ->route('profile.create')
                ->with('error', 'Please complete your profile first.');
        }

        $path = $request->file('document_file')
            ->store('verification_docs', 'public');

        Verification::updateOrCreate(
            ['profile_id' => $profile->id],
            [
                'doc_type' => $request->document_type,
                'doc_path' => $path,
                'status' => 0 // pending
            ]
        );

        return back()->with('success', 'Verification submitted successfully.');
    }
}
