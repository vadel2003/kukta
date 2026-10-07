@extends('layouts.app')

@section('title', 'Impresszum')

@section('content')
    <section class="page-section">
        <div class="card-stack">
            <div>
                <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
                <h1>Impresszum</h1>
            </div>
            <div class="content-card legal-text">
                <h2>Az oldal üzemeltetője</h2>
                <ul>
                    <li>Név: Völgyi Adél</li>
                    <li>E-mail: <a href="mailto:info@kukta.hu">info@kukta.hu</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
