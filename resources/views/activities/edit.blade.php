@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/activity.css') }}">
@endpush
@section('content')
    <div class="app-container">
        <!-- Nawigacja -->
        <nav class="navbar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <div class="nav-actions">
                <!-- Zmieniono link powrotny, aby sugerował powrót do panelu organizatora -->
                <a href="{{ route('profile.activities') }}" class="btn-text"><i class="fa-solid fa-arrow-left"></i> Wróć do
                    moich
                    wydarzeń</a>
            </div>
        </nav>

        <!-- Główny panel edycji -->
        <main class="add-activity-container">
            <div class="form-header">
                <h1>Edytuj aktywność</h1>
                <p>Wprowadź zmiany w swoim wydarzeniu i zaktualizuj szczegóły.</p>
            </div>

            <form class="activity-form" action="{{ route('activities.update', ['id' => $activity->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <!-- LEWA STRONA: Opis i kategoria (wypełniona danymi) -->
                    <div class="form-section main-info">
                        <div class="input-field">
                            <label for="title">Tytuł aktywności</label>
                            <input type="text" id="title" name="title" value="{{ $activity->title }}" required />
                        </div>

                        <div class="input-field">
                            <label for="description">Opis wydarzenia</label>
                            <textarea id="description" name="description" rows="6" required>{{ $activity->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="input-field">
                                <label for="category">Kategoria</label>
                                <select id="category" name="category_id" required>
                                    <option value="" disabled>Wybierz kategorię</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $activity->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- PRAWA STRONA: Szczegóły logistyczne (wypełniona danymi) -->
                    <div class="form-section logistics-info">
                        <div class="row">
                            <div class="input-field">
                                <label for="date">Data wydarzenia</label>
                                <!-- Format daty dla input type="date" to YYYY-MM-DD -->
                                <input type="date" id="date" name="event_date"
                                    value="{{ \Carbon\Carbon::parse($activity->event_date)->format('Y-m-d') }}" required />
                            </div>
                            <div class="input-field">
                                <label for="spots">Liczba wolnych miejsc</label>
                                <input type="number" id="spots" disabled name="max_participants" min="1"
                                    value="{{ $activity->max_participants }}" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field">
                                <label for="city">Miejscowość</label>
                                <input type="text" disabled id="city" name="location"
                                    value="{{ $activity->location }}" required />
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="age">Ograniczenie wiekowe</label>
                            <select id="age" name="required_age">
                                @foreach ($age_restrictions as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ $activity->required_age == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit-activity">Zapisz zmiany</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
@endsection
