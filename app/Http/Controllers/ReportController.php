<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create($profileId)
    {
        $profile = Profile::findOrFail($profileId);
        return view('profile.report', compact('profile'));
    }

    public function store(Request $request, $profileId)
    {
        
        $request->validate([
            'reason' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $count = Report::where('reported_profile_id', $profileId)->count();

        $reporterProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        Report::create([
            'reporter_id' => $reporterProfile->id,
            'reported_profile_id' => $profileId,
            'reason' => $request->reason,
            'message' => $request->message,
        ]);

        $statusmsg = 'Profile reported successfully!';


        return redirect()->route('user.show', $profileId )
            ->with('status', $statusmsg);
    }
}
