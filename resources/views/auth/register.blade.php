@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
    <div class="card-stack">
        <div class="form-card">
            <h1>Regisztráció</h1>
        </div>

        <div class="form-card">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="username">Felhasználónév</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required maxlength="30">
                <small class="char-counter">0 / 30</small>
                @error('nickname')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email cím</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="50">
                <small class="char-counter">0 / 50</small>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Jelszó</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Jelszó megerősítése</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="terms" required>
                    Elfogadom az Adatvédelmi Szabályzatot és az Általános Szerződési Feltételeket (ÁSZF)
                </label>
                @error('terms')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-cook">Regisztráció</button>
        </form>

        <p>Már van fiókod? <a href="{{ route('login') }}">Jelentkezz be!</a></p>
        </div>
    </div>
@endsection
