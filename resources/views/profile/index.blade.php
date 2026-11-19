@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="profile_page">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Profil szerkesztése</h1>
        </div>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <div class="two_columns">
            <div class="box profile_box">
                <h2 class="box_title">
                    <span class="title_icon"><i data-lucide="user"></i></span>
                    Alapadatok
                </h2>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="avatar_row">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="Profilkép" class="avatar_image">
                        @else
                            <img src="{{ asset('images/default_avatar.svg') }}" alt="Alapértelmezett profilkép" class="avatar_image">
                        @endif

                        <div class="avatar_buttons">
                            <label for="avatar">Új profilkép</label>
                            <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp">
                            <p class="hint">JPG, PNG vagy WebP kép, legfeljebb 2 MB.</p>
                            @if (Auth::user()->avatar)
                                <label class="avatar_remove">
                                    <input type="checkbox" name="remove_avatar" value="1"> Profilkép eltávolítása
                                </label>
                            @endif
                            @error('avatar')
                                <span class="error_message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form_group">
                        <label for="name">Felhasználónév</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required minlength="3" maxlength="30" class="@error('name') invalid @enderror">
                        @error('name')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="email">Email cím</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required minlength="6" maxlength="254" class="@error('email') invalid @enderror">
                        @error('email')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="box_bottom">
                        <button type="submit" class="big_button orange">Mentés</button>
                    </div>
                </form>
            </div>

            <div class="box profile_box">
                <h2 class="box_title">
                    <span class="title_icon"><i data-lucide="lock"></i></span>
                    Jelszó módosítása
                </h2>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="form_group">
                        <label for="current_password">Jelenlegi jelszó</label>
                        <input type="password" name="current_password" id="current_password" required class="@error('current_password') invalid @enderror">
                        @error('current_password')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="new_password">Új jelszó <span class="small_hint">(8–50 karakter)</span></label>
                        <input type="password" name="new_password" id="new_password" required minlength="8" maxlength="50" class="@error('new_password') invalid @enderror">
                        @error('new_password')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="new_password_confirmation">Új jelszó megerősítése</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required minlength="8" maxlength="50">
                    </div>

                    <div class="box_bottom">
                        <button type="submit" class="big_button orange">Jelszó frissítése</button>
                    </div>
                </form>
            </div>
        </div>

        @if (!Auth::user()->isAdmin())
            <div class="box profile_box red_box">
                <h2 class="box_title">
                    <span class="title_icon"><i data-lucide="trash-2"></i></span>
                    Fiók törlése
                </h2>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="delete_row">
                        <div class="delete_text">
                            <p class="hint">Ez a művelet nem visszavonható. A receptjeid megmaradnak, de a fiókod és a hozzá tartozó kedvencek, értékelések véglegesen törlődnek.</p>

                            <div class="form_group">
                                <label for="delete_password">Jelenlegi jelszó a törléshez</label>
                                <input type="password" name="password" id="delete_password" required class="@error('password') invalid @enderror">
                                @error('password')
                                    <span class="error_message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="button" class="big_button red" popovertarget="delete_popup">Fiók törlése</button>
                    </div>

                    <div id="delete_popup" class="popup small_popup" popover>
                        <div class="popup_top">
                            <h3>Biztosan törlöd a fiókodat?</h3>
                            <button type="button" class="close_button" popovertarget="delete_popup" popovertargetaction="hide">&times;</button>
                        </div>
                        <div class="popup_middle">
                            <p>Ez a művelet nem visszavonható. A receptjeid megmaradnak, de a fiókod és a hozzá tartozó kedvencek, értékelések véglegesen törlődnek.</p>
                        </div>
                        <div class="popup_bottom">
                            <button type="button" class="white_button" popovertarget="delete_popup" popovertargetaction="hide">Mégse</button>
                            <button type="submit" class="delete_button">Igen, törlöm véglegesen</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
