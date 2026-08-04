<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kukta - @yield('title', 'Főoldal')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/kukta-logo.svg') }}" alt="Kukta" class="logo">
            </a>
        </div>

        <span class="hamburger">☰</span>

        <div class="header-right">
            @auth
                <div class="dropdown">
                    <div class="dropdown-trigger">
                        <img src="{{ asset('images/profile_icon.png') }}" alt="Profil" class="profile-icon">
                        <span class="dropdown-arrow">▾</span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.index') }}">Profil</a>
                        <a href="{{ route('recipes.create') }}">Új recept</a>
                        <a href="{{ route('recipes.my') }}">Saját receptek</a>
                        <a href="{{ route('recipes.favorites') }}">Kedvenc receptek</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Kijelentkezés</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}">Bejelentkezés</a>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script>
        document.querySelector('.hamburger').addEventListener('click', function() {
            document.querySelector('.header-right').classList.toggle('open');
        });
    </script>
</body>
</html>