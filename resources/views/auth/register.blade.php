@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush
@section('content')
    <a href="{{ route('index') }}" class="back-home"> <i class="fa-solid fa-arrow-left"></i> Wróć do strony głównej </a>

    <div class="auth-container">
        <div class="auth-side">
            <div class="auth-logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <p>Masz już konto? Zaloguj się poniżej!</p>
            <a href="{{ route('login') }}" class="btn-outline">Zaloguj się</a>
        </div>

        <div class="auth-form-box">
            <div class="auth-header">
                <h1>Zarejestruj się</h1>
                <p class="auth-subtitle">Wprowadź swoje dane i dołącz już teraz.</p>

            </div>
            @if ($errors->any())
                <div class="auth-alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" placeholder="Nickname" name="nickname" required />
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" placeholder="Adres e-mail" name="email" required />
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="Hasło" name="password" required />
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-calendar"></i>
                    <input type="date" placeholder="Data urodzenia" name="date_of_birth" required />
                </div>

                <button type="submit" class="btn-auth">Stwórz konto</button>
            </form>
        </div>
    </div>
@endsection
