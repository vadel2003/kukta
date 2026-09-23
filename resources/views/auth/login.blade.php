@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Bejelentkezés</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email cím:</label>
                    <div class="field-control">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="50" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" aria-describedby="email-counter">
                        <small class="char-counter" id="email-counter">0 / 50</small>
                    </div>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Jelszó:</label>
                    <input type="password" id="password" name="password" required class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-cook btn-cook-centered btn-cook-primary">Bejelentkezés</button>
            </form>
            <p>Még nincs fiókod? <a href="{{ route('register') }}">Regisztrálj!</a></p>
        </div>
    </div>
@endsection
