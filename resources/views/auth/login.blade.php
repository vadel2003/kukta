@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
    <h1>Bejelentkezés</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Email cím:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <button type="submit">Bejelentkezés</button>
        </div>
    </form>
@endsection