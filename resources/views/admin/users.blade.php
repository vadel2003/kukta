@extends('layouts.app')

@section('title', 'Felhasználók (admin)')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}?v={{ filemtime(public_path('css/admin/admin.css')) }}">
@endpush

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

            <form id="bulk-delete-form" method="POST" action="{{ route('admin.users.bulkDestroy') }}" class="bulk-delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete bulk-delete-btn" disabled>Törlés</button>
            </form>
        </div>

        @if ($users->isEmpty())
            <p>{{ $search ? 'Nincs találat.' : 'Nincs még felhasználó.' }}</p>
        @else
        @php
            // Oszlopok a fejléchez - így nem kell 4x ugyanazt a rendező linket kiírni
            $columns = [
                'id' => 'ID',
                'name' => 'Név',
                'email' => 'Email',
                'role' => 'Szerepkör',
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
                            <a href="{{ route('admin.users', ['search' => $search, 'sort' => $key, 'direction' => $nextDirection]) }}">
                                {{ $label }}{{ $arrow }}
                            </a>
                        </th>
                        @if ($key === 'id')
                            <th></th> {{-- profilkép oszlop, nem rendezhető --}}
                        @endif
                    @endforeach
                    <th></th> {{-- műveletek oszlop --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            @if (!$user->isAdmin() && $user->id !== Auth::id())
                                <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="row-checkbox" form="bulk-delete-form">
                            @endif
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>
                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" class="user-avatar">
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->isAdmin() ? 'Superadmin' : 'Regisztrált felhasználó' }}</td>
                        <td>
                            @if (!$user->isAdmin() && $user->id !== Auth::id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt a felhasználót? A receptjei megmaradnak, de a kedvencei és értékelései törlődnek.')">
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
