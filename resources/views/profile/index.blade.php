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
        {{-- 1. Alapadatok: profilkép, felhasználónév, email - saját submit --}}
        <div class="content-card profile-panel">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="user"></i></span>
                Alapadatok
            </h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">

                <div class="avatar-row">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Profilkép" class="profile-avatar-preview" id="avatar-preview">
                    @else
                        <img src="{{ asset('images/default_avatar.svg') }}" alt="Alapértelmezett profilkép" class="profile-avatar-preview" id="avatar-preview">
                    @endif

                    <div class="avatar-row-actions">
                        <label for="avatar" class="btn-outline">Kép cseréje</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="upload-input" aria-describedby="avatar-hint">
                        <p class="field-hint" id="avatar-hint">JPG, PNG, GIF vagy WEBP, legfeljebb 2 MB.</p>
                        @if (Auth::user()->avatar)
                            <button type="button" class="btn-link-danger" id="avatar-remove">Eltávolítás</button>
                        @endif
                        @error('avatar')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Felhasználónév</label>
                    <div class="field-control">
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required maxlength="30" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" aria-describedby="name-counter">
                        <small class="char-counter" id="name-counter">0 / 30</small>
                    </div>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email cím</label>
                    <div class="field-control">
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required maxlength="50" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" aria-describedby="email-counter">
                        <small class="char-counter" id="email-counter">0 / 50</small>
                    </div>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-cook btn-cook-primary">Mentés</button>
                </div>
            </form>
        </div>

        {{-- 2. Jelszó módosítása - saját submit, elkülönítve az alapadatoktól --}}
        <div class="content-card profile-panel">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="lock"></i></span>
                Jelszó módosítása
            </h2>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="current_password">Jelenlegi jelszó</label>
                    <input type="password" name="current_password" id="current_password" required class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}">
                    @error('current_password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">Új jelszó</label>
                    <div class="field-control">
                        <input type="password" name="new_password" id="new_password" required maxlength="50" class="{{ $errors->has('new_password') ? 'is-invalid' : '' }}" aria-describedby="new_password-counter">
                        <small class="char-counter" id="new_password-counter">0 / 50</small>
                    </div>
                    @error('new_password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Új jelszó megerősítése</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required maxlength="50">
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-cook btn-cook-primary">Jelszó frissítése</button>
                </div>
            </form>
        </div>
        </div>

        {{-- 3. Fiók törlése - semleges panel piros címmel/bal éllel, modal megerősítéssel --}}
        <div class="content-card profile-panel profile-panel--danger">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="trash-2"></i></span>
                Fiók törlése
            </h2>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

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

                    <button type="button" class="btn-cook btn-cook-danger" onclick="openModal('deleteAccountModal')">Fiók törlése</button>
                </div>

                <div id="deleteAccountModal" class="modal">
                    <div class="modal-content modal-small">
                        <div class="modal-header">
                            <h3>Biztosan törlöd a fiókodat?</h3>
                            <button type="button" class="close-btn" onclick="closeModal('deleteAccountModal')">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Ez a művelet nem visszavonható. A receptjeid megmaradnak, de a fiókod és a hozzá tartozó kedvencek, értékelések véglegesen törlődnek.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-outline" onclick="closeModal('deleteAccountModal')">Mégse</button>
                            <button type="submit" class="btn-delete">Igen, törlöm véglegesen</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Profilkép élő előnézete kiválasztás után (ua. minta, mint a recept-form
        // saját kép feltöltőjénél: recipes/create.blade.php)
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');
        const removeAvatarField = document.getElementById('remove_avatar');
        if (avatarInput) {
            avatarInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    avatarPreview.src = URL.createObjectURL(this.files[0]);
                    removeAvatarField.value = '0';
                }
            });
        }

        // "Eltávolítás" link - visszaállítja az alapértelmezett képet, és jelzi
        // a szervernek, hogy a mentéskor törölje a jelenlegi avatart
        const avatarRemoveBtn = document.getElementById('avatar-remove');
        if (avatarRemoveBtn) {
            avatarRemoveBtn.addEventListener('click', function () {
                avatarInput.value = '';
                avatarPreview.src = "{{ asset('images/default_avatar.svg') }}";
                removeAvatarField.value = '1';
                avatarRemoveBtn.remove();
            });
        }
    </script>
@endsection
