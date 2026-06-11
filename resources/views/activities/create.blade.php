@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/activity.css') }}">
@endpush
@section('content')
    <div class="app-container">
        <nav class="navbar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <div class="nav-actions">
                <a href="{{ route('index') }}" class="btn-text"><i class="fa-solid fa-arrow-left"></i> Wróć do strony głównej</a>
            </div>
        </nav>

        <main class="add-activity-container">
            <div class="form-header">
                <h1>Stwórz nową aktywność</h1>
                <p>Zorganizuj spotkanie, znajdź ekipę i spędźcie miło czas razem!</p>
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
            <form class="activity-form" action="{{ route('activities.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-section main-info">
                        <div class="input-field">
                            <label for="title">Tytuł aktywności</label>
                            <input type="text" id="title" name="title"
                                placeholder="np. Wieczór z planszówkami w pubie" required />
                        </div>

                        <div class="input-field">
                            <label for="description">Opis wydarzenia</label>
                            <textarea id="description" name="description" rows="6"
                                placeholder="Napisz coś więcej o planowanym spotkaniu. Gdzie dokładnie się widzicie? Co warto ze sobą zabrać? Jaki jest plan?"
                                required></textarea>
                        </div>

                        <div class="row">
                            <div class="input-field">
                                <label for="category">Kategoria</label>
                                <select id="category" name="category_id" required>
                                    <option value="" disabled selected>Wybierz kategorię</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-section logistics-info">
                        <div class="row">
                            <div class="input-field">
                                <label for="date">Data wydarzenia</label>
                                <input type="date" id="date" name="event_date" required />
                            </div>
                            <div class="input-field">
                                <label for="spots">Liczba wolnych miejsc</label>
                                <input type="number" id="spots" name="max_participants" min="1"
                                    placeholder="np. 5" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field">
                                <label for="city">Miejscowość</label>
                                <div class="location-container">

                                    <input type="text" name="location" placeholder="np. Warszawa" id="city"
                                        autocomplete="off" name="location" value="{{ request('location') }}" />
                                    <div class="autocomplete_loc"></div>
                                </div>
                                <input type="hidden" name="lat" id="lat" value="{{ request('lat') }}" />
                                <input type="hidden" name="long" id="long" value="{{ request('long') }}" />
                                <script defer>
                                    let changeDebounceTimer = null;
                                    document.getElementById('city').addEventListener('input', function() {
                                        const city = this.value;
                                        const lat_input = document.getElementById('lat');
                                        const long_input = document.getElementById('long');
                                        clearTimeout(changeDebounceTimer);
                                        changeDebounceTimer = setTimeout(() => {
                                            fetch(
                                                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(city)}&countrycodes=pl&limit=5&featuretype=city&addressdetails=1`
                                                )
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.length > 0) {

                                                        document.querySelector('.autocomplete_loc').innerHTML = '';
                                                        for (const item of data) {
                                                            const displayName = item.address.city || item.address.town || item
                                                                .address.village || item.display_name;
                                                            const fullDisplayName =
                                                                `${displayName}, ${item.address.state || item.address.county || ''}`;
                                                            const option = document.createElement('div');
                                                            option.classList.add('autocomplete-option');
                                                            option.textContent = fullDisplayName;
                                                            option.addEventListener('mousedown', () => {
                                                                document.getElementById('city').value = fullDisplayName;
                                                                lat_input.value = item.lat;
                                                                long_input.value = item.lon;
                                                                document.querySelector('.autocomplete_loc').innerHTML = '';
                                                            });
                                                            document.querySelector('.autocomplete_loc').appendChild(option);
                                                        }

                                                    } else {
                                                        lat_input.value = '';
                                                        long_input.value = '';
                                                    }
                                                })
                                                .catch(() => {
                                                    lat_input.value = '';
                                                    long_input.value = '';
                                                });
                                        }, 200);

                                    });
                                    document.getElementById('city').addEventListener('blur', function() {
                                        document.querySelector('.autocomplete_loc').innerHTML = '';
                                    });
                                </script>


                            </div>

                        </div>

                        <div class="input-field">
                            <label for="age">Ograniczenie wiekowe</label>
                            <select id="age">
                                <option value="" disabled selected>Wybierz ograniczenie wiekowe</option>
                                @foreach ($age_restrictions as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit-activity">Opublikuj aktywność</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
@endsection
