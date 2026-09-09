@extends('layouts.app')

@section('title', '404 - Az oldal nem található')

@section('content')
    <div class="error-page">
        <div class="kukta" aria-hidden="true">
            <div class="kukta-steam">
                <span class="kukta-puff"></span>
                <span class="kukta-puff"></span>
                <span class="kukta-puff"></span>
            </div>
            <span class="kukta-valve"></span>
            <div class="kukta-lid"></div>
            <span class="kukta-handle kukta-handle-l"></span>
            <span class="kukta-handle kukta-handle-r"></span>
            <div class="kukta-body">
                <span class="kukta-eye kukta-eye-l"></span>
                <span class="kukta-eye kukta-eye-r"></span>
                <span class="kukta-mouth"></span>
            </div>
        </div>

        <p class="error-code">404</p>
        <h1 class="error-title">Hoppá! Ez a kukta elpárolgott.</h1>
        <p class="error-text">Az oldal, amit keresel, nem található. Lehet, hogy kifutott, elpárolgott, vagy valaki levette a fedőt.</p>

        <a href="{{ route('home') }}" class="btn-home">
            <i data-lucide="home"></i> Vissza a főoldalra
        </a>
    </div>
@endsection
