@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
@endpush
@section('content')
    <div class="app-container">
        <nav class="navbar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
           
            <div class="nav-actions">
                @guest
                    <a href="{{ route('login') }}" class="btn-text">Zaloguj</a>
                    <a href="{{ route('register') }}" class="btn-primary">Zarejestruj</a>
                @endguest

                @auth
                    <a href="{{ route('profile.index') }}" class="btn-text">MÓJ PROFIL</a>
                    <a href="{{ route('logout') }}" class="btn-primary">Wyloguj się</a>
                @endauth

            </div>
        </nav>

        <header class="hero">
            <div class="hero-content">
                <span class="badge">Dołącz do nas</span>
                <h1>Odkrywaj i dołączaj do najlepszych spotkań!</h1>
                <p>Znajdź wydarzenia w swojej okolicy, poznawaj nowych ludzi i spędzaj czas tak, jak lubisz najbardziej.</p>
                <div class="see-more-container">
                    <a href="{{ route('activities.index') }}" class="btn-see-more"> Zobacz wszystkie aktywności <i
                            class="fa-solid fa-arrow-right"></i> </a>
                </div>

                {{-- <div class="search-bar">
                    <input type="text" placeholder="Czego szukasz? (np. planszówki, rower...)" />
                    <button><i class="fa-solid fa-magnifying-glass"></i> Szukaj</button>
                </div> --}}
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Ludzie na koncercie" />
            </div>
        </header>
        <footer>
            <div class="footer-col">
                <h4>DoTogether</h4>
                <p>Najlepsza platforma do organizacji, dołączania do grupowych wyjść i aktywności.</p>
            </div>
            <div class="footer-col">
            </div>
            <div class="footer-col footer-col-actions">
                <a href="{{ route('profile.index') }}" class="btn-footer-profile">
                    <i class="fa-solid fa-circle-user"></i> MÓJ PROFIL
                </a>
            </div>
        </footer>
    </div>
@endsection
