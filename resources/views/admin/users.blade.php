@extends('layouts.app')

@section('title', 'Felhasználók (admin)')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}?v={{ filemtime(public_path('css/admin/admin.css')) }}">
@endpush

@section('content')
    <h1>Felhasználók kezelése</h1>

    @if ($users->isEmpty())
        <p>Nincs még felhasználó.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Email</th>
                    <th>Szerepkör</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->isAdmin() ? 'Admin' : 'Felhasználó' }}</td>
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
@endsection
