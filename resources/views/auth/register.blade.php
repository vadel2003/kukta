@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Regisztráció</h1>
        </div>

        <div class="form-card">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Felhasználónév</label>
                <div class="field-control">
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="30" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" aria-describedby="name-counter">
                    <small class="char-counter" id="name-counter">0 / 30</small>
                </div>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email cím</label>
                <div class="field-control">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="50" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" aria-describedby="email-counter">
                    <small class="char-counter" id="email-counter">0 / 50</small>
                </div>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Jelszó</label>
                <input type="password" name="password" id="password" required class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
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

            <button type="submit" class="btn-cook btn-cook-centered btn-cook-primary">Regisztráció</button>
        </form>

        <p>Már van fiókod? <a href="{{ route('login') }}">Jelentkezz be!</a></p>
        </div>
    </div>
@endsection
