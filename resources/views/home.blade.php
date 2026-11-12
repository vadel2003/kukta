@extends('layouts.app')

@section('title', 'Főoldal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endsection

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
                                <button type="button" class="btn-filters {{ $activeFilterCount > 0 ? 'has-filters' : '' }}" popovertarget="filtersModal">
                                    <i data-lucide="filter"></i> Szűrők
                                    @if ($activeFilterCount > 0)
                                        <span class="filter-count">{{ $activeFilterCount }}</span>
                                    @endif
                                </button>
                                <span class="search-divider"></span>
                                <button type="button" class="btn-sort" popovertarget="sortModal"><i data-lucide="arrow-up-down"></i> Rendezés</button>
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
