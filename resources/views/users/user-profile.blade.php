@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.html"><i class="fa-solid fa-table-cells-large"></i> Pulpit</a>
                </li>
                <li>
                    <a href="moje-wydarzenia.html"><i class="fa-solid fa-calendar-check"></i> Moje wydarzenia</a>
                </li>
                <li>
                    <a href="dolaczone.html"><i class="fa-solid fa-user-check"></i> Dołączone</a>
                </li>
                <li class="active">
                    <a href="moje-dane.html"><i class="fa-solid fa-user-pen"></i> Moje dane</a>
                </li>
            </ul>
        </aside>

        <main class="main-dashboard">
            <header class="dash-header">
                <div class="dash-title-area">
                    <p>Ustawienia konta</p>
                    <h1>Edytuj profil</h1>
                </div>
                <div class="dash-user-area">

                </div>
            </header>

            <div class="dash-card">
                <form class="profile-form">
            </div>

            <div class="form-group">
                <label>Imię i nazwisko</label>
                <input type="text" value="Alex Kowalski" />
            </div>

            <div class="form-group">
                <label>Adres e-mail</label>
                <input type="email" value="alex.kowalski@email.com" />
            </div>

            <div class="form-group">
                <label>Numer telefonu</label>
                <input type="tel" value="+48 123 456 789" />
            </div>

            <div class="form-group">
                <label>Lokalizacja</label>
                <input type="text" value="Warszawa, Mazowieckie" />
            </div>

            <div class="form-group">
                <label>Krótkie bio (O mnie)</label>
                <textarea rows="4" placeholder="Napisz kilka słów o sobie i swoich zainteresowaniach..."></textarea>
            </div>

            <button type="button" class="btn-save">Zapisz zmiany</button>
            </form>
    </div>
    </main>
    </div>
@endsection
