@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
    {{-- card-stack--narrow: a cím és a vissza link egy oszlopban a kártyával (mint a Profil oldalon) --}}
    <div class="card-stack card-stack--narrow">
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
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required minlength="3" maxlength="30" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" aria-describedby="name-counter">
                        <small class="char-counter" id="name-counter">0 / 30</small>
                    </div>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email cím</label>
                    <div class="field-control">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required minlength="6" maxlength="254" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" aria-describedby="email-counter">
                        <small class="char-counter" id="email-counter">0 / 50</small>
                    </div>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Jelszó</label>
                    <input type="password" name="password" id="password" required minlength="8" maxlength="50" aria-describedby="password-hint" class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    <p class="field-hint" id="password-hint">8–50 karakter.</p>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Jelszó megerősítése</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" maxlength="50">
                </div>

                <div class="form-group">
                    {{-- A szabályzatok új lapon nyílnak (target="_blank"), hogy a félig kitöltött űrlap ne vesszen el.
                         Ezt jelezzük is: kis "kifelé mutató" ikon (látó felhasználóknak) + rejtett szöveg (képernyőolvasónak). --}}
                    <label class="checkbox-inline">
                        <input type="checkbox" name="terms" required>
                        <span>
                            {{-- Az ÁSZF-et elfogadni kell (ez a szerződés), az adatkezelési tájékoztatót
                                 viszont csak megismerni - az adatkezelés jogalapja nem ez a pipa, hanem a szerződés --}}
                            Elfogadom az <a href="{{ route('page.terms') }}" target="_blank" class="external-link">Általános szerződési feltételeket<i data-lucide="external-link" aria-hidden="true"></i><span class="sr-only"> (új lapon nyílik)</span></a>,
                            és megismertem az <a href="{{ route('page.privacy') }}" target="_blank" class="external-link">Adatkezelési tájékoztatót<i data-lucide="external-link" aria-hidden="true"></i><span class="sr-only"> (új lapon nyílik)</span></a>.
                        </span>
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
