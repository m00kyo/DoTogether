@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ filemtime(public_path('css/dashboard.css')) }}">
@endpush
@section('content')
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('profile.index') }}"><i class="fa-solid fa-table-cells-large"></i> Pulpit</a>
                </li>
                <li>
                    <a href="{{ route('profile.activities') }}"><i class="fa-solid fa-calendar-check"></i> Moje
                        wydarzenia</a>
                </li>
                <li class="active">
                    <a href="{{ route('profile.participations') }}"><i class="fa-solid fa-user-check"></i> Dołączone</a>
                </li>
                <li><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen"></i> Moje dane</a>
                </li>
                @if ($isAdmin)
                    <li>
                        <a href="{{ route('profile.activity_reports') }}"><i class="fa-solid fa-user-pen"></i>Zgłoszenia
                            aktywności</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.user_reports') }}"><i class="fa-solid fa-user-pen"></i>Zgłoszenia
                            użytkowników</a>
                    </li>
                @endif
            </ul>
        </aside>

        <main class="main-dashboard">
            <header class="dash-header">
                <div class="dash-title-area">
                    <p>Twoje plany</p>
                    <h1>Dołączone wydarzenia</h1>
                </div>
                <div class="dash-user-area">

                </div>
            </header>

            <div class="dash-card">
                <div class="card-header">
                    <span class="card-title">Wszystkie nadchodzące spotkania</span>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-check" style="color: #10b981"></i></th>
                            <th>NAZWA WYDARZENIA</th>
                            <th>DATA</th>
                            <th>KATEGORIA</th>
                            <th>AKCJA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td><i class="fa-solid fa-check" style="color: #10b981"></i></td>
                                <td>
                                    <a style="text-decoration: none; color: inherit;" href="{{ route('activities.details', $activity->id) }}">{{ $activity->title }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($activity->event_date)->format('d M Y') }}</td>
                                <td>{{ $activity->category->name }}</td>


                                <td>
                                    <form id="leave-form"
                                        action="{{ route('activities.leave', ['activityId' => $activity->id]) }}"
                                        method="POST" onsubmit="return zapytajOPowod(event)">
                                        <input type="hidden" name="cancel_reason" id="cancel-reason-input">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-table-action btn-resign">Zrezygnuj</button>
                                    </form>
                                </td>
                            </tr>


                        @empty
                        @endforelse




                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection
