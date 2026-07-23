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
                    <img src="{{ asset('images/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                    <h2>{{ $recipe->title }}</h2>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <p><strong>Létrehozva:</strong> {{ $recipe->creation_date->format('Y-m-d') }}</p>
                </div>
            @endforeach
        </div>
    @endif
@endsection
