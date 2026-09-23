@extends('layouts.app')

@section('title', 'Alapanyagok (admin)')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}?v={{ filemtime(public_path('css/admin/admin.css')) }}">
@endpush

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Alapanyagok kezelése</h1>
        </div>

        <div class="admin-panel">
        @if (session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <ul class="form-error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="ingredient-toolbar">
            <form action="{{ route('admin.ingredients') }}" method="GET" class="ingredient-search">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input type="hidden" name="direction" value="{{ $direction }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Keresés név szerint...">
                <button type="submit" class="btn-edit btn-edit-primary">Keresés</button>
                @if ($search)
                    <a href="{{ route('admin.ingredients', ['sort' => $sort, 'direction' => $direction]) }}" class="btn-clear-search">Összes</a>
                @endif
            </form>

            <div class="toolbar-actions">
                <form id="bulk-delete-form" method="POST" action="{{ route('admin.ingredients.bulkDestroy') }}" class="bulk-delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete bulk-delete-btn" disabled>Törlés</button>
                </form>
                <button type="button" class="btn-edit btn-edit-primary" onclick="toggleNewIngredientForm()">Új alapanyag</button>
            </div>
        </div>

        <div id="new-ingredient-form" class="hidden-row">
            <form action="{{ route('admin.ingredients.store') }}" method="POST" class="ingredient-edit-form">
                @csrf
                <label>Név
                    <input type="text" name="name" maxlength="50" required>
                </label>
                <label>Kalória
                    <input type="number" name="calories" step="0.1" min="0" required>
                </label>
                <label>Szénhidrát
                    <input type="number" name="carbohydrate" step="0.1" min="0" required>
                </label>
                <label>Fehérje
                    <input type="number" name="protein" step="0.1" min="0" required>
                </label>
                <label>Zsír
                    <input type="number" name="fat" step="0.1" min="0" required>
                </label>
                <button type="submit" class="btn-edit btn-edit-primary">Mentés</button>
                <button type="button" class="btn-delete" onclick="toggleNewIngredientForm()">Mégse</button>
            </form>
        </div>

        @if ($ingredients->isEmpty())
            <p>{{ $search ? 'Nincs találat.' : 'Nincs még alapanyag.' }}</p>
        @else
        @php
            // Oszlopok a fejléchez - így nem kell 5x ugyanazt a rendező linket kiírni
            $columns = [
                'name' => 'Név',
                'calories' => 'Kalória',
                'carbohydrate' => 'Szénhidrát',
                'protein' => 'Fehérje',
                'fat' => 'Zsír',
            ];
        @endphp
        <table class="admin-table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select-all-checkbox"></th>
                    @foreach ($columns as $key => $label)
                        @php
                            $nextDirection = ($sort === $key && $direction === 'asc') ? 'desc' : 'asc';
                            $arrow = $sort === $key ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        @endphp
                        <th>
                            <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $key, 'direction' => $nextDirection]) }}">
                                {{ $label }}{{ $arrow }}
                            </a>
                        </th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingredients as $ingredient)
                    <tr id="ingredient-row-{{ $ingredient->id }}">
                        <td><input type="checkbox" name="ids[]" value="{{ $ingredient->id }}" class="row-checkbox" form="bulk-delete-form"></td>
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ $ingredient->calories }}</td>
                        <td>{{ $ingredient->carbohydrate }}</td>
                        <td>{{ $ingredient->protein }}</td>
                        <td>{{ $ingredient->fat }}</td>
                        <td>
                            <button type="button" class="btn-edit btn-edit-primary" onclick="toggleIngredientEdit({{ $ingredient->id }})">Módosítás</button>
                            <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt az alapanyagot? Minden receptből eltűnik!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Törlés</button>
                            </form>
                        </td>
                    </tr>
                    <tr id="ingredient-edit-{{ $ingredient->id }}" class="edit-row hidden-row">
                        <td colspan="7">
                            <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST" class="ingredient-edit-form">
                                @csrf
                                @method('PUT')
                                <label>Név
                                    <input type="text" name="name" value="{{ $ingredient->name }}" maxlength="50" required>
                                </label>
                                <label>Kalória
                                    <input type="number" name="calories" value="{{ $ingredient->calories }}" step="0.1" min="0" required>
                                </label>
                                <label>Szénhidrát
                                    <input type="number" name="carbohydrate" value="{{ $ingredient->carbohydrate }}" step="0.1" min="0" required>
                                </label>
                                <label>Fehérje
                                    <input type="number" name="protein" value="{{ $ingredient->protein }}" step="0.1" min="0" required>
                                </label>
                                <label>Zsír
                                    <input type="number" name="fat" value="{{ $ingredient->fat }}" step="0.1" min="0" required>
                                </label>
                                <button type="submit" class="btn-edit btn-edit-primary">Mentés</button>
                                <button type="button" class="btn-delete" onclick="toggleIngredientEdit({{ $ingredient->id }})">Mégse</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
        </div>
    </div>

    <script>
        // Megjelenítő és szerkesztő sor felcserélése - mindkét sor ugyanazzal a togglelal
        // vált láthatóságot, mert induláskor pont ellentétes állapotban vannak.
        function toggleIngredientEdit(id) {
            document.getElementById('ingredient-row-' + id).classList.toggle('hidden-row');
            document.getElementById('ingredient-edit-' + id).classList.toggle('hidden-row');
        }

        // Új alapanyag form megjelenítése/elrejtése a gombra kattintva
        function toggleNewIngredientForm() {
            document.getElementById('new-ingredient-form').classList.toggle('hidden-row');
        }
    </script>
@endsection
