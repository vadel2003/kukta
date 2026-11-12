@extends('layouts.app')

@section('title', $recipe->title)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/recipe_show.css') }}">
@endsection

@section('content')
    <div class="recipe-detail">
        <a href="{{ route('home') }}" class="back-link back-link--always"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>

        @if (session('success'))
            <p class="alert-success">{{ session('success') }}</p>
        @endif

        <section class="recipe-top">
            <div class="recipe-left">
                <div class="content-card">
                    <div class="recipe-banner">
                        <img src="{{ asset($recipe->thumbnail) }}" alt="{{ $recipe->title }}" class="banner-image">
                        @auth
                            <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="banner-favorite-form">
                                @csrf
                                <button type="submit" class="btn-favorite-banner {{ $isFavorited ? 'favorited' : '' }}" title="{{ $isFavorited ? 'Kedvenc törlése' : 'Kedvencnek jelölöm' }}">
                                    <i data-lucide="heart"></i>
                                </button>
                                <span class="favorite-badge">{{ $favoriteCount }}</span>
                            </form>
                        @endauth
                        <div class="banner-cook-overlay">
                            <a href="{{ route('recipes.assistant', $recipe->id) }}" class="btn-cook btn-cook-banner"><span class="icon-assistant" aria-hidden="true"></span> Elkészítem</a>
                        </div>
                    </div>
                </div>

                <div class="content-card intro-card">
                    <h1 class="recipe-title">{{ $recipe->title }}</h1>

                    <div class="recipe-meta">
                        <div class="meta-date">
                            <span class="meta-icon"><i data-lucide="clock"></i></span>
                            <span>{{ $recipe->prep_time }} perc</span>
                        </div>
                        <div class="meta-date">
                            <span class="meta-icon"><i data-lucide="gauge"></i></span>
                            <span>{{ ucfirst($recipe->difficultyLabel()) }}</span>
                        </div>
                        <div class="meta-date">
                            <span class="meta-icon"><i data-lucide="utensils"></i></span>
                            <span>{{ $recipe->servings }} adag</span>
                        </div>
                        <div class="meta-author">
                            <img src="{{ $recipe->user?->avatar ? asset($recipe->user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" class="author-avatar">
                            <span>{{ $recipe->user?->name ?? 'Törölt felhasználó' }}</span>
                        </div>
                        <div class="meta-date">
                            <span class="meta-icon"><i data-lucide="calendar"></i></span>
                            <span>{{ $recipe->created_at->format('Y. m. d.') }}</span>
                        </div>
                    </div>

                    <a href="#reviews" class="star-rating-section">
                        <span class="stars">{{ str_repeat('★', round($averageRating)) }}{{ str_repeat('☆', 5 - round($averageRating)) }}</span>
                        <span class="rating-number">{{ number_format($averageRating, 1) }}</span>
                        <span class="review-count">({{ $ratingCount }} értékelés)</span>
                    </a>
                </div>

                <div class="content-card description-card">
                    <h2 class="content-title">
                        <span class="title-icon"><i data-lucide="align-left"></i></span>
                        Leírás
                    </h2>
                    <p class="recipe-description">{{ $recipe->description }}</p>
                </div>
            </div>

            <div class="recipe-right">
                @include('partials.recipe-allergens', ['modifier' => 'allergens-box--desktop'])

                <div class="content-card ingredients-card">
                    <h2 class="content-title">
                        <span class="title-icon"><i data-lucide="cooking-pot"></i></span>
                        Hozzávalók
                    </h2>
                    <ul class="ingredients-list">
                        @foreach ($recipe->ingredients as $ingredient)
                            <li class="ingredient-item">
                                <span class="ingredient-quantity">{{ str_replace('.', ',', (float) $ingredient->pivot->quantity) }} {{ \App\Models\IngredientRecipe::UNITS[$ingredient->pivot->unit] ?? '' }}</span>
                                <span class="ingredient-name">{{ $ingredient->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <section class="content-card steps-card">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="chef-hat"></i></span>
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

        @include('partials.recipe-allergens', ['modifier' => 'allergens-box--mobile'])

        <section class="content-card reviews-card" id="reviews">
            <h2 class="content-title">Értékelések</h2>

            <div class="rating-summary">
                <div class="rating-summary-left">
                    <div class="rating-average">{{ number_format($averageRating, 1) }}</div>
                    <div class="rating-stars-display">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">★</span>
                        @endfor
                    </div>
                    <div class="rating-count">{{ $ratingCount }} értékelés</div>
                </div>

                <div class="rating-summary-right">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="rating-bar">
                            <span class="rating-bar-label">{{ $i }}★</span>
                            <div class="rating-bar-track">
                                <div class="rating-bar-fill" style="width: {{ $distributionPercentages[$i]['percentage'] }}%"></div>
                            </div>
                            <span class="rating-bar-count">{{ $distributionPercentages[$i]['count'] }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="rating-divider"></div>

            @auth
                <div class="rating-personal">
                    <h3 class="rating-personal-title">Értékeld a receptet!</h3>
                    <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST">
                        @csrf
                        <div class="rating-stars-interactive">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="submit" name="score" value="{{ $i }}" class="star-button {{ $userRating && $i <= $userRating->score ? 'filled' : '' }}" title="{{ $i }} csillag">★</button>
                            @endfor
                        </div>
                        @if ($userRating)
                            <p class="rating-personal-status">A te értékelésed: {{ $userRating->score }} csillag</p>
                        @else
                            <p class="rating-personal-status">Kattints egy csillagra az értékeléshez</p>
                        @endif
                    </form>
                </div>
            @else
                <div class="rating-personal">
                    <p class="rating-login-prompt">
                        Az értékeléshez <a href="{{ route('recipes.rate.login', $recipe->id) }}">jelentkezz be</a>
                    </p>
                </div>
            @endauth
        </section>
    </div>
@endsection
