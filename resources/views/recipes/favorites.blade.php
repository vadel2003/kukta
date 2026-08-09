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
                    <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                    <h2>{{ $recipe->title }}</h2>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <p>
                        <strong>Feltöltötte:</strong>
                        <img src="{{ $recipe->user->avatar ? asset($recipe->user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; vertical-align: middle;">
                        {{ $recipe->user->name }}
                    </p>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Megtekintés</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection