@extends('layouts.app')

@section('title', 'Impresszum')

@section('content')
    <section class="page">
        <div class="column">
            <div>
                <a href="{{ route('home') }}" class="back_button always_show"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
                <h1>Impresszum</h1>
            </div>
            <div class="box legal_text">
                <h2>Az oldal üzemeltetője</h2>
                <ul>
                    <li>Név: Völgyi Adél</li>
                    <li>E-mail: <a href="mailto:info@kukta.hu">info@kukta.hu</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
