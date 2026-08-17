@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="recipe-detail">
    <!-- Felső szekció: kép balra, hozzávalók jobbra -->
    <section class="recipe-top">
        <!-- Bal oldal: kép + info -->
        <div class="recipe-left">
            <div class="recipe-banner">
                <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="banner-image">
                @auth
                    <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="banner-favorite-form">
                        @csrf
                        <button type="submit" class="btn-favorite-banner {{ $isFavorited ? 'favorited' : '' }}" title="{{ $isFavorited ? 'Kedvenc törlése' : 'Kedvencnek jelölöm' }}">
                            {{ $isFavorited ? '❤️' : '🤍' }}
                        </button>
                        <span class="favorite-badge">{{ $favoriteCount }}</span>
                    </form>
                @endauth
            </div>

            <h1 class="recipe-title">{{ $recipe->title }}</h1>

            <div class="recipe-info">
                <div class="recipe-meta">
                    <div class="meta-author">
                        <img src="{{ $recipe->user->avatar ? asset($recipe->user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" class="author-avatar">
                        <span>{{ $recipe->user->name }}</span>
                    </div>
                    <div class="meta-date">
                        <span class="meta-icon">📅</span>
                        <span>{{ $recipe->creation_date->format('Y. m. d.') }}</span>
                    </div>
                </div>
                <p class="recipe-description">{{ $recipe->description }}</p>
            </div>
        </div>

        <!-- Jobb oldal: hozzávalók -->
        <div class="content-card ingredients-card">
            <h2 class="content-title">
                <span class="title-icon">🥘</span>
                Hozzávalók
            </h2>
            <ul class="ingredients-list">
                @foreach ($recipe->ingredients as $ingredient)
                    <li class="ingredient-item">
                        <span class="ingredient-quantity">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span>
                        <span class="ingredient-name">{{ $ingredient->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- Alsó szekció: elkészítés -->
    <section class="content-card steps-card">
        <h2 class="content-title">
            <span class="title-icon">👨‍🍳</span>
            Elkészítés
        </h2>
        <ol class="steps-list">
            @foreach ($recipe->steps as $step)
                <li class="step-item">
                    <div class="step-number">{{ $loop->iteration }}</div>
                    <p class="step-text">{{ $step->description }}</p>
                </li>
            @endforeach
        </ol>
    </section>

</div>
@endsection