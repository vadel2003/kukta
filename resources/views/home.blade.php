@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
    <!-- 1. HERO SZEKCIÓ -->
    <section id="hero" class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <h1 class="hero-title">Tapasztald meg<br>az <span class="hero-highlight">ételkészítés</span> új élményét!</h1>
                <p class="hero-subtitle">Fedezd fel receptjeinket és főzz otthon, mint egy profi!</p>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/hero-food-javitott.png') }}" alt="Ételkép">
            </div>
        </div>
    </section>

    <!-- 2. RECEPT KERESŐ SZEKCIÓ -->
    <section id="recipes" class="recipes-section">

        <!-- Modern kereső sáv -->
        <div class="search-bar">
            <form action="{{ route('home') }}" method="GET" id="searchForm">
                <div class="search-row">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Receptek keresése kulcsszó szerint..." class="search-input" autofocus>
                    <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
                    <button type="button" class="btn-filters" onclick="openModal('filtersModal')"><i data-lucide="filter"></i> Szűrők</button>
                    <button type="button" class="btn-sort" onclick="openModal('sortModal')"><i data-lucide="arrow-up-down"></i> Rendezés</button>
                </div>
            </form>
        </div>

        <!-- Szűrők Modal -->
        <div id="filtersModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Szűrők</h3>
                            <button type="button" class="close-btn" onclick="closeModal('filtersModal')">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!-- Étkezés -->
                            <div class="filter-group">
                                <h4>Étkezés</h4>
                                @foreach ($mealTimes as $mealTime)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="meal_time[]" value="{{ $mealTime->id }}" {{ in_array($mealTime->id, (array)request('meal_time')) ? 'checked' : '' }}>
                                        {{ $mealTime->name }}
                                    </label>
                                @endforeach
                            </div>

                            <!-- Ételtípus -->
                            <div class="filter-group">
                                <h4>Ételtípus</h4>
                                @foreach ($foodTypes as $foodType)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="food_type[]" value="{{ $foodType->id }}" {{ in_array($foodType->id, (array)request('food_type')) ? 'checked' : '' }}>
                                        {{ $foodType->name }}
                                    </label>
                                @endforeach
                            </div>

                            <!-- Diéta -->
                            <div class="filter-group">
                                <h4>Diéta</h4>
                                @foreach ($diets as $diet)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="diet[]" value="{{ $diet->id }}" {{ in_array($diet->id, (array)request('diet')) ? 'checked' : '' }}>
                                        {{ $diet->name }}
                                    </label>
                                @endforeach
                            </div>

                            <!-- Allergén -->
                            <div class="filter-group">
                                <h4>Allergén</h4>
                                @foreach ($allergens as $allergen)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="allergen[]" value="{{ $allergen->id }}" {{ in_array($allergen->id, (array)request('allergen')) ? 'checked' : '' }}>
                                        {{ $allergen->name }}
                                    </label>
                                @endforeach
                            </div>

                            <!-- Konyha -->
                            <div class="filter-group">
                                <h4>Konyha</h4>
                                @foreach ($cuisines as $cuisine)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="cuisine[]" value="{{ $cuisine->id }}" {{ in_array($cuisine->id, (array)request('cuisine')) ? 'checked' : '' }}>
                                        {{ $cuisine->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-apply">Szűrés alkalmazása</button>
                            <a href="{{ route('home') }}" class="btn-reset">Összes recept</a>
                        </div>
                    </div>
                </div>

        <!-- Rendezés Modal -->
        <div id="sortModal" class="modal">
            <div class="modal-content modal-small">
                <div class="modal-header">
                    <h3>Rendezés</h3>
                    <button type="button" class="close-btn" onclick="closeModal('sortModal')">&times;</button>
                </div>
                <div class="modal-body">
                    <label class="radio-label">
                        <input type="radio" name="sort" value="relevance" {{ request('sort', 'relevance') == 'relevance' ? 'checked' : '' }}>
                        Relevancia
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="sort" value="date" {{ request('sort') == 'date' ? 'checked' : '' }}>
                        Frissesség
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="sort" value="popularity" {{ request('sort') == 'popularity' ? 'checked' : '' }}>
                        Népszerűség
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-apply">Rendezés alkalmazása</button>
                </div>
            </div>
        </div>

        <div id="recipe-gallery" class="recipe-gallery">
            @include('partials.recipe-gallery')
        </div>

        @if($recipes->hasMorePages())
            <button id="load-more-btn" class="btn-load-more">További receptek betöltése...</button>
        @endif

        <div id="loading-spinner" class="loading-spinner" style="display: none;">
            <div class="spinner"></div>
            <p>Betöltés...</p>
        </div>
    </section>
@endsection