<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'ADMIN';

        return view('users.edit', compact('user', 'isAdmin'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nickname' => 'required|string|max:255|unique:users,nickname,'.$user->id,
            'email' => 'required|email|max:255',
            'date_of_birth' => 'required|date',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil został zaktualizowany pomyślnie!');
    }

    public function index()
    {
        $user = auth()->user();
        $activities = $user->joined_activities()->get();
        $joined_count = $user->joined_activities()->count();
        $organized_count = $user->created_activities()->count();
        $isAdmin = $user->role === 'ADMIN';

        return view('users.index', compact('user', 'activities', 'joined_count', 'organized_count', 'isAdmin'));
    }

    public function activities()
    {
        $user = auth()->user();
        $activities = $user->created_activities()->get();
        $isAdmin = $user->role === 'ADMIN';

        return view('users.activities', compact('activities', 'isAdmin'));
    }

    public function participations()
    {
        $user = auth()->user();
        $activities = $user->joined_activities()->where('status', ['CONFIRMED', 'WAITLISTED'])->get();
        $isAdmin = $user->role === 'ADMIN';

        return view('users.participations', compact('activities', 'isAdmin'));
    }
}
