@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
    <!-- Główny kontener o układzie panelu (Dashboard) -->
    <div class="dashboard-layout">
        <!-- Lewy pasek boczny (Sidebar) -->
        <aside class="sidebar">
            <a href="{{ route('index') }}" style="text-decoration: none" class="logo"><i
                    class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></a>
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="{{ route('profile.index') }}"><i class="fa-solid fa-table-cells-large"></i> Pulpit</a>
                </li>
                <li>
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

        <!-- Główna zawartość -->
        <main class="main-dashboard">
            <!-- Nagłówek -->
            <header class="dash-header">
                <div class="dash-title-area">
                    <h1>Twój profil</h1>
                </div>
                <div class="dash-user-area">
                </div>
            </header>

            <!-- Siatka z kafelkami -->
            <div class="dash-grid">
                <!-- LEWA KOLUMNA -->
                <div class="col-left">
                    <!-- Widget: Wydarzenia utworzone przez użytkownika -->


                    <!-- Widget: Dołączone wydarzenia -->
                    <div class="dash-card flex-grow">
                        <div class="card-header">
                            <span class="card-title">Dołączone wydarzenia</span>
                            <a href="{{ route('profile.participations') }}" class="card-link">Zobacz wszystkie</a>
                        </div>
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th><i class="fa-solid fa-check" style="color: #10b981"></i></th>
                                    <th>NAZWA WYDARZENIA</th>
                                    <th>DATA</th>
                                    <th>AKCJA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td><i class="fa-solid fa-check" style="color: #10b981"></i></td>
                                        <td>
                                            <a href="{{ route('activities.details', ['id' => $activity->id]) }}"
                                                style="text-decoration: none; color: inherit;">
                                                {{ $activity->title }}
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($activity->event_date)->locale('pl')->translatedFormat('d F Y') }}
                                        </td>
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
                                    <tr>
                                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Nie
                                            dołączyłeś jeszcze do żadnego wydarzenia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PRAWA KOLUMNA -->
                <div class="col-right">
                    <!-- Widget: Moje dane -->
                    <div class="dash-card">
                        <div class="card-header">
                            <span class="card-title">Moje dane</span>
                            <a href="{{ route('profile.edit') }}" class="card-link">Edytuj profil</a>
                        </div>
                        <div class="user-data-list">
                            <div class="data-item">
                                <span class="data-label">Nazwa użytkownika</span>
                                <span class="data-val">{{ $user->nickname }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Adres e-mail</span>
                                <span class="data-val">{{ $user->email }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Data urodzenia</span>
                                <span class="data-val">{{ $user->date_of_birth }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Opis</span>
                                <span class="data-val">{{ $user->bio }}</span>
                            </div>

                        </div>
                    </div>

                    <!-- Małe kafelki -->
                    <div class="small-cards-grid">
                        <div class="small-card">
                            <div class="sc-icon" style="background: #e0f2fe; color: #0284c7"><i
                                    class="fa-solid fa-bullhorn"></i></div>
                            <div>
                                <div class="sc-title">Zorganizowane</div>
                                <div class="sc-value">{{ $organized_count }}</div>
                            </div>
                        </div>
                        <div class="small-card">
                            <div class="sc-icon" style="background: #fce7f3; color: #db2777"><i
                                    class="fa-solid fa-ticket"></i></div>
                            <div>
                                <div class="sc-title">Dołączone</div>
                                <div class="sc-value">{{ $joined_count }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget: Baner -->
                    <div class="dash-banner">
                        <div class="banner-content">
                            <p>Masz fajny pomysł?</p>
                            <h3>Zorganizuj własne spotkanie i zaproś innych!</h3>
                            <a href="{{ route('activities.create') }}" class="banner-btn">Utwórz wydarzenie</a>
                        </div>
                        <i class="fa-solid fa-calendar-plus banner-deco-1"></i>
                        <i class="fa-solid fa-users banner-deco-2"></i>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
