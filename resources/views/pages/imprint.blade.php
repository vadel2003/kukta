@extends('layouts.app')

@section('title', 'Impresszum')

@section('content')
    <section class="page-section">
        <div class="card-stack">
            <div class="content-card">
                <h1>Impresszum</h1>
            </div>
            <div class="content-card legal-text">
                <h2>Az oldal üzemeltetője</h2>
                <ul>
                    <li>Név: [Üzemeltető neve]</li>
                    <li>Cím: [Postacím]</li>
                    <li>E-mail: <a href="mailto:info@kukta.hu">info@kukta.hu</a></li>
                    {{-- Csak ha cég vagy egyéni vállalkozó üzemelteti - magánszemélynél töröld ezt a két sort --}}
                    <li>Nyilvántartási szám / cégjegyzékszám: [Szám]</li>
                    <li>Adószám: [Adószám]</li>
                </ul>

                <h2>Tárhelyszolgáltató</h2>
                <ul>
                    <li>Név: [Tárhelyszolgáltató neve]</li>
                    <li>Cím: [Tárhelyszolgáltató székhelye]</li>
                    <li>E-mail: [Tárhelyszolgáltató e-mail címe]</li>
                </ul>

                <h2>Kapcsolódó dokumentumok</h2>
                <ul>
                    <li><a href="{{ route('page.terms') }}">Általános szerződési feltételek</a></li>
                    <li><a href="{{ route('page.privacy') }}">Adatkezelési tájékoztató</a></li>
                    <li><a href="{{ route('page.cookies') }}">Süti tájékoztató</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
