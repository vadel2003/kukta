@extends('layouts.app')

@section('title', 'Főoldal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}?v={{ filemtime(public_path('css/pages/home.css')) }}">
@endpush

@section('content')
    <!-- 1. HERO SZEKCIÓ -->
    <section id="hero" class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <h1 class="hero-title">Tapasztald meg<br>az <span class="hero-highlight">ételkészítés</span><br class="mobile-break"> új élményét!</h1>
                <p class="hero-subtitle">Próbáld ki receptjeinket a <span class="hero-assistant-badge">Kukta asszisztens <i data-lucide="bot" class="hero-subtitle-icon"></i></span> segítségével!</p>

                <div class="mobile-search-sticky">
                    <div class="search-bar">
                        <form action="{{ route('home') }}#recipes" method="GET">
                            <div class="search-row">
                                <div class="search-input-group">
                                    <i data-lucide="search" class="search-input-icon"></i>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés..." class="search-input">
                                </div>
                                <span class="search-divider"></span>
                                <button type="button" class="btn-filters" onclick="openModal('filtersModal')"><i data-lucide="filter"></i> Szűrők</button>
                                <span class="search-divider"></span>
                                <button type="button" class="btn-sort" onclick="openModal('sortModal')"><i data-lucide="arrow-up-down"></i> Rendezés</button>
                                <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/hero-food-javitott.png') }}" alt="Ételkép">
            </div>
        </div>
    </section>

    <!-- 2. RECEPT KERESŐ SZEKCIÓ -->
    <section id="recipes" class="recipes-section">

        @include('partials.recipe-search-bar', [
            'searchAction' => route('home'),
            'mealTimes' => $mealTimes,
            'foodTypes' => $foodTypes,
            'diets' => $diets,
            'allergens' => $allergens,
            'cuisines' => $cuisines,
        ])

        <div id="recipe-gallery" class="recipe-gallery">
            @include('partials.recipe-gallery')
        </div>

        @if($recipes->hasMorePages())
            <button id="load-more-btn" class="btn-load-more">További receptek betöltése...</button>
        @endif

        <div id="loading-spinner" class="loading-spinner" style="display: none;">
            <div class="spinner"></div>
            <p>Betöltés...</p>
        </div>
    </section>
@endsection