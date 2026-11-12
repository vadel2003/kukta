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
                    <a href="{{ request()->fullUrlWithQuery(['new' => 1]) }}" class="btn-edit btn-edit-primary">Új alapanyag</a>
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
                        <a href="{{ request()->fullUrlWithoutQuery('new') }}" class="btn-delete">Mégse</a>
                    </form>
                </div>
            @endif

            @if ($ingredients->isEmpty())
                <p>{{ $search ? 'Nincs találat.' : 'Nincs még alapanyag.' }}</p>
            @else
                @php
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
                                            <a href="{{ request()->fullUrlWithoutQuery('edit') }}" class="btn-delete">Mégse</a>
                                        </form>
                                    </td>
                                </tr>
                            @else
                                <tr id="ingredient-row-{{ $ingredient->id }}">
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $ingredient->calories }}</td>
                                    <td>{{ $ingredient->carbohydrate }}</td>
                                    <td>{{ $ingredient->protein }}</td>
                                    <td>{{ $ingredient->fat }}</td>
                                    <td class="admin-table-actions">
                                        <a href="{{ request()->fullUrlWithQuery(['edit' => $ingredient->id]) }}#ingredient-edit-{{ $ingredient->id }}" class="btn-edit btn-edit-primary">Módosítás</a>
                                        @if ($ingredient->recipes_count > 0)
                                            <button type="button" class="btn-delete" disabled title="{{ $ingredient->recipes_count }} receptben használatban van, nem törölhető">Törlés</button>
                                        @else
                                            <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" style="display: inline;" data-confirm-title="Biztosan törlöd az alapanyagot?" data-confirm="A(z) „{{ $ingredient->name }}” alapanyag véglegesen törlődik. Ez a művelet nem visszavonható.">
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
