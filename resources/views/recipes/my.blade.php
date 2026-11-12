@extends('layouts.app')

@section('title', 'Saját receptek')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endsection

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Saját receptek</h1>
        </div>

        @if (session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        @if (!$hasAnyRecipes)
            <p>Még nem töltöttél fel receptet. <a href="{{ route('recipes.create') }}">Tölts fel egyet most!</a></p>
        @else
            @include('partials.recipe-list', [
                'searchAction' => route('recipes.my'),
                'searchPlaceholder' => 'Saját receptek keresése...',
            ])
        @endif
    </div>
@endsection
