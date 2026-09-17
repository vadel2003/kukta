@extends('layouts.app')

@section('title', 'Receptek (admin)')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}?v={{ filemtime(public_path('css/admin/admin.css')) }}">
@endpush

@section('content')
    <h1>Receptek kezelése</h1>

    @if ($recipes->isEmpty())
        <p>Nincs még feltöltött recept.</p>
    @else
        <div class="recipe-gallery">
            @foreach ($recipes as $recipe)
                <div class="recipe-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                    </div>
                    <h2>{{ $recipe->title }}</h2>
                    <p><strong>Feltöltötte:</strong> {{ $recipe->user->name ?? 'törölt felhasználó' }}</p>
                    <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Részletek</a>
                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt a receptet?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Törlés</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
@endsection
