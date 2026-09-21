@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
    <div class="card-stack">
        <div class="form-card">
            <h1>Bejelentkezés</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email cím:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="50">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Jelszó:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-cook">Bejelentkezés</button>
                </div>
            </form>
            <p>Még nincs fiókod? <a href="{{ route('register') }}">Regisztrálj!</a></p>
        </div>
    </div>
@endsection
