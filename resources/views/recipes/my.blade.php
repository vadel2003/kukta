@extends('layouts.app')

@section('title', 'Saját receptek')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}?v={{ filemtime(public_path('css/pages/home.css')) }}">
@endpush

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Saját receptek</h1>
        </div>

        @if (!$hasAnyRecipes)
            <p>Még nem töltöttél fel receptet. <a href="{{ route('recipes.create') }}">Tölts fel egyet most!</a></p>
        @else
            @include('partials.recipe-list', [
                'searchAction' => route('recipes.my'),
                'searchPlaceholder' => 'Saját receptek keresése kulcsszó szerint...',
            ])
        @endif
    </div>
@endsection
