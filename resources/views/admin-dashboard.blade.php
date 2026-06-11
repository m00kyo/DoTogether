@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
    <div class="dashboard-layout">
        <!-- Lewy pasek boczny - Wersja ADMIN -->
        <aside class="sidebar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="#"><i class="fa-solid fa-shield-halved"></i> Centrum zgłoszeń</a>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-users"></i> Wszyscy użytkownicy</a>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-list-check"></i> Przegląd aktywności</a>
                </li>
                <li style="margin-top: 20px">
                    <a href="#"><i class="fa-solid fa-gear"></i> Ustawienia systemu</a>
                </li>
                <li>
                    <a href="dashboard.html"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wróć do aplikacji</a>
                </li>
            </ul>
        </aside>

        <!-- Główna zawartość -->
        <main class="main-dashboard">
            <header class="dash-header">
                <div class="dash-title-area">
                    <p>Tryb Moderacji</p>
                    <h1>Centrum zgłoszeń</h1>
                </div>
                <div class="dash-user-area">
                    <i class="fa-regular fa-bell dash-icon"></i>
                    <div class="user-profile">
                        <div class="admin-badge">ADMIN</div>
                        <span>Główny Moderator</span>
                    </div>
                </div>
            </header>

            <!-- Kafelki ze statystykami dla Admina -->
            <div class="small-cards-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 24px">
                <div class="small-card">
                    <div class="sc-icon" style="background: #fee2e2; color: #ef4444"><i class="fa-solid fa-user-slash"></i>
                    </div>
                    <div>
                        <div class="sc-title">Zbanowani użytkownicy</div>
                        <div class="sc-value">14</div>
                    </div>
                </div>
                <div class="small-card">
                    <div class="sc-icon" style="background: #fef3c7; color: #d97706"><i
                            class="fa-solid fa-triangle-exclamation"></i></div>
                    <div>
                        <div class="sc-title">Zgłoszenia użytkowników</div>
                        <div class="sc-value">8</div>
                    </div>
                </div>
                <div class="small-card">
                    <div class="sc-icon" style="background: #e0f2fe; color: #0284c7"><i class="fa-solid fa-flag"></i></div>
                    <div>
                        <div class="sc-title">Zgłoszone aktywności</div>
                        <div class="sc-value">5</div>
                    </div>
                </div>
            </div>

            <!-- Układ kaskadowy tabel na całą szerokość -->
            <div class="admin-grid">
                <!-- TABELA 1: Zgłoszeni Użytkownicy -->
                <div class="dash-card">
                    <div class="card-header">
                        <span class="card-title">Zgłoszeni użytkownicy (Oczekujące akcje)</span>
                    </div>
                    <table class="dash-table admin-table">
                        <thead>
                            <tr>
                                <th>UŻYTKOWNIK</th>
                                <th>POWÓD ZGŁOSZENIA</th>
                                <th>ILOŚĆ</th>
                                <th>AKCJA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <img src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?w=100&q=80"
                                            alt="Avatar" />
                                        Marek Z.
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-reason badge-warning">Agresywne zachowanie</span><br /><span
                                        style="font-size: 12px; color: var(--text-muted)">Użytkownik wyzywał innych w
                                        komentarzach.</span>
                                </td>
                                <td class="bold" style="color: #ef4444">4 zgłoszenia</td>
                                <td>
                                    <button class="btn-table-action btn-resign">Zbanuj</button>
                                    <button class="btn-table-action">Odrzuć</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80"
                                            alt="Avatar" />
                                        Anna K.
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-reason badge-warning">Spam</span><br /><span
                                        style="font-size: 12px; color: var(--text-muted)">Wysyła linki do fałszywych
                                        stron.</span>
                                </td>
                                <td class="bold" style="color: #d97706">2 zgłoszenia</td>
                                <td>
                                    <button class="btn-table-action btn-resign">Zbanuj</button>
                                    <button class="btn-table-action">Odrzuć</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TABELA 2: Zgłoszone Aktywności -->
                <div class="dash-card">
                    <div class="card-header">
                        <span class="card-title">Zgłoszone aktywności</span>
                    </div>
                    <table class="dash-table admin-table">
                        <thead>
                            <tr>
                                <th>AKTYWNOŚĆ</th>
                                <th>ORGANIZATOR</th>
                                <th>POWÓD ZGŁOSZENIA</th>
                                <th>AKCJA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bold"><i class="fa-solid fa-beer-mug-empty"
                                        style="color: #f59e0b; margin-right: 8px"></i> Impreza u mnie</td>
                                <td>Tomasz B.</td>
                                <td>
                                    <span class="badge-reason badge-warning">Podejrzane wydarzenie</span><br /><span
                                        style="font-size: 12px; color: var(--text-muted)">Brak szczegółów, podejrzany opis
                                        wydarzenia.</span>
                                </td>
                                <td>
                                    <button class="btn-table-action btn-resign">Usuń wydarzenie</button>
                                    <button class="btn-table-action">Odrzuć</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="bold"><i class="fa-solid fa-money-bill-wave"
                                        style="color: #10b981; margin-right: 8px"></i> Szybki zarobek!</td>
                                <td>Jan N.</td>
                                <td>
                                    <span class="badge-reason badge-danger">Oszustwo finansowe</span><br /><span
                                        style="font-size: 12px; color: var(--text-muted)">Próba wyłudzenia pieniędzy za
                                        wstęp.</span>
                                </td>
                                <td>
                                    <button class="btn-table-action btn-resign">Usuń wydarzenie</button>
                                    <button class="btn-table-action btn-resign">Zbanuj twórce</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TABELA 3: Zbanowani Użytkownicy -->
                <div class="dash-card">
                    <div class="card-header">
                        <span class="card-title">Zbanowani użytkownicy</span>
                    </div>
                    <table class="dash-table admin-table">
                        <thead>
                            <tr>
                                <th>UŻYTKOWNIK</th>
                                <th>POWÓD BLOKADY</th>
                                <th>DATA BLOKADY</th>
                                <th>AKCJA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="user-cell" style="opacity: 0.6">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80"
                                            alt="Avatar" />
                                        Kamil P.
                                    </div>
                                </td>
                                <td><span class="badge-reason badge-danger">Notoryczny Spam</span></td>
                                <td>12 Maja 2024</td>
                                <td><button class="btn-table-action btn-success">Odbanuj</button></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell" style="opacity: 0.6">
                                        <i class="fa-solid fa-user"></i>
                                        Piotr W.
                                    </div>
                                </td>
                                <td><span class="badge-reason badge-danger">Mowa nienawiści</span></td>
                                <td>05 Kwietnia 2024</td>
                                <td><button class="btn-table-action btn-success">Odbanuj</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
@endsection
