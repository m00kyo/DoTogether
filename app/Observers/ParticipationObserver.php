<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Participation;

class ParticipationObserver
{
    /**
     * Promuje pierwszą osobę z WAITLISTED → CONFIRMED
     * gdy zwolni się miejsce w aktywności.
     */
    private function promoteFromWaitlist(string $activityId): void
    {
        $activity = Activity::findOrFail($activityId);

        $confirmed_count = Participation::where('activity_id', $activityId)
            ->where('status', 'CONFIRMED')
            ->count();

        $free_seats = $activity->max_participants - $confirmed_count;

        if ($free_seats <= 0) {
            return;
        }

        $next = Participation::where('activity_id', $activityId)
            ->where('status', 'WAITLISTED')
            ->orderBy('created_at')
            ->first();

        if ($next) {
            Participation::withoutEvents(function () use ($next) {
                $next->status = 'CONFIRMED';
                $next->save();
            });
        }
    }

    /**
     * Reaguje na zmianę statusu (CANCELLED / REMOVED).
     * Sprawdzamy poprzednią wartość statusu, żeby awansować tylko gdy
     * faktycznie zwalnia się potwierdzone miejsce.
     */
    public function updated(Participation $participation): void
    {
        $previousStatus = $participation->getOriginal('status');
        $newStatus = $participation->status;

        $wasConfirmed = $previousStatus === 'CONFIRMED';
        $isNowReleased = in_array($newStatus, ['CANCELLED', 'REMOVED']);

        if ($wasConfirmed && $isNowReleased) {
            $this->promoteFromWaitlist($participation->activity_id);
        }
    }

    /**
     * Reaguje na fizyczne usunięcie rekordu (np. ban użytkownika).
     * Awansujemy tylko gdy usunięty rekord był CONFIRMED.
     */
    public function deleted(Participation $participation): void
    {
        if ($participation->status === 'CONFIRMED') {
            $this->promoteFromWaitlist($participation->activity_id);
        }
    }
}
