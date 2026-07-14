<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kukta - @yield('title', 'Főoldal')</title>
</head>
<body>
    <nav>
        @auth
        <span>Üdv, {{ Auth::user()->username }}!</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Kijelentkezés</button>
            </form>
        @else
        <a href="{{ route('login') }}">Bejelentkezés</a>
        @endauth
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>