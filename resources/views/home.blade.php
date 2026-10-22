@extends('layouts.app')

@section('title', 'Főoldal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}?v={{ filemtime(public_path('css/pages/home.css')) }}">
@endpush

@section('content')
    <section id="hero" class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <h1 class="hero-title">Tapasztald meg<br>az <span class="hero-highlight">ételkészítés</span><br class="mobile-break"> új élményét!</h1>
                <p class="hero-subtitle">Próbáld ki receptjeinket a <span class="hero-assistant-badge">Kukta asszisztens <span class="icon-assistant hero-subtitle-icon" aria-hidden="true"></span></span> segítségével!</p>

                <div class="mobile-search-sticky">
                    <div class="search-bar">
                        <form action="{{ route('home') }}#recipes" method="GET">
                            <div class="search-row">
                                <div class="search-input-group">
                                    <i data-lucide="search" class="search-input-icon"></i>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés..." class="search-input">
                                </div>
                                <span class="search-divider"></span>
                                <button type="button" class="btn-filters" data-modal-open="filtersModal"><i data-lucide="filter"></i> Szűrők <span class="filter-count" hidden></span></button>
                                <span class="search-divider"></span>
                                <button type="button" class="btn-sort" data-modal-open="sortModal"><i data-lucide="arrow-up-down"></i> Rendezés</button>
                                <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/hero-food.png') }}" alt="Ételkép">
            </div>
        </div>
    </section>

    @include('partials.recipe-list', ['searchAction' => route('home')])
@endsection
