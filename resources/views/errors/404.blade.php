@extends('layouts.app')

@section('title', '404 - Az oldal nem található')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/404.css') }}">
@endsection

@section('content')
    <div class="error-page">
        <img src="{{ asset('images/assistant-figure.svg') }}" alt="" class="error-image">

        <p class="error-code">404</p>
        <h1 class="error-title">Hoppá! Nincs ilyen oldal.</h1>
        <p class="error-text">Lehet hogy kifutott, elpárolgott vagy odaégett.</p>

        <a href="{{ route('home') }}" class="btn-home">
            <i data-lucide="home"></i> Vissza a főoldalra
        </a>
    </div>
@endsection
