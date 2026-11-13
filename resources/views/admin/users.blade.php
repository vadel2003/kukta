@extends('layouts.app')

@section('title', 'Felhasználók (admin)')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Felhasználók kezelése</h1>
        </div>

        <div class="admin-panel">
            @if (session('success'))
                <p class="form-success">{{ session('success') }}</p>
            @endif

            <div class="ingredient-toolbar">
                <form action="{{ route('admin.users') }}" method="GET" class="ingredient-search">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <input type="hidden" name="direction" value="{{ $direction }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Keresés név vagy email szerint...">
                    <button type="submit" class="btn-edit btn-edit-primary">Keresés</button>
                    @if ($search)
                        <a href="{{ route('admin.users', ['sort' => $sort, 'direction' => $direction]) }}" class="btn-clear-search">Összes</a>
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
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'id', 'direction' => $sort == 'id' ? $otherDirection : 'asc']) }}">
                                    ID @if ($sort == 'id') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th></th>
                            <th>
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'name', 'direction' => $sort == 'name' ? $otherDirection : 'asc']) }}">
                                    Név @if ($sort == 'name') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'email', 'direction' => $sort == 'email' ? $otherDirection : 'asc']) }}">
                                    Email @if ($sort == 'email') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.users', ['search' => $search, 'sort' => 'is_admin', 'direction' => $sort == 'is_admin' ? $otherDirection : 'asc']) }}">
                                    Szerepkör @if ($sort == 'is_admin') {{ $arrow }} @endif
                                </a>
                            </th>
                            <th class="admin-table-actions">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <img src="{{ asset($user->avatar ?? 'images/default_avatar.svg') }}" alt="Profilkép" class="user-avatar">
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
                                <td class="admin-table-actions">
                                    @if (!$user->isAdmin() && $user->id != Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" data-confirm="Biztosan törlöd a felhasználót? „{{ $user->name }}” receptjei megmaradnak, de a kedvencei és értékelései véglegesen törlődnek. Ez a művelet nem visszavonható.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Törlés</button>
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
