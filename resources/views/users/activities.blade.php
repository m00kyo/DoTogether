@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('profile.index') }}"><i class="fa-solid fa-table-cells-large"></i> Pulpit</a>
                </li>
                <li class="active">
                    <a href="{{ route('profile.activities') }}"><i class="fa-solid fa-calendar-check"></i> Moje
                        wydarzenia</a>
                </li>
                <li>
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
                    <p>Panel organizatora</p>
                    <h1>Zarządzaj swoimi wydarzeniami</h1>
                </div>
                <div class="dash-user-area">

                </div>
            </header>

            <div class="dash-card">
                <div class="card-header">
                    <span class="card-title">Wydarzenia utworzone przez Ciebie</span>
                    <a href="{{ route('activities.create') }}" class="banner-btn"
                        style="padding: 8px 16px; font-size: 12px; background: var(--grad-primary-strong); color: white">+
                        Utwórz nowe</a>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-star" style="color: #f59e0b"></i></th>
                            <th>NAZWA WYDARZENIA</th>
                            <th>DATA</th>
                            <th>ZAPISANI</th>
                            <th>AKCJA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td><i class="fa-solid fa-star" style="color: #f59e0b"></i></td>
                                <td>
                                    <a style="text-decoration: none; color: inherit;" href="{{ route('activities.details', $activity->id) }}">{{ $activity->title }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($activity->event_date)->format('d M Y') }}</td>
                                <td>{{ $activity->participants()->where('status', 'CONFIRMED')->count() }}/{{ $activity->max_participants }}
                                    osób</td>

                                <td>
                                    <form action="{{ route('activities.delete', $activity->id) }}" method="POST"
                                        onsubmit="return confirm('Czy na pewno chcesz usunąć to wydarzenie?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-table-action btn-resign">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection
