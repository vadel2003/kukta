@extends('layouts.app')

@section('title', 'Kedvenc receptek')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}?v={{ filemtime(public_path('css/pages/home.css')) }}">
@endpush

@section('content')
    <div class="card-stack">
    <div>
        <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
        <h1>Kedvenc receptek</h1>
    </div>

    @if (!$hasAnyFavorites)
        <p>Még nincsenek kedvenc receptjeid.</p>
    @else
        <section id="recipes" class="recipes-section">
            @include('partials.recipe-search-bar', [
                'searchAction' => route('recipes.favorites'),
                'searchPlaceholder' => 'Kedvenc receptek keresése kulcsszó szerint...',
                'mealTimes' => $mealTimes,
                'foodTypes' => $foodTypes,
                'diets' => $diets,
                'freeFroms' => $freeFroms,
                'cuisines' => $cuisines,
            ])

            <div id="recipe-gallery" class="recipe-gallery">
                @include('partials.recipe-gallery')
            </div>

            @if ($recipes->hasMorePages())
                <button id="load-more-btn" class="btn-load-more">További receptek betöltése...</button>
            @endif

            <div id="loading-spinner" class="loading-spinner" style="display: none;">
                <div class="spinner"></div>
                <p>Betöltés...</p>
            </div>
        </section>
    @endif
    </div>
@endsection
