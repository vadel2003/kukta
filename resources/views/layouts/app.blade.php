<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kukta - @yield('title', 'Főoldal')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/kukta-logo.svg') }}" alt="Kukta" style="height: 40px; vertical-align: middle;">
        </a>

        @auth
            <ul>
                <li><a href="{{ route('profile.index') }}"><img src="{{ asset('images/profile_icon.png') }}" alt="Kukta" style="height: 40px; vertical-align: middle;"></a></li>
                <li><a href="{{ route('recipes.create') }}">Új recept</a></li>
                <li><a href="{{ route('recipes.my') }}">Saját receptek</a></li>
                <li><a href="{{ route('recipes.favorites') }}">Kedvenc receptek</a></li>
            </ul>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Kijelentkezés</button>
            </form>
        @else
            <a href="{{ route('login') }}">Bejelentkezés</a>
            <a href="{{ route('register') }}">Regisztráció</a>
        @endauth
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>