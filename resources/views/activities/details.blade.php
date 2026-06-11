@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/details.css') }}?v={{ filemtime(public_path('css/details.css')) }}">
@endpush
@section('content')
    <div class="app-container">
        <nav class="navbar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <ul class="nav-links"></ul>
            <div class="nav-actions">
            </div>
        </nav>

        <main class="details-container">
            <a href="{{ route('activities.index') }}" class="btn-text back-link"><i class="fa-solid fa-arrow-left"></i> Wróć
                do
                listy wydarzeń</a>

            <div class="details-grid">
                <div class="details-main">
                    <div class="details-header">
                        <span class="card-category cat-rozrywka">{{ $activity->category->name }}</span>
                        <h1>{{ $activity->title }}</h1>
                    </div>

                    <div class="details-section">
                        <h2>O wydarzeniu</h2>
                        <p>
                            {{ $activity->description }}
                        </p>
                    </div>
                    <div class="details-section">
                        <h2>Organizator</h2>
                        <!-- Zgrabny kafelek zamiast rozciągniętego bloku -->
                        <div class="organizer-card">
                            <div class="org-avatar-placeholder">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="org-info">
                                <h3>{{ $activity->creator->nickname }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="details-section">
                        <!-- Nowa, tekstowa lista uczestników -->
                        <h2>Liczba miejsc</h2>
                        <div class="attendees-counter-box">
                            <div class="counter-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="counter-text">
                                <span class="count">{{ $activity->max_participants - $activity->available_spots }} /
                                    {{ $activity->max_participants }}</span>
                                <span class="label">Zajętych miejsc</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="details-sidebar">
                    <div class="action-card">
                        <h3>Szczegóły</h3>

                        <ul class="event-meta-list">
                            <li>
                                <div class="meta-icon"><i class="fa-regular fa-calendar"></i></div>
                                <div class="meta-text">
                                    <strong>{{ \Carbon\Carbon::parse($activity->event_date)->locale('pl')->translatedFormat('j F Y') }}</strong>
                                    <span>{{ \Carbon\Carbon::parse($activity->event_date)->locale('pl')->translatedFormat('l') }}</span>
                                </div>
                            </li>
                            @if ($activity->location)
                                <li>
                                    <div class="meta-icon"><i class="fa-solid fa-location-dot"></i></div>
                                    <div class="meta-text">
                                        <strong>{{ $activity->location }}</strong>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <div class="meta-icon"><i class="fa-solid fa-user-group"></i></div>
                                <div class="meta-text">
                                    <strong>{{ $activity->available_spots }} wolne miejsca</strong>
                                    <span>Zapisanych: {{ $activity->max_participants - $activity->available_spots }} z
                                        {{ $activity->max_participants }}</span>
                                </div>
                            </li>
                            @if ($activity->required_age)
                                <li>
                                    <div class="meta-icon"><i class="fa-solid fa-id-card"></i></div>
                                    <div class="meta-text">
                                        <strong>Wymagania</strong>
                                        <span>{{ $activity->required_age === 'NO_RESTRICTION' ? 'Brak wymagań' : 'Wymagany wiek: ' . $activity->required_age }}</span>
                                    </div>
                                </li>
                            @endif
                        </ul>
                        @switch($active_button)
                            @case('JOIN')
                                <form action="{{ route('activities.join', ['activityId' => $activity->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn-join-event">Dołącz do wydarzenia</button>
                                </form>
                            @break

                            @case('LEAVE')
                                <form id="leave-form" action="{{ route('activities.leave', ['activityId' => $activity->id]) }}"
                                    method="POST" onsubmit="return zapytajOPowod(event)">
                                    <input type="hidden" name="cancel_reason" id="cancel-reason-input">
                                    <button class="btn-leave-event">Opuść wydarzenie</button>

                                    @csrf
                                    @method('DELETE')
                                </form>
                            @break

                            @case('BLOCKED')
                                <button class="btn-blocked" disabled>Zostałeś wyrzucony</button>
                            @break
                        @endswitch

                        @if (!$is_owner)
                            <div class="action-card-footer">
                                <form action="{{ route('report.activity', ['activityId' => $activity->id]) }}"
                                    method="POST" onsubmit="return reportActivity(event)">
                                    @csrf
                                    <input type="hidden" name="reason" id="activity-reason-input">
                                    <button type="submit" class="btn-report"><i class="fa-solid fa-flag"></i>
                                        Zgłoś</button>
                                </form>
                            </div>
                        @endif
                        @if ($is_owner)
                            <div class="action-card-footer">
                                <a class="btn-edit-event"
                                    href="{{ route('activities.edit', ['id' => $activity->id]) }}">Edytuj</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="participants">
                <h2>Uczestnicy</h2>
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-user" style="color: #0d7f99"></i></th>
                            <th>UŻYTKOWNIK</th>
                            <th>DATA DOŁĄCZENIA</th>
                            <th>STATUS</th>
                            <th>ZGŁOŚ</th>
                            @if ($is_owner)
                                <th>AKCJA</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $participant)
                            <tr>
                                <td><i class="fa-solid fa-user" style="color: #0d7f99"></i></td>
                                <td class="bold">{{ $participant->user->nickname }}</td>
                                <td>{{ \Carbon\Carbon::parse($participant->created_at)->locale('pl')->translatedFormat('d M Y \o H:i') }}
                                </td>
                                <td>
                                    @if ($participant->status === 'CONFIRMED')
                                        <span class="status-badge status-confirmed">Potwierdzony</span>
                                    @elseif ($participant->status === 'WAITLISTED')
                                        <span class="status-badge status-waitlisted">Oczekujący</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->id !== $participant->user_id)
                                        <form
                                            action="{{ route('report.user', ['activityId' => $activity->id, 'userId' => $participant->user_id]) }}"
                                            method="POST" onsubmit="return reportUser(event)"
                                            data-userid="{{ $participant->user_id }}">
                                            @csrf
                                            <input type="hidden" name="reason"
                                                id="reason-input-{{ $participant->user_id }}">
                                            <button type="submit" class="btn-report-icon" title="Zgłoś tego użytkownika">
                                                <i class="fa-solid fa-flag"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                @if ($is_owner)
                                    <td>
                                        @if ($owner_id != $participant->user_id)
                                            <form
                                                action="{{ route('activities.remove', ['activityId' => $activity->id, 'userId' => $participant->user_id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Czy na pewno chcesz wyrzucić tego uczestnika?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-table-action btn-resign">Wyrzuć</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="@if ($is_owner) 6@else5 @endif"
                                    style="text-align: center; color: var(--text-muted);">Brak uczestników</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (count($cancelled_participants) > 0 && $is_owner)
                <div class="participants">
                    <h2>Zrezygnowali</h2>
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th><i class="fa-solid fa-times-circle" style="color: #ef4444"></i></th>
                                <th>UŻYTKOWNIK</th>
                                <th>DATA REZYGNACJI</th>
                                <th>POWÓD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cancelled_participants as $participant)
                                <tr>
                                    <td><i class="fa-solid fa-times-circle" style="color: #ef4444"></i></td>
                                    <td class="bold">{{ $participant->user->nickname }}</td>
                                    <td>{{ \Carbon\Carbon::parse($participant->cancelled_at)->locale('pl')->translatedFormat('d M Y \o H:i') }}
                                    </td>
                                    <td>{{ $participant->cancel_reason ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            
            @if (count($removed_participants) > 0 && $is_owner)
                <div class="participants">
                    <h2>Wyrzuceni</h2>
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th><i class="fa-solid fa-ban" style="color: #6b7280"></i></th>
                                <th style="text-align: left;">UŻYTKOWNIK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($removed_participants as $participant)
                                <tr style="text-align: left;">
                                    <td style="text-align: center;"><i class="fa-solid fa-ban" style="color: #6b7280"></i></td>
                                    <td style="text-align: left;" class="bold">{{ $participant->user->nickname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </main>

        <footer>
            <div class="footer-col">
                <h4>SpotkajmySię</h4>
                <p>Najlepsza platforma do organizacji i dołączania do grupowych wyjść i aktywności.</p>
            </div>
            <div class="footer-col">
            </div>
            <div class="footer-col">
                <a href="{{ route('profile.index') }}">Mój profil</a>
            </div>
        </footer>
    </div>

    <script>
        function reportActivity(event) {
            event.preventDefault();
            const reason = prompt('Wpisz powód zgłoszenia:');
            if (reason === null) {
                return false;
            }
            if (reason.trim() === '') {
                alert('Powód zgłoszenia nie może być pusty!');
                return false;
            }
            document.getElementById('activity-reason-input').value = reason;
            event.target.submit();
        }

        function reportUser(event) {
            event.preventDefault();
            const reason = prompt('Wpisz powód zgłoszenia:');
            if (reason === null) {
                return false;
            }
            if (reason.trim() === '') {
                alert('Powód zgłoszenia nie może być pusty!');
                return false;
            }
            const userId = event.target.dataset.userid;
            document.getElementById('reason-input-' + userId).value = reason;
            event.target.submit();
        }

        function zapytajOPowod(event) {
            event.preventDefault();
            const reason = prompt('Wpisz powód rezygnacji (opcjonalnie):');
            document.getElementById('cancel-reason-input').value = reason || '';
            event.target.submit();
        }
    </script>
@endsection
