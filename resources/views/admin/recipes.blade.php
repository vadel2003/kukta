@extends('layouts.app')

@section('title', 'Receptek (admin)')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection

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

                <div class="toolbar-actions">
                    <a href="{{ route('recipes.create') }}" class="btn-edit btn-edit-primary">Új recept</a>
                </div>
            </div>

            @if (count($recipes) == 0)
                @if ($search)
                    <p>Nincs találat.</p>
                @else
                    <p>Nincs még feltöltött recept.</p>
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
                            <th></th>
                            <th>
                                <a href="{{ route('admin.recipes', ['search' => $search, 'sort' => 'title', 'direction' => $sort == 'title' ? $otherDirection : 'asc']) }}">
                                    Cím @if ($sort == 'title') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.recipes', ['search' => $search, 'sort' => 'user', 'direction' => $sort == 'user' ? $otherDirection : 'asc']) }}">
                                    Feltöltötte @if ($sort == 'user') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>Leírás</th>
                            <th class="admin-table-actions">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <td>
                                    <img src="{{ asset($recipe->thumbnail) }}" alt="{{ $recipe->title }}" class="recipe-thumbnail">
                                </td>
                                <td>{{ $recipe->title }}</td>
                                <td>{{ $recipe->user->name ?? 'törölt felhasználó' }}</td>
                                <td>{{ Str::limit($recipe->description, 100) }}</td>
                                <td class="admin-table-actions">
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-edit btn-edit-primary">Részletek</a>
                                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" data-confirm="Biztosan törlöd a receptet? A(z) „{{ $recipe->title }}” recept véglegesen törlődik. Ez a művelet nem visszavonható.">
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
