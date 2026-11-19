@extends('layouts.app')

@section('title', $recipe->title)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/recipe_show.css') }}">
@endsection

@section('content')
    <div class="recipe_page">
        <a href="{{ route('home') }}" class="back_button always_show"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>

        @if (session('success'))
            <p class="success_box">{{ session('success') }}</p>
        @endif

        <section class="recipe_top">
            <div class="left_column">
                <div class="box">
                    <div class="banner">
                        <img src="{{ asset($recipe->thumbnail) }}" alt="{{ $recipe->title }}" class="banner_image">
                        @auth
                            <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="banner_heart_box">
                                @csrf
                                @if ($isFavorited)
                                    <button type="submit" class="banner_heart favorited" title="Kedvenc törlése">
                                        <i data-lucide="heart"></i>
                                    </button>
                                @else
                                    <button type="submit" class="banner_heart" title="Kedvencnek jelölöm">
                                        <i data-lucide="heart"></i>
                                    </button>
                                @endif
                                <span class="heart_count">{{ $favoriteCount }}</span>
                            </form>
                        @endauth
                        <div class="banner_bottom">
                            <a href="{{ route('recipes.assistant', $recipe->id) }}" class="big_button banner_button"><span class="assistant_icon"></span> Elkészítem</a>
                        </div>
                    </div>
                </div>

                <div class="box intro_card">
                    <h1 class="recipe_title">{{ $recipe->title }}</h1>

                    <div class="recipe_info">
                        <div class="date">
                            <span class="info_icon"><i data-lucide="clock"></i></span>
                            <span>{{ $recipe->prep_time }} perc</span>
                        </div>
                        <div class="date">
                            <span class="info_icon"><i data-lucide="gauge"></i></span>
                            <span>{{ ucfirst($recipe->difficultyLabel()) }}</span>
                        </div>
                        <div class="date">
                            <span class="info_icon"><i data-lucide="utensils"></i></span>
                            <span>{{ $recipe->servings }} adag</span>
                        </div>
                        <div class="author">
                            @if ($recipe->user && $recipe->user->avatar)
                                <img src="{{ asset($recipe->user->avatar) }}" alt="Profilkép" class="author_avatar">
                            @else
                                <img src="{{ asset('images/default_avatar.svg') }}" alt="Profilkép" class="author_avatar">
                            @endif
                            @if ($recipe->user)
                                <span>{{ $recipe->user->name }}</span>
                            @else
                                <span>Törölt felhasználó</span>
                            @endif
                        </div>
                        <div class="date">
                            <span class="info_icon"><i data-lucide="calendar"></i></span>
                            <span>{{ $recipe->created_at->format('Y. m. d.') }}</span>
                        </div>
                    </div>

                    <a href="#reviews" class="rating_top">
                        <span class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($averageRating))
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </span>
                        <span class="rating_number">{{ number_format($averageRating, 1) }}</span>
                        <span class="review_count">({{ $ratingCount }} értékelés)</span>
                    </a>
                </div>

                <div class="box description_card">
                    <h2 class="box_title">
                        <span class="title_icon"><i data-lucide="align-left"></i></span>
                        Leírás
                    </h2>
                    <p class="recipe_description">{{ $recipe->description }}</p>
                </div>
            </div>

            <div class="right_column">
                @if (count($freeFroms) > 0)
                    <div class="allergens_box desktop_only">
                        <ul class="allergens_list">
                            @foreach ($freeFroms as $freeFrom)
                                <li class="allergen">
                                    <img src="{{ asset($freeFrom->thumbnail) }}" alt="" class="category_icon">
                                    {{ $freeFrom->label }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="box ingredients_card">
                    <h2 class="box_title">
                        <span class="title_icon"><i data-lucide="cooking-pot"></i></span>
                        Hozzávalók
                    </h2>
                    <ul class="ingredients_list">
                        @foreach ($recipe->ingredients as $ingredient)
                            @php
                                $quantity = (float) $ingredient->pivot->quantity;
                            @endphp
                            <li class="ingredient_item">
                                <span class="quantity">{{ str_replace('.', ',', $quantity) }} {{ $units[$ingredient->pivot->unit] }}</span>
                                <span class="ingredient_name">{{ $ingredient->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <section class="box steps_card">
            <h2 class="box_title">
                <span class="title_icon"><i data-lucide="chef-hat"></i></span>
                Elkészítés
            </h2>
            <ol class="steps_list">
                @foreach ($recipe->steps as $step)
                    <li class="step_item">
                        <div class="step_number">{{ $loop->iteration }}</div>
                        <p class="step_text">{{ $step->description }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        @if (count($freeFroms) > 0)
            <div class="allergens_box mobile_only">
                <ul class="allergens_list">
                    @foreach ($freeFroms as $freeFrom)
                        <li class="allergen">
                            <img src="{{ asset($freeFrom->thumbnail) }}" alt="" class="category_icon">
                            {{ $freeFrom->label }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="box reviews_card" id="reviews">
            <h2 class="box_title">Értékelések</h2>

            <div class="ratings">
                <div class="ratings_left">
                    <div class="average">{{ number_format($averageRating, 1) }}</div>
                    <div class="average_stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star @if ($i <= round($averageRating)) filled @endif">★</span>
                        @endfor
                    </div>
                    <div class="vote_count">{{ $ratingCount }} értékelés</div>
                </div>

                <div class="ratings_right">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="bar">
                            <span class="bar_label">{{ $i }}★</span>
                            <div class="bar_bg">
                                <div class="bar_fill" style="width: {{ $distributionPercentages[$i]['percentage'] }}%"></div>
                            </div>
                            <span class="bar_number">{{ $distributionPercentages[$i]['count'] }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="line"></div>

            @auth
                <div class="my_rating">
                    <h3 class="my_rating_title">Értékeld a receptet!</h3>
                    <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST">
                        @csrf
                        <div class="my_stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="submit" name="score" value="{{ $i }}" class="star_button @if ($userRating && $i <= $userRating->score) filled @endif" title="{{ $i }} csillag">★</button>
                            @endfor
                        </div>
                        @if ($userRating)
                            <p class="my_rating_text">A te értékelésed: {{ $userRating->score }} csillag</p>
                        @else
                            <p class="my_rating_text">Kattints egy csillagra az értékeléshez</p>
                        @endif
                    </form>
                </div>
            @else
                <div class="my_rating">
                    <p class="login_text">
                        Az értékeléshez <a href="{{ route('recipes.rate.login', $recipe->id) }}">jelentkezz be</a>
                    </p>
                </div>
            @endauth
        </section>
    </div>
@endsection
