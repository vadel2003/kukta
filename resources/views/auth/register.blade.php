@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
    <div class="column narrow">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Regisztráció</h1>
        </div>

        <div class="form_box">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form_group">
                    <label for="name">Felhasználónév</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required minlength="3" maxlength="30" class="@error('name') invalid @enderror">
                    @error('name')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form_group">
                    <label for="email">Email cím</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required minlength="6" maxlength="254" class="@error('email') invalid @enderror">
                    @error('email')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form_group">
                    <label for="password">Jelszó <span class="small_hint">(8–50 karakter)</span></label>
                    <input type="password" name="password" id="password" required minlength="8" maxlength="50" class="@error('password') invalid @enderror">
                    @error('password')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form_group">
                    <label for="password_confirmation">Jelszó megerősítése</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" maxlength="50">
                </div>

                <div class="form_group">
                    <label class="checkbox_row">
                        <input type="checkbox" name="terms" required>
                        <span>
                            Elfogadom az <a href="{{ route('page.terms') }}" target="_blank" class="external_link">Általános szerződési feltételeket<i data-lucide="external-link"></i></a>,
                            és megismertem az <a href="{{ route('page.privacy') }}" target="_blank" class="external_link">Adatkezelési tájékoztatót<i data-lucide="external-link"></i></a>.
                        </span>
                    </label>
                    @error('terms')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="big_button center orange">Regisztráció</button>
            </form>

            <p>Már van fiókod? <a href="{{ route('login') }}">Jelentkezz be!</a></p>
        </div>
    </div>
@endsection
