@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/activity.css') }}?v={{ filemtime(public_path('css/activity.css')) }}">
@endpush
@section('content')
    <div class="app-container">
        <!-- Nawigacja z przyciskiem powrotu -->
        <nav class="navbar">
            <div class="logo"><i class="fa-solid fa-users-viewfinder"></i> Do<span>Together</span></div>
            <div class="nav-actions">
                <a href="{{ route('index') }}" class="btn-text"><i class="fa-solid fa-arrow-left"></i> Wróć do strony
                    głównej</a>
            </div>
        </nav>

        <!-- Sekcja Filtrów -->
        <section class="filters-section">
            <h3><i class="fa-solid fa-filter"></i> Znajdź idealne wydarzenie</h3>
            <form class="filters-form">
                <div class="filter-group">
                    <label>Kiedy?</label>
                    <input type="date" name="event_date" value="{{ request('event_date') }}" />
                </div>
                <div class="filter-group">
                    <label>Ile miejsc potrzebujesz?</label>
                    <input type="number" min="1" name="available_spots" placeholder="np. 3"
                        value="{{ request('available_spots') }}" />
                </div>
                <div class="filter-group">
                    <label>Kategoria</label>

                    <select name="category_id">
                        <option value="">Wszystkie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Wiek</label>
                    <select name="required_age">
                        <option value="">Wszystkie</option>
                        <option value="NO_RESTRICTION" {{ request('required_age') == 'NO_RESTRICTION' ? 'selected' : '' }}>
                            Bez ograniczeń
                        </option>
                        <option value="KIDS" {{ request('required_age') == 'KIDS' ? 'selected' : '' }}>
                            Dzieci
                        </option>
                        <option value="ADULTS_ONLY" {{ request('required_age') == 'ADULTS_ONLY' ? 'selected' : '' }}>
                            18+
                        </option>
                        <option value="SENIORS" {{ request('required_age') == 'SENIORS' ? 'selected' : '' }}>
                            40+
                        </option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Miejscowość</label>
                    <div class="location-container">

                        <input type="text" placeholder="np. Warszawa" id="city" autocomplete="off" name="location"
                            value="{{ request('location') }}" />
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
                <div class="filter-group">
                    <label>Odległość</label>
                    <input type="number" min="1" placeholder="np. 10 km" name="distance"
                        value="{{ request('distance') }}" />
                </div>
                <button type="submit" class="btn-filter">Filtruj</button>
            </form>
        </section>

        <!-- Siatka Wydarzeń (Karty) -->
        <section class="listings">
            <h2 class="listings-header">Dostępne wydarzenia</h2>

            <div class="grid-container">
                @foreach ($activities as $activity)
                    <div class="card">

                        <div class="card-content">

                            <!-- Górny wiersz: Data i Lokalizacja -->
                            <div class="card-meta">
                                <div class="meta-item">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($activity->event_date)->locale('pl')->translatedFormat('j F Y') }}</span>
                                </div>
                                @if ($activity->location)
                                    <div class="meta-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>{{ $activity->location }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Tytuł -->
                            <h3 class="card-title">{{ $activity->title }}</h3>

                            <!-- Środkowy wiersz: Odległość i Kategoria -->
                            <div class="card-subtitle-row">
                                @if ($activity->distance !== null)
                                    <span class="card-distance">
                                        <i class="fa-solid fa-location-dot"></i>
                                        {{ number_format($activity->distance, 2, ',', ' ') }} km
                                    </span>
                                @endif

                                <div class="card-category cat-rozrywka">{{ $activity->category->name }}</div>
                            </div>

                            <!-- Stopka: Miejsca i Przycisk -->
                            <div class="card-footer">
                                <span class="spots">
                                    <i class="fa-solid fa-user-group"></i>
                                    {{ $activity->available_spots }} wolne miejsca
                                </span>
                                <a class="btn-more" href="{{ route('activities.details', $activity->id) }}">SZCZEGÓŁY</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <footer>
           <div class="footer-col">
                <h4>DoTogether</h4>
                <p>Najlepsza platforma do organizacji, dołączania do grupowych wyjść i aktywności.</p>
            </div>
            <div class="footer-col">
            </div>
            <div class="footer-col footer-col-actions">
                <a href="{{ route('profile.index') }}" class="btn-footer-profile">
                    <i class="fa-solid fa-circle-user"></i> Mój profil
                </a>
            </div>
        </footer>
    </div>
@endsection
