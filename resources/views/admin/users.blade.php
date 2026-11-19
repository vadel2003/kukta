@extends('layouts.app')

@section('title', 'Felhasználók (admin)')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="column">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Felhasználók kezelése</h1>
        </div>

        <div class="admin_box">
            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

            <div class="ingredient_top">
                <form action="{{ route('admin.users') }}" method="GET" class="ingredient_search">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <input type="hidden" name="direction" value="{{ $direction }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Keresés név vagy email szerint...">
                    <button type="submit" class="edit_button edit_orange">Keresés</button>
                    @if ($search)
                        <a href="{{ route('admin.users', ['sort' => $sort, 'direction' => $direction]) }}" class="clear_button">Összes</a>
                    @endif
                </form>
            </div>

            @if (count($users) == 0)
                @if ($search)
                    <p>Nincs találat.</p>
                @else
                    <p>Nincs még felhasználó.</p>
                @endif
            @else
                @php
                    $otherDirection = 'asc';
                    if ($direction == 'asc') {
                        $otherDirection = 'desc';
                    }
                    $idDirection = 'asc';
                    if ($sort == 'id') {
                        $idDirection = $otherDirection;
                    }
                    $nameDirection = 'asc';
                    if ($sort == 'name') {
                        $nameDirection = $otherDirection;
                    }
                    $emailDirection = 'asc';
                    if ($sort == 'email') {
                        $emailDirection = $otherDirection;
                    }
                    $adminDirection = 'asc';
                    if ($sort == 'is_admin') {
                        $adminDirection = $otherDirection;
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
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'id', 'direction' => $idDirection]) }}">
                                    ID @if ($sort == 'id') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th></th>
                            <th>
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'name', 'direction' => $nameDirection]) }}">
                                    Név @if ($sort == 'name') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'email', 'direction' => $emailDirection]) }}">
                                    Email @if ($sort == 'email') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'is_admin', 'direction' => $adminDirection]) }}">
                                    Szerepkör @if ($sort == 'is_admin') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th class="table_buttons">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @if ($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="Profilkép" class="user_avatar">
                                    @else
                                        <img src="{{ asset('images/default_avatar.svg') }}" alt="Profilkép" class="user_avatar">
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->isAdmin())
                                        Szuperadmin
                                    @else
                                        Regisztrált felhasználó
                                    @endif
                                </td>
                                <td class="table_buttons">
                                    @if (!$user->isAdmin() && $user->id != Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" data-confirm="Biztosan törlöd ezt a felhasználót? A receptjei megmaradnak.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete_button">Törlés</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
