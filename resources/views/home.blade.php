@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
    <h1>Tapasztald meg az ételkészítés új élményét</h1>
        <div class="recipe-gallery">
            @foreach ($latestRecipes as $recipe)
                <div class="recipe-card">
                    <img src="{{ asset('images/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                    <h2>{{ $recipe->title }}</h2>
                    <p class="recipe-author">Feltöltte: {{ $recipe->user->name }}</p>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Megtekintés</a>
                </div>
            @endforeach
        </div>
@endsection
