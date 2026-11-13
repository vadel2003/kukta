@extends('layouts.app')

@section('title', 'Alapanyagok (admin)')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection

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
                    <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction, 'new' => 1]) }}" class="btn-edit btn-edit-primary">Új alapanyag</a>
                </div>
            </div>

            @if (request('new'))
                <div id="new-ingredient-form">
                    <form action="{{ route('admin.ingredients.store') }}" method="POST" class="ingredient-edit-form">
                        @csrf
                        <label>Név
                            <input type="text" name="name" value="{{ old('name') }}" minlength="2" maxlength="50" required>
                        </label>
                        <label>Kalória
                            <input type="number" name="calories" value="{{ old('calories') }}" step="0.01" min="0" max="900" required>
                        </label>
                        <label>Szénhidrát
                            <input type="number" name="carbohydrate" value="{{ old('carbohydrate') }}" step="0.01" min="0" max="100" required>
                        </label>
                        <label>Fehérje
                            <input type="number" name="protein" value="{{ old('protein') }}" step="0.01" min="0" max="100" required>
                        </label>
                        <label>Zsír
                            <input type="number" name="fat" value="{{ old('fat') }}" step="0.01" min="0" max="100" required>
                        </label>
                        <button type="submit" class="btn-edit btn-edit-primary">Mentés</button>
                        <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction]) }}" class="btn-delete">Mégse</a>
                    </form>
                </div>
            @endif

            @if (count($ingredients) == 0)
                @if ($search)
                    <p>Nincs találat.</p>
                @else
                    <p>Nincs még alapanyag.</p>
                @endif
            @else
                @php
                    // clicking the sorted column again reverses the direction
                    $otherDirection = 'asc';
                    if ($direction == 'asc') {
                        $otherDirection = 'desc';
                    }
                    $arrow = '▼';
                    if ($direction == 'asc') {
                        $arrow = '▲';
                    }
                @endphp
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'name', 'direction' => $sort == 'name' ? $otherDirection : 'asc']) }}">
                                    Név @if ($sort == 'name') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'calories', 'direction' => $sort == 'calories' ? $otherDirection : 'asc']) }}">
                                    Kalória @if ($sort == 'calories') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'carbohydrate', 'direction' => $sort == 'carbohydrate' ? $otherDirection : 'asc']) }}">
                                    Szénhidrát @if ($sort == 'carbohydrate') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'protein', 'direction' => $sort == 'protein' ? $otherDirection : 'asc']) }}">
                                    Fehérje @if ($sort == 'protein') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'fat', 'direction' => $sort == 'fat' ? $otherDirection : 'asc']) }}">
                                    Zsír @if ($sort == 'fat') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th class="admin-table-actions">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingredients as $ingredient)
                            @if (request('edit') == $ingredient->id)
                                <tr id="ingredient-edit-{{ $ingredient->id }}" class="edit-row">
                                    <td colspan="6">
                                        <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST" class="ingredient-edit-form">
                                            @csrf
                                            @method('PUT')
                                            <label>Név
                                                <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" minlength="2" maxlength="50" required>
                                            </label>
                                            <label>Kalória
                                                <input type="number" name="calories" value="{{ old('calories', $ingredient->calories) }}" step="0.01" min="0" max="900" required>
                                            </label>
                                            <label>Szénhidrát
                                                <input type="number" name="carbohydrate" value="{{ old('carbohydrate', $ingredient->carbohydrate) }}" step="0.01" min="0" max="100" required>
                                            </label>
                                            <label>Fehérje
                                                <input type="number" name="protein" value="{{ old('protein', $ingredient->protein) }}" step="0.01" min="0" max="100" required>
                                            </label>
                                            <label>Zsír
                                                <input type="number" name="fat" value="{{ old('fat', $ingredient->fat) }}" step="0.01" min="0" max="100" required>
                                            </label>
                                            <button type="submit" class="btn-edit btn-edit-primary">Mentés</button>
                                            <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction]) }}" class="btn-delete">Mégse</a>
                                        </form>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $ingredient->calories }}</td>
                                    <td>{{ $ingredient->carbohydrate }}</td>
                                    <td>{{ $ingredient->protein }}</td>
                                    <td>{{ $ingredient->fat }}</td>
                                    <td class="admin-table-actions">
                                        <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction, 'edit' => $ingredient->id]) }}#ingredient-edit-{{ $ingredient->id }}" class="btn-edit btn-edit-primary">Módosítás</a>
                                        @if ($ingredient->recipes_count > 0)
                                            <button type="button" class="btn-delete" disabled title="{{ $ingredient->recipes_count }} receptben használatban van, nem törölhető">Törlés</button>
                                        @else
                                            <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" style="display: inline;" data-confirm="Biztosan törlöd az alapanyagot? A(z) „{{ $ingredient->name }}” alapanyag véglegesen törlődik. Ez a művelet nem visszavonható.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Törlés</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
