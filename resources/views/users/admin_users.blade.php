@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        /* Gwarantowane style dla etykiet zgłoszeń */
        .badge-reason {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #fee2e2;
            color: #ef4444;
        }

        .admin-action-group {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
    </style>
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
                <li>
                    <a href="{{ route('profile.participations') }}"><i class="fa-solid fa-user-check"></i> Dołączone</a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen"></i> Moje dane</a>
                </li>
                <li>
                    <a href="{{ route('profile.activity_reports') }}"><i class="fa-solid fa-flag"></i> Zgłoszenia
                        aktywności</a>
                </li>
                <li class="active">
                    <a href="{{ route('profile.user_reports') }}"><i class="fa-solid fa-user-shield"></i> Zgłoszenia
                        użytkowników</a>
                </li>
            </ul>
        </aside>

        <main class="main-dashboard">
            <header class="dash-header">
                <div class="dash-title-area">
                    <p>Tryb Moderacji</p>
                    <h1>Centrum zgłoszeń użytkowników</h1>
                </div>
                <div class="dash-user-area">
                    <div class="user-profile">
                        <span
                            style="background: var(--text-main); color: white; font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 8px; letter-spacing: 1px;">ADMIN</span>
                        <span>{{ Auth::user()->username ?? 'Administrator' }}</span>
                    </div>
                </div>
            </header>

            <div class="dash-card">
                <div class="card-header">
                    <span class="card-title">Zgłoszeni użytkownicy (Oczekujące akcje)</span>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>ZGŁOSZONY UŻYTKOWNIK</th>
                            <th>ZGŁASZAJĄCY</th>
                            <th>POWÓD ZGŁOSZENIA</th>
                            <th style="text-align: right;">AKCJA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td class="bold">
                                    <i class="fa-solid fa-user-slash" style="color: #ef4444; margin-right: 6px;"></i>
                                    {{ $report->reported->nickname ?? 'Nieznany użytkownik' }}
                                </td>

                                <td>
                                    {{ $report->reporter->nickname ?? 'Nieznany użytkownik' }}
                                </td>

                                <td>
                                    <span class="badge-reason">{{ $report->reason }}</span>
                                </td>

                                <td>
                                    <div class="admin-action-group">

                                        <form action="{{ route('report.user.reject', ['id' => $report->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn-table-action"
                                                onclick="return confirm('Czy na pewno chcesz odrzucić to zgłoszenie?')">Odrzuć</button>
                                        </form>

                                        <form action="{{ route('report.user.resolve', ['id' => $report->id]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="BAN_USER">
                                            <button type="submit" class="btn-table-action btn-resign"
                                                onclick="return confirm('Czy na pewno zbanować tego użytkownika?')">Zbanuj
                                                użytkownika</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    style="text-align: center; padding: 40px 0; color: var(--text-muted); font-weight: 600;">
                                    <i class="fa-solid fa-check-circle"
                                        style="font-size: 24px; color: #10b981; display: block; margin-bottom: 12px;"></i>
                                    Brak nowych zgłoszeń na użytkowników.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection
