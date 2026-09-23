@extends('layouts.app')

@section('title', 'Receptek (admin)')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}?v={{ filemtime(public_path('css/admin/admin.css')) }}">
@endpush

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Receptek kezelése</h1>
        </div>

        <div class="admin-panel">
        @if (session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        <div class="ingredient-toolbar">
            <form action="{{ route('admin.recipes') }}" method="GET" class="ingredient-search">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input type="hidden" name="direction" value="{{ $direction }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Keresés cím vagy feltöltő szerint...">
                <button type="submit" class="btn-edit btn-edit-primary">Keresés</button>
                @if ($search)
                    <a href="{{ route('admin.recipes', ['sort' => $sort, 'direction' => $direction]) }}" class="btn-clear-search">Összes</a>
                @endif
            </form>

            <form id="bulk-delete-form" method="POST" action="{{ route('admin.recipes.bulkDestroy') }}" class="bulk-delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete bulk-delete-btn" disabled>Törlés</button>
            </form>
        </div>

        @if ($recipes->isEmpty())
            <p>{{ $search ? 'Nincs találat.' : 'Nincs még feltöltött recept.' }}</p>
        @else
        @php
            // Oszlopok a fejléchez - csak a ténylegesen megjelenő adatok szerint rendezhető
            $columns = [
                'title' => 'Cím',
                'user' => 'Feltöltötte',
            ];
        @endphp
        <table class="admin-table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select-all-checkbox"></th>
                    <th></th>
                    @foreach ($columns as $key => $label)
                        @php
                            $nextDirection = ($sort === $key && $direction === 'asc') ? 'desc' : 'asc';
                            $arrow = $sort === $key ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        @endphp
                        <th>
                            <a href="{{ route('admin.recipes', ['search' => $search, 'sort' => $key, 'direction' => $nextDirection]) }}">
                                {{ $label }}{{ $arrow }}
                            </a>
                        </th>
                    @endforeach
                    <th>Leírás</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recipes as $recipe)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $recipe->id }}" class="row-checkbox" form="bulk-delete-form"></td>
                        <td>
                            <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-thumbnail">
                        </td>
                        <td>{{ $recipe->title }}</td>
                        <td>{{ $recipe->user->name ?? 'törölt felhasználó' }}</td>
                        <td>{{ Str::limit($recipe->description, 100) }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-edit btn-edit-primary">Részletek</a>
                            <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt a receptet?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
        </div>
    </div>
@endsection
