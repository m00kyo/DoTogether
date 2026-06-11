<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityReport;
use App\Models\User;
use App\Models\UserReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report_activity($activityId, Request $request)
    {
        $activity_to_report = Activity::findOrFail($activityId);

        if ($activity_to_report->creator_id === auth()->user()->id) {
            return redirect()->route('activities.details', ['id' => $activityId]);
        }

        $report_exist = ActivityReport::where('activity_id', $activityId)->where('reporter_id', auth()->user()->id)->exists();

        if ($report_exist) {
            return redirect()->route('activities.details', ['id' => $activityId]);
        }

        $report = ActivityReport::create([
            'activity_id' => $activityId,
            'reporter_id' => auth()->user()->id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('activities.details', ['id' => $activityId]);
    }

    public function report_user($activityId, $userId, Request $request)
    {
        $user_to_report = User::findOrFail($userId);

        if ($user_to_report->id === auth()->user()->id) {
            return redirect()->route('activities.details', ['id' => $activityId]);
        }

        $report_exist = UserReport::where('reported_id', $user_to_report->id)->where('reporter_id', auth()->user()->id)->exists();

        if ($report_exist) {
            return redirect()->route('activities.details', ['id' => $activityId]);
        }

        $report = UserReport::create([
            'reported_id' => $user_to_report->id,
            'reporter_id' => auth()->user()->id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('activities.details', ['id' => $activityId]);
    }

    public function user_reports()
    {
        $reports = UserReport::with('reporter', 'reported')->get();

        return view('users.admin_users', compact('reports'));
    }

    public function activity_reports()
    {
        $reports = ActivityReport::with('reporter', 'activity')->get();

        return view('users.admin_activities', compact('reports'));
    }

    public function reject_activity_report($id)
    {
        $report_to_reject = ActivityReport::findOrFail($id);
        $report_to_reject->delete();

        return redirect()->route('profile.activity_reports');
    }

    public function reject_user_report($id)
    {
        $report_to_reject = UserReport::findOrFail($id);
        $report_to_reject->delete();

        return redirect()->route('profile.user_reports');
    }

    public function resolve_activity_report($id, Request $request)
    {
        $report_to_resolve = ActivityReport::findOrFail($id);
        if ($request->action === 'DELETE_ACTIVITY') {
            $report_to_resolve->activity->delete();
            $report_to_resolve->delete();
        }

        return redirect()->route('profile.activity_reports');
    }

    public function resolve_user_report($id, Request $request)
    {
        $report_to_resolve = UserReport::findOrFail($id);
        $user_to_delete = $report_to_resolve->reported;

        $user_to_delete->participations()->where('status', 'CONFIRMED')->each(
            fn ($p) => $p->delete()
        );

        $report_to_resolve->delete();
        $user_to_delete->delete();

        return redirect()->route('profile.user_reports');
    }
}
