@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
    <!-- 1. HERO SZEKCIÓ -->
    <section id="hero" class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <h1 class="hero-title">Tapasztald meg<br>az <span class="hero-highlight">ételkészítés</span> új élményét!</h1>
                <p class="hero-subtitle">Fedezd fel receptjeinket és főzz otthon, mint egy profi!</p>
                <div class="hero-buttons">
                    <a href="#recipes" class="btn-primary">Receptek keresése</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/hero-food.png') }}" alt="Ételkép">
            </div>
        </div>
    </section>

    <!-- 2. RECEPT KERESŐ SZEKCIÓ -->
    <section id="recipes" class="recipes-section">

        <!-- Szűrő űrlap -->
        <form action="{{ route('home') }}" method="GET" class="filter-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés a receptek között..." class="filter-search">

            <select name="meal_time" class="filter-select">
                <option value="">Étkezés: Összes</option>
                @foreach ($mealTimes as $mealTime)
                    <option value="{{ $mealTime->id }}" {{ request('meal_time') == $mealTime->id ? 'selected' : '' }}>{{ $mealTime->name }}</option>
                @endforeach
            </select>

            <select name="food_type" class="filter-select">
                <option value="">Ételtípus: Összes</option>
                @foreach ($foodTypes as $foodType)
                    <option value="{{ $foodType->id }}" {{ request('food_type') == $foodType->id ? 'selected' : '' }}>{{ $foodType->name }}</option>
                @endforeach
            </select>

            <select name="diet" class="filter-select">
                <option value="">Diéta: Összes</option>
                @foreach ($diets as $diet)
                    <option value="{{ $diet->id }}" {{ request('diet') == $diet->id ? 'selected' : '' }}>{{ $diet->name }}</option>
                @endforeach
            </select>

            <select name="allergen" class="filter-select">
                <option value="">Allergén: Összes</option>
                @foreach ($allergens as $allergen)
                    <option value="{{ $allergen->id }}" {{ request('allergen') == $allergen->id ? 'selected' : '' }}>{{ $allergen->name }}</option>
                @endforeach
            </select>

            <select name="cuisine" class="filter-select">
                <option value="">Konyha: Összes</option>
                @foreach ($cuisines as $cuisine)
                    <option value="{{ $cuisine->id }}" {{ request('cuisine') == $cuisine->id ? 'selected' : '' }}>{{ $cuisine->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter">Szűrés</button>
            <a href="{{ route('home') }}" class="btn-reset">Összes recept</a>
        </form>

        <div class="recipe-gallery">
            @forelse ($recipes as $recipe)
                <div class="recipe-card">
                    <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                    <h2>{{ $recipe->title }}</h2>
                    <p class="recipe-author">
                        Feltöltte:
                        <img src="{{ $recipe->user->avatar ? asset($recipe->user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; vertical-align: middle;">
                        {{ $recipe->user->name }}
                    </p>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Megtekintés</a>
                    @auth
                        <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-favorite-card {{ in_array($recipe->id, $favoriteIds) ? 'favorited' : '' }}">
                                {{ in_array($recipe->id, $favoriteIds) ? '❤️' : '🤍' }}
                            </button>
                        </form>
                    @endauth
                </div>
            @empty
                <p class="no-results">Nem található recept a megadott szűrési feltételekkel.</p>
            @endforelse
        </div>
    </section>
@endsection