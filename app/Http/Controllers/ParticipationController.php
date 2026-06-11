<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function join($activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $user = auth()->user();

        $participants_count = Participation::where([['activity_id', $activityId], ['status', 'CONFIRMED']])->count();

        if ($participants_count >= $activity->max_participants) {
            $status_to_add = 'WAITLISTED';
        } else {
            $status_to_add = 'CONFIRMED';
        }

        $existing_participation = Participation::where([
            ['activity_id', $activityId],
            ['user_id', $user->id],
        ])->first();

        if ($existing_participation) {
            if ($existing_participation->status === 'REMOVED') {
                abort(400);
            }
            $existing_participation->cancelled_at = null;
            $existing_participation->cancel_reason = null;
            $existing_participation->status = $status_to_add;
            $existing_participation->save();
        } else {
            $new_participation = Participation::create([
                'user_id' => $user->id,
                'activity_id' => $activity->id,
                'status' => $status_to_add,
            ]);
        }

        return redirect()->route('activities.details', ['id' => $activityId]);
    }

    public function remove($activityId, $userId)
    {
        $activity = Activity::findOrFail($activityId);
        $user = auth()->user();

        if ($activity->creator_id !== $user->id) {
            abort(403);
        }

        if ($userId === $user->id) {
            abort(400);
        }

        $participation = Participation::where([
            ['activity_id', $activityId],
            ['user_id', $userId],
        ])->firstOrFail();

        $participation->status = 'REMOVED';
        $participation->cancel_reason = null;
        $participation->cancelled_at = null;
        $participation->save();

        return redirect()->route('activities.details', ['id' => $activityId]);
    }

    public function leave($activityId, Request $request)
    {
        $user = auth()->user();
        $activity = Activity::findOrFail($activityId);
        if ($activity->creator_id == $user->id) {
            abort(400);
        }
        $participation = Participation::where([
            ['activity_id', $activityId],
            ['user_id', $user->id],
        ])->firstOrFail();

        $participation->status = 'CANCELLED';
        $participation->cancel_reason = $request->cancel_reason;
        $participation->cancelled_at = now();
        $participation->save();

        return redirect()->route('activities.details', ['id' => $activityId]);
    }
}
