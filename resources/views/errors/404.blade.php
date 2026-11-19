@extends('layouts.app')

@section('title', '404 - Az oldal nem található')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/404.css') }}">
@endsection

@section('content')
    <div class="error_page">
        <img src="{{ asset('images/assistant-figure.svg') }}" alt="" class="error_image">

        <p class="error_number">404</p>
        <h1 class="error_title">Hoppá! Nincs ilyen oldal.</h1>
        <p class="error_text">Lehet hogy kifutott, elpárolgott vagy odaégett.</p>

        <a href="{{ route('home') }}" class="home_button">
            <i data-lucide="home"></i> Vissza a főoldalra
        </a>
    </div>
@endsection
