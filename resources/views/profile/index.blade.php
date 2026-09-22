@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="card-stack">
        <div class="form-card form-card--wide">
            <h1>Profil szerkesztése</h1>
        </div>

        <div class="form-card form-card--wide">
        @if (session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="avatar">Profilkép</label>
                <label class="avatar-upload">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Profilkép" class="profile-avatar-preview" id="avatar-preview">
                    @else
                        <img src="{{ asset('images/default_avatar.svg') }}" alt="Alapértelmezett profilkép" class="profile-avatar-preview" id="avatar-preview">
                    @endif
                    <span class="avatar-upload-hint"><i data-lucide="camera"></i></span>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="upload-input">
                </label>
                @error('avatar')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Felhasználónév</label>
                <input type="text" name="username" id="username" value="{{ old('username', Auth::user()->username) }}" required maxlength="30">
                <small class="char-counter">0 / 30</small>
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email cím</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required maxlength="50">
                <small class="char-counter">0 / 50</small>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="current_password">Jelenlegi jelszó</label>
                <input type="password" name="current_password" id="current_password" required>
                @error('current_password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">Új jelszó (nem kötelező)</label>
                <input type="password" name="new_password" id="new_password" maxlength="50">
                <small class="char-counter">0 / 50</small>
                @error('new_password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Új jelszó megerősítése</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" maxlength="50">
                <small class="char-counter">0 / 50</small>
            </div>

            <button type="submit" class="btn-cook">Mentés</button>
        </form>
        </div>

        <div class="danger-zone">
            <h2 style="margin-bottom: 1rem; color: var(--color-danger);">Fiók törlése</h2>
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Biztosan törölni szeretnéd a fiókodat? Ez a művelet nem visszavonható!')">
                @csrf
                @method('delete')

                <div class="form-group">
                    <label for="delete_password">Jelenlegi jelszó a törléshez</label>
                    <input type="password" name="password" id="delete_password" required>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-delete">Fiók törlése</button>
            </form>
        </div>
    </div>

    <script>
        // Profilkép élő előnézete kiválasztás után (ua. minta, mint a recept-form
        // saját kép feltöltőjénél: recipes/create.blade.php)
        const avatarInput = document.querySelector('.avatar-upload .upload-input');
        const avatarPreview = document.getElementById('avatar-preview');
        if (avatarInput) {
            avatarInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    avatarPreview.src = URL.createObjectURL(this.files[0]);
                }
            });
        }
    </script>
@endsection
