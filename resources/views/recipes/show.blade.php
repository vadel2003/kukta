@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <h1>{{ $recipe->title }}</h1>

    <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-detail-image">

    <p>
        <strong>Feltöltötte:</strong>
        <img src="{{ $recipe->user->avatar ? asset($recipe->user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; vertical-align: middle;">
        {{ $recipe->user->name }}
    </p>
    <p><strong>Dátum:</strong> {{ $recipe->creation_date->format('Y-m-d') }}</p>

    <p>{{ $recipe->description }}</p>

    <h2>Hozzávalók</h2>
    <ul>
        @foreach ($recipe->ingredients as $ingredient)
            <li>{{ $ingredient->name }} – {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</li>
        @endforeach
    </ul>

    <h2>Elkészítés</h2>
    <ol>
        @foreach ($recipe->steps as $step)
            <li>{{ $step->description }}</li>
        @endforeach
    </ol>

    @auth
        <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-favorite {{ $isFavorited ? 'favorited' : '' }}">
                {{ $isFavorited ? '❤️ Kedvenc törlése' : '🤍 Kedvencnek jelölöm' }}
            </button>
        </form>
    @endauth
@endsection
