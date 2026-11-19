@extends('layouts.app')

@section('title', 'Receptek (admin)')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="column">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Receptek kezelése</h1>
        </div>

        <div class="admin_box">
            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

            <div class="ingredient_top">
                <form action="{{ route('admin.recipes') }}" method="GET" class="ingredient_search">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <input type="hidden" name="direction" value="{{ $direction }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Keresés cím vagy feltöltő szerint...">
                    <button type="submit" class="edit_button edit_orange">Keresés</button>
                    @if ($search)
                        <a href="{{ route('admin.recipes', ['sort' => $sort, 'direction' => $direction]) }}" class="clear_button">Összes</a>
                    @endif
                </form>

                <div class="top_buttons">
                    <a href="{{ route('recipes.create') }}" class="edit_button edit_orange">Új recept</a>
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
                    $otherDirection = 'asc';
                    if ($direction == 'asc') {
                        $otherDirection = 'desc';
                    }
                    $titleDirection = 'asc';
                    if ($sort == 'title') {
                        $titleDirection = $otherDirection;
                    }
                    $arrow = '▼';
                    if ($direction == 'asc') {
                        $arrow = '▲';
                    }
                @endphp
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                <a href="{{ route('admin.recipes', ['search' => $search, 'sort' => 'title', 'direction' => $titleDirection]) }}">
                                    Cím @if ($sort == 'title') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>Feltöltötte</th>
                            <th>Leírás</th>
                            <th class="table_buttons">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <td>
                                    <img src="{{ asset($recipe->thumbnail) }}" alt="{{ $recipe->title }}" class="small_image">
                                </td>
                                <td>{{ $recipe->title }}</td>
                                <td>
                                    @if ($recipe->user)
                                        {{ $recipe->user->name }}
                                    @else
                                        törölt felhasználó
                                    @endif
                                </td>
                                <td>{{ Str::limit($recipe->description, 100) }}</td>
                                <td class="table_buttons">
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="edit_button edit_orange">Részletek</a>
                                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" data-confirm="Biztosan törlöd ezt a receptet?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete_button">Törlés</button>
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
