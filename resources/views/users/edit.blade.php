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
                <li><a href="{{ route('profile.index') }}"><i class="fa-solid fa-table-cells-large"></i> Pulpit</a></li>
                <li><a href="{{ route('profile.activities') }}"><i class="fa-solid fa-calendar-check"></i> Moje
                        wydarzenia</a></li>
                <li><a href="{{ route('profile.participations') }}"><i class="fa-solid fa-user-check"></i> Dołączone</a>
                </li>
                <li class="active"><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen"></i> Moje dane</a>
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


            <div class="dash-card" style="max-width: 600px;">
                <div class="card-header"
                    style="margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                    <span class="card-title" style="font-size: 18px;">Zmień swoje dane</span>
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

                <form class="profile-edit-form" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="username">Nazwa użytkownika</label>
                        <input type="text" id="username" name="nickname"
                            value="{{ old('nickname', Auth::user()->nickname ?? '') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Adres e-mail</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', Auth::user()->email ?? '') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="birthdate">Data urodzenia</label>
                        <input type="date" id="birthdate" name="date_of_birth"
                            value="{{ old('date_of_birth', Auth::user()->date_of_birth ?? '') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="description">Opis</label>
                        <textarea id="description" name="bio" rows="5"
                            placeholder="Napisz kilka słów o sobie, swoich zainteresowaniach, co lubisz robić w wolnym czasie...">{{ old('bio', Auth::user()->bio ?? '') }}</textarea>
                    </div>

                    <div class="form-actions" style="margin-top: 16px; display: flex; gap: 16px;">
                        <button type="submit" class="btn-save-profile">Zapisz zmiany</button>
                        <a href="{{ route('profile.index') }}" class="btn-cancel-profile">Anuluj</a>
                    </div>

                </form>
            </div>
        </main>
    </div>
@endsection
