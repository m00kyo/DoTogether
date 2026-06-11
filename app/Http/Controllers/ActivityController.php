<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query()->with('category');

        if ($request->filled(['lat', 'long'])) {
            $lat = (float) $request->input('lat');
            $long = (float) $request->input('long');
            $query->selectRaw(
                'activities.*, (earth_distance(ll_to_earth(?, ?), ll_to_earth(activities.lat, activities.long)) / 1000) AS distance',
                [$lat, $long]
            );
        } else {
            $query->selectRaw('activities.*, NULL::float AS distance');
        }

        $query->selectSub(
            Participation::query()
                ->selectRaw('COUNT(*)')
                ->whereColumn('activity_id', 'activities.id')
                ->where('status', 'CONFIRMED'),
            'confirmed_count'
        );

        // Filtr: konkretna data lub przyszłe wydarzenia
        if ($request->filled('event_date')) {
            $query->whereDate('event_date', $request->input('event_date'));
        } else {
            $query->where('event_date', '>=', now()->toDateString());
        }

        // Filtr: kategoria
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filtr: minimalna liczba wolnych miejsc
        if ($request->filled('available_spots')) {
            $query->whereRaw(
                "activities.max_participants - (
                    SELECT COUNT(*) FROM participations p
                    WHERE p.activity_id = activities.id AND p.status = 'CONFIRMED'
                ) >= ?",
                [(int) $request->input('available_spots')]
            );
        }

        // Filtr: ograniczenie wiekowe
        if ($request->filled('required_age')) {
            if ($request->input('required_age') === 'NO_RESTRICTION') {
                $query->whereNull('required_age');
            } else {
                $query->where('required_age', $request->input('required_age'));
            }
        }

        // Filtr: promień odległości
        if ($request->filled('distance') && $request->filled(['lat', 'long'])) {
            $query->whereRaw(
                'earth_distance(ll_to_earth(?, ?), ll_to_earth(activities.lat, activities.long)) / 1000 <= ?',
                [
                    (float) $request->input('lat'),
                    (float) $request->input('long'),
                    (float) $request->input('distance'),
                ]
            );
        }

        if ($request->filled(['lat', 'long'])) {
            $query->orderByRaw('distance ASC');
        } else {
            $query->orderBy('event_date', 'ASC');
        }

        $activities = $query->get();
        $categories = Category::all();

        return view('activities.all', compact('categories', 'activities'));
    }

    public function details($id)
    {
        $activity = Activity::with(['category', 'creator'])
            ->withCount(['participations as confirmed_count' => fn ($q) => $q->where('status', 'CONFIRMED')])
            ->findOrFail($id);

        $my_participation = $activity->participations()->where('user_id', Auth::id())->first();
        $is_owner = $activity->creator_id === Auth::id();

        $active_button = $is_owner ? 'EDIT' : match ($my_participation?->status) {
            'CONFIRMED' => 'LEAVE',
            'WAITLISTED' => 'LEAVE',
            'REMOVED' => 'BLOCKED',
            default => 'JOIN',
        };

        $participants = $activity->participations()
            ->with('user')
            ->whereIn('status', ['CONFIRMED', 'WAITLISTED'])
            ->get();

        $cancelled_participants = $activity->participations()
            ->with('user')
            ->where('status', 'CANCELLED')
            ->get();

        $removed_participants = $activity->participations()
            ->with('user')
            ->where('status', 'REMOVED')
            ->get();

        $owner_id = $activity->creator_id;

        return view('activities.details', compact('activity', 'my_participation', 'is_owner', 'active_button', 'participants', 'cancelled_participants', 'removed_participants', 'owner_id'));
    }

    public function create()
    {
        $categories = Category::all();
        $age_restrictions = [
            'NO_RESTRICTION' => 'Brak',
            'KIDS' => 'Dzieci',
            'ADULTS_ONLY' => '18+',
            'SENIORS' => '40+',
        ];

        return view('activities.create', compact('categories', 'age_restrictions'));
    }

    public function edit($id)
    {
        $activity = Activity::with('category')->findOrFail($id);
        $age_restrictions = [
            'NO_RESTRICTION' => 'Brak',
            'KIDS' => 'Dzieci',
            'ADULTS_ONLY' => '18+',
            'SENIORS' => '40+',
        ];
        $categories = Category::all();

        return view('activities.edit', compact('activity', 'age_restrictions', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:155'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'category_id' => ['nullable', 'string'],
            'required_age' => ['string'],
        ]);

        $activity = Activity::findOrFail($id);
        $activity->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'event_date' => $request->input('event_date'),
            'category_id' => $request->input('category_id'),
            'required_age' => $request->input('required_age') == 'NO_RESTRICTION' ? null : $request->input('required_age'),
        ]);

        return redirect()->route('activities.details', ['id' => $id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:155'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
            'max_participants' => ['required', 'integer', 'min:1'],
            'category_id' => ['nullable', 'string'],
            'required_age' => ['string'],
            'location' => ['nullable', 'string'],
        ]);

        $new_activity = Activity::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'event_date' => $request->input('event_date'),
            'lat' => $request->input('lat'),
            'long' => $request->input('long'),
            'max_participants' => $request->input('max_participants'),
            'category_id' => $request->input('category_id'),
            'required_age' => $request->input('required_age') == 'NO_RESTRICTION' ? null : $request->input('required_age'),
            'location' => $request->input('location'),
            'creator_id' => Auth::id(),
        ]);

        return redirect()->route('activities.details', ['id' => $new_activity->id]);
    }

    public function delete($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('profile.activities');
    }
}
