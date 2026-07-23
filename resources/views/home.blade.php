@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
    <h1>Üdvözöllek a Kuktában!</h1>

    @if ($latestRecipes->isEmpty())
        <p>Még nincsenek receptek. Légy te az első, aki feltölt egyet!</p>
    @else
        <div class="recipe-gallery">
            @foreach ($latestRecipes as $recipe)
                <div class="recipe-card">
                    <img src="{{ asset('images/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                    <h2>{{ $recipe->title }}</h2>
                    <p class="recipe-author">Feltöltte: {{ $recipe->user->username }}</p>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="#" class="btn-view">Megtekintés</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
