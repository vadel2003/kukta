@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <h1>Profil szerkesztése</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div>
            <label for="avatar">Profilkép</label>
            @if (Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Profilkép" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ccc; box-shadow: inset 0 0 15px rgba(0,0,0,0.35);">
            @else
                <img src="{{ asset('images/default_avatar.svg') }}" alt="Alapértelmezett profilkép" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ccc; box-shadow: inset 0 0 15px rgba(0,0,0,0.35);">
            @endif
            <input type="file" name="avatar" id="avatar" accept="image/*">
            @error('avatar')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="username">Felhasználónév</label>
            <input type="text" name="username" id="username" value="{{ old('username', Auth::user()->username) }}" required>
            @error('username')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Email cím</label>
            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="current_password">Jelenlegi jelszó</label>
            <input type="password" name="current_password" id="current_password" required>
            @error('current_password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="new_password">Új jelszó (nem kötelező)</label>
            <input type="password" name="new_password" id="new_password">
            @error('new_password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="new_password_confirmation">Új jelszó megerősítése</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation">
        </div>

        <button type="submit">Mentés</button>
    </form>

    <hr>

    <h2>Fiók törlése</h2>
    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Biztosan törölni szeretnéd a fiókodat? Ez a művelet nem visszavonható!')">
        @csrf
        @method('delete')

        <div>
            <label for="delete_password">Jelenlegi jelszó a törléshez</label>
            <input type="password" name="password" id="delete_password" required>
            @error('password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Fiók törlése</button>
    </form>
@endsection
