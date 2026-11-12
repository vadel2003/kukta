@extends('layouts.app')

@section('title', 'Kedvenc receptek')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endsection

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Kedvenc receptek</h1>
        </div>

        @if (!$hasAnyFavorites)
            <p>Még nincsenek kedvenc receptjeid.</p>
        @else
            @include('partials.recipe-list', [
                'searchAction' => route('recipes.favorites'),
                'searchPlaceholder' => 'Kedvencek keresése...',
            ])
        @endif
    </div>
@endsection
