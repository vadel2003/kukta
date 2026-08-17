@extends('layouts.app')

@section('title', 'Saját receptek')

@section('content')
    <h1>Saját receptek</h1>

    @if ($myRecipes->isEmpty())
        <p>Még nem töltöttél fel receptet. <a href="{{ route('recipes.create') }}">Tölts fel egyet most!</a></p>
    @else
        <div class="recipe-gallery">
            @foreach ($myRecipes as $recipe)
                <div class="recipe-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                        <span class="card-favorite-count">{{ $recipe->favorites_count }} kedvelés</span>
                    </div>
                    <h2>{{ $recipe->title }}</h2>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <p><strong>Létrehozva:</strong> {{ $recipe->creation_date->format('Y-m-d') }}</p>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Megtekintés</a>
                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-edit">Szerkesztés</a>
                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt a receptet?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Törlés</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
@endsection
