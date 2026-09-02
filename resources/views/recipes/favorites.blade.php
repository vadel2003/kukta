@extends('layouts.app')

@section('title', 'Kedvenc receptek')

@section('content')
    <h1>Kedvenc receptek</h1>

    @if ($favoriteRecipes->isEmpty())
        <p>Még nincsenek kedvenc receptjeid.</p>
    @else
        <div class="recipe-gallery">
            @foreach ($favoriteRecipes as $recipe)
                <div class="recipe-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                        <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="card-favorite-form" data-remove-card="true">
                            @csrf
                            <button type="submit" class="btn-favorite-card favorited" title="Kedvenc törlése">
                                <i data-lucide="heart"></i>
                            </button>
                            <span class="favorite-badge">{{ $recipe->favorites_count }}</span>
                        </form>
                    </div>
                    <h2>{{ $recipe->title }}</h2>

                    {{-- ⭐ Csillagos értékelés (dinamikus) --}}
                    <div class="star-rating">
                        <span class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= round($recipe->scores_avg_score ?? 0) ? 'filled' : '' }}">★</span>
                            @endfor
                        </span>
                        <span class="rating-number">{{ number_format($recipe->scores_avg_score ?? 0, 1) }}</span>
                        <span class="review-count">({{ $recipe->scores_count ?? 0 }})</span>
                    </div>

                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Megtekintés</a>

                    {{-- Hover tooltip: a recept teljes leírása --}}
                    <div class="card-tooltip">
                        <p class="tooltip-description">{{ $recipe->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection