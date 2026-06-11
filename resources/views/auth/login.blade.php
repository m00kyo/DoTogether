@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
@endpush
@section('content')
    <a href="{{ route('index') }}" class="back-home"> <i class="fa-solid fa-arrow-left"></i> Wróć do strony głównej </a>

    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="auth-container">
        <div class="auth-side">
            <div class="auth-logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <p>Nie masz jeszcze konta? Dołącz do naszej społeczności poniżej!</p>
            <a href="{{ route('register') }}" class="btn-outline">Zarejestruj się</a>
        </div>

        <div class="auth-form-box">
            <div class="auth-header">
                <h1>Zaloguj się</h1>
                <p class="auth-subtitle">Wprowadź swoje dane, aby kontynuować.</p>
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
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Adres e-mail" required value="{{ old('email') }}" />
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Hasło" required />
                </div>

                <button type="submit" class="btn-auth">Zaloguj się</button>
            </form>
        </div>
    </div>
@endsection
