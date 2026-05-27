<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\User;
use App\Notifications\ReportNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportActionMail;
use App\Jobs\ResolveReportMail;

class ReportsController extends Controller
{
    // List all reports
    public function index()
    {
        $reports = DB::table('reports')
            ->join('profiles as reporter_profiles', 'reports.reporter_id', '=', 'reporter_profiles.id')
            ->join('users as reporter_users', 'reporter_profiles.user_id', '=', 'reporter_users.id')
            ->join('profiles as reported_profiles', 'reports.reported_profile_id', '=', 'reported_profiles.id')
            ->join('users as reported_users', 'reported_profiles.user_id', '=', 'reported_users.id')
            ->select(
                'reports.id',
                'reports.reason',
                'reports.message',
                'reports.status',
                'reports.created_at',
                'reports.updated_at',

                'reporter_profiles.id as reporter_profile_id',
                'reporter_users.name as reporter_name',
                'reporter_users.email as reporter_email',

                'reported_profiles.id as reported_profile_id',
                'reported_users.id as reported_user_id',
                'reported_users.name as reported_name',
                'reported_users.email as reported_email'
            )
            ->orderBy('reports.created_at', 'desc')
            ->get();

        return view('admin.reports.index', compact('reports'));
    }

    // Show single report
    public function show($id)
    {
        $report = DB::table('reports')
            ->join('profiles as reporter_profiles', 'reports.reporter_id', '=', 'reporter_profiles.id')
            ->join('users as reporter_users', 'reporter_profiles.user_id', '=', 'reporter_users.id')
            ->join('profiles as reported_profiles', 'reports.reported_profile_id', '=', 'reported_profiles.id')
            ->join('users as reported_users', 'reported_profiles.user_id', '=', 'reported_users.id')
            ->select(
                'reports.*',
                'reporter_users.name as reporter_name',
                'reporter_users.email as reporter_email',
                'reported_users.id as reported_user_id',
                'reported_users.name as reported_name',
                'reported_users.email as reported_email',
                'reported_profiles.id as reported_profile_id'
            )
            ->where('reports.id', $id)
            ->first();

        abort_if(!$report, 404);

        return view('admin.reports.show', compact('report'));
    }

    // Resolve report
    public function resolve(Request $request, $reportId)
    {
        $request->validate([
            'action_type' => 'required|in:warning,ban',
            'message' => 'nullable|string',
        ]);

        // Fetch report + reported user
        $report = DB::table('reports')
            ->join('profiles as reported_profiles', 'reports.reported_profile_id', '=', 'reported_profiles.id')
            ->join('users as reported_users', 'reported_profiles.user_id', '=', 'reported_users.id')
            ->select('reports.*', 'reported_users.id as reported_user_id', 'reported_users.name as reported_user_name', 'reported_profiles.id as reported_profile_id')
            ->where('reports.id', $reportId)
            ->first();

        abort_if(!$report, 404);

        $reportedUser = User::find($report->reported_user_id);
        abort_if(!$reportedUser, 404);

        // Update report status
        Report::find($reportId)->update(['status' => 'resolved']);

        // Action on user
        if ($request->action_type == 'ban') {
            $reportedUser->status = 'banned';
            $reportedUser->save();
            $actionMessage = "Your profile has been banned due to a report.";
        } else {
            $actionMessage = $request->message ?? "You have received a warning regarding your profile.";
        }

        // Send database notification
        ResolveReportMail::dispatch($reportedUser->id, $actionMessage, $reportId, $report->reported_profile_id, $reportedUser->name);

        return redirect()->route('admin.reports')->with('success', 'Report resolved successfully.');
    }


    // Reject report
    public function reject(Request $request, $reportId)
    {
        $request->validate([
            'message' => 'nullable|string',
        ]);

        $report = Report::findOrFail($reportId);

        $report->status = 'rejected';
        $report->save();

        $reportedProfileId = DB::table('profiles')
            ->where('id', $report->reported_profile_id)
            ->value('id');

        $reportedUserId = DB::table('profiles')
            ->where('id', $report->reported_profile_id)
            ->value('user_id');

        $reportedUser = User::find($reportedUserId);

        if ($reportedUser) {
            $actionMessage = $request->message ?? "Your report has been rejected by admin.";
            ResolveReportMail::dispatch($reportedUser->id, $actionMessage, $reportId, $report->reported_profile_id, $reportedUser->name);
        }

        return redirect()->route('admin.reports')->with('success', 'Report rejected successfully.');
    }

    public function destroy($reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->delete();

        return redirect()
            ->route('admin.reports')
            ->with('success', 'Report deleted successfully.');
    }

}

