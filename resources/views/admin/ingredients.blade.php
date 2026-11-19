@extends('layouts.app')

@section('title', 'Alapanyagok (admin)')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="column">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Alapanyagok kezelése</h1>
        </div>

        <div class="admin_box">
            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <ul class="error_message">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="ingredient_top">
                <form action="{{ route('admin.ingredients') }}" method="GET" class="ingredient_search">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <input type="hidden" name="direction" value="{{ $direction }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Keresés név szerint...">
                    <button type="submit" class="edit_button edit_orange">Keresés</button>
                    @if ($search)
                        <a href="{{ route('admin.ingredients', ['sort' => $sort, 'direction' => $direction]) }}" class="clear_button">Összes</a>
                    @endif
                </form>

                <div class="top_buttons">
                    <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction, 'new' => 1]) }}" class="edit_button edit_orange">Új alapanyag</a>
                </div>
            </div>

            @if (request('new'))
                <div id="new_ingredient">
                    <form action="{{ route('admin.ingredients.store') }}" method="POST" class="ingredient_form">
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
                        <button type="submit" class="edit_button edit_orange">Mentés</button>
                        <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction]) }}" class="delete_button">Mégse</a>
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
                    $otherDirection = 'asc';
                    if ($direction == 'asc') {
                        $otherDirection = 'desc';
                    }
                    $nameDirection = 'asc';
                    if ($sort == 'name') {
                        $nameDirection = $otherDirection;
                    }
                    $caloriesDirection = 'asc';
                    if ($sort == 'calories') {
                        $caloriesDirection = $otherDirection;
                    }
                    $carbohydrateDirection = 'asc';
                    if ($sort == 'carbohydrate') {
                        $carbohydrateDirection = $otherDirection;
                    }
                    $proteinDirection = 'asc';
                    if ($sort == 'protein') {
                        $proteinDirection = $otherDirection;
                    }
                    $fatDirection = 'asc';
                    if ($sort == 'fat') {
                        $fatDirection = $otherDirection;
                    }
                    $arrow = '▼';
                    if ($direction == 'asc') {
                        $arrow = '▲';
                    }
                @endphp
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'name', 'direction' => $nameDirection]) }}">
                                    Név @if ($sort == 'name') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'calories', 'direction' => $caloriesDirection]) }}">
                                    Kalória @if ($sort == 'calories') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'carbohydrate', 'direction' => $carbohydrateDirection]) }}">
                                    Szénhidrát @if ($sort == 'carbohydrate') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'protein', 'direction' => $proteinDirection]) }}">
                                    Fehérje @if ($sort == 'protein') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => 'fat', 'direction' => $fatDirection]) }}">
                                    Zsír @if ($sort == 'fat') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th class="table_buttons">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingredients as $ingredient)
                            @if (request('edit') == $ingredient->id)
                                <tr id="ingredient_edit_{{ $ingredient->id }}" class="edit_row">
                                    <td colspan="6">
                                        <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST" class="ingredient_form">
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
                                            <button type="submit" class="edit_button edit_orange">Mentés</button>
                                            <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction]) }}" class="delete_button">Mégse</a>
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
                                    <td class="table_buttons">
                                        <a href="{{ route('admin.ingredients', ['search' => $search, 'sort' => $sort, 'direction' => $direction, 'edit' => $ingredient->id]) }}#ingredient_edit_{{ $ingredient->id }}" class="edit_button edit_orange">Módosítás</a>
                                        @if ($ingredient->recipes_count > 0)
                                            <button type="button" class="delete_button" disabled title="{{ $ingredient->recipes_count }} receptben használatban van, nem törölhető">Törlés</button>
                                        @else
                                            <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" style="display: inline;" data-confirm="Biztosan törlöd ezt az alapanyagot?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete_button">Törlés</button>
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
