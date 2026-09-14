@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
    <h1>Regisztráció</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="username">Felhasználónév</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required maxlength="30">
            <small class="char-hint">max 30 karakter</small>
            <small class="char-counter">0 / 30</small>
            @error('nickname')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Email cím</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="50">
            <small class="char-hint">max 50 karakter</small>
            <small class="char-counter">0 / 50</small>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Jelszó</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Jelszó megerősítése</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="terms" required>
                Elfogadom az Adatvédelmi Szabályzatot és az Általános Szerződési Feltételeket (ÁSZF)
            </label>
            @error('terms')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Regisztráció</button>
    </form>

    <p>Már van fiókod? <a href="{{ route('login') }}">Jelentkezz be!</a></p>
@endsection
