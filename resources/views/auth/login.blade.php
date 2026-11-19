@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
    <div class="column narrow">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Bejelentkezés</h1>
        </div>

        <div class="form_box">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form_group">
                    <label for="email">Email cím</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="254" class="@error('email') invalid @enderror">
                    @error('email')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form_group">
                    <label for="password">Jelszó</label>
                    <input type="password" id="password" name="password" required class="@error('password') invalid @enderror">
                    @error('password')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="big_button center orange">Bejelentkezés</button>
            </form>
            <p>Még nincs fiókod? <a href="{{ route('register') }}">Regisztrálj!</a></p>
        </div>
    </div>
@endsection
