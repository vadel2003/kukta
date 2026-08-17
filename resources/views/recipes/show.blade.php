@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="recipe-detail">
    <!-- Banner szekció képpel és címmel -->
    <section class="recipe-banner">
        <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="banner-image">
        <div class="banner-overlay">
            <h1 class="banner-title">{{ $recipe->title }}</h1>
        </div>
        @auth
            <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="banner-favorite-form">
                @csrf
                <button type="submit" class="btn-favorite-banner {{ $isFavorited ? 'favorited' : '' }}" title="{{ $isFavorited ? 'Kedvenc törlése' : 'Kedvencnek jelölöm' }}">
                    {{ $isFavorited ? '❤️' : '🤍' }}
                </button>
            </form>
        @endauth
    </section>

    <!-- Info szekció: szerző, dátum, leírás -->
    <section class="recipe-info">
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
    </section>

    <!-- Tartalom szekció: hozzávalók és elkészítés -->
    <section class="recipe-content">
        <!-- Hozzávalók -->
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

        <!-- Elkészítés -->
        <div class="content-card steps-card">
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
        </div>
    </section>

</div>
@endsection