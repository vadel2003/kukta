@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="profile-page">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Profil szerkesztése</h1>
        </div>

        @if (session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        <div class="grid-2col">
            <div class="content-card profile-panel">
                <h2 class="content-title">
                    <span class="title-icon"><i data-lucide="user"></i></span>
                    Alapadatok
                </h2>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="avatar-row">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="Profilkép" class="profile-avatar-preview">
                        @else
                            <img src="{{ asset('images/default_avatar.svg') }}" alt="Alapértelmezett profilkép" class="profile-avatar-preview">
                        @endif

                        <div class="avatar-row-actions">
                            <label for="avatar">Új profilkép</label>
                            <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp">
                            <p class="field-hint">JPG, PNG vagy WebP kép, legfeljebb 2 MB.</p>
                            @if (Auth::user()->avatar)
                                <label class="avatar-remove">
                                    <input type="checkbox" name="remove_avatar" value="1"> Profilkép eltávolítása
                                </label>
                            @endif
                            @error('avatar')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Felhasználónév</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required minlength="3" maxlength="30" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email cím</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required minlength="6" maxlength="254" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="panel-footer">
                        <button type="submit" class="btn-cook btn-cook-primary">Mentés</button>
                    </div>
                </form>
            </div>

            <div class="content-card profile-panel">
                <h2 class="content-title">
                    <span class="title-icon"><i data-lucide="lock"></i></span>
                    Jelszó módosítása
                </h2>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password">Jelenlegi jelszó</label>
                        <input type="password" name="current_password" id="current_password" required class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}">
                        @error('current_password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">Új jelszó <span class="label-hint">(8–50 karakter)</span></label>
                        <input type="password" name="new_password" id="new_password" required minlength="8" maxlength="50" class="{{ $errors->has('new_password') ? 'is-invalid' : '' }}">
                        @error('new_password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Új jelszó megerősítése</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required minlength="8" maxlength="50">
                    </div>

                    <div class="panel-footer">
                        <button type="submit" class="btn-cook btn-cook-primary">Jelszó frissítése</button>
                    </div>
                </form>
            </div>
        </div>

        @if (!Auth::user()->isAdmin())
            <div class="content-card profile-panel profile-panel--danger">
                <h2 class="content-title">
                    <span class="title-icon"><i data-lucide="trash-2"></i></span>
                    Fiók törlése
                </h2>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="danger-row">
                        <div class="danger-row-text">
                            <p class="field-hint">Ez a művelet nem visszavonható. A receptjeid megmaradnak, de a fiókod és a hozzá tartozó kedvencek, értékelések véglegesen törlődnek.</p>

                            <div class="form-group">
                                <label for="delete_password">Jelenlegi jelszó a törléshez</label>
                                <input type="password" name="password" id="delete_password" required class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                                @error('password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="button" class="btn-cook btn-cook-danger" popovertarget="deleteAccountModal">Fiók törlése</button>
                    </div>

                    <div id="deleteAccountModal" class="modal-content modal-small" popover>
                        <div class="modal-header">
                            <h3>Biztosan törlöd a fiókodat?</h3>
                            <button type="button" class="close-btn" popovertarget="deleteAccountModal" popovertargetaction="hide">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Ez a művelet nem visszavonható. A receptjeid megmaradnak, de a fiókod és a hozzá tartozó kedvencek, értékelések véglegesen törlődnek.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-outline" popovertarget="deleteAccountModal" popovertargetaction="hide">Mégse</button>
                            <button type="submit" class="btn-delete">Igen, törlöm véglegesen</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
