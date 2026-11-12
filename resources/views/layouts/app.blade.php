<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kukta - @yield('title', 'Főoldal')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
    <script src="{{ asset('js/lucide.min.js') }}"></script>
</head>
<body class="@yield('bodyClass')">
    <header>
        <div class="header-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/kukta-hat.svg') }}" alt="" class="logo">
                <span class="logo-text">Kukta</span>
            </a>
        </div>

        <div class="header-right">
            @auth
                <div class="dropdown desktop-user">
                    <button type="button" class="dropdown-trigger" popovertarget="mobileMenu">
                        <img src="{{ asset('images/profile_icon.svg') }}" alt="Profil" class="profile-icon">
                        <i data-lucide="chevron-down" class="dropdown-arrow"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-panel">
                            <a href="{{ route('profile.index') }}"><i data-lucide="user"></i> Profil</a>
                            <a href="{{ route('recipes.create') }}"><i data-lucide="plus"></i> Új recept</a>
                            <a href="{{ route('recipes.my') }}"><i data-lucide="book-open"></i> Saját receptek</a>
                            <a href="{{ route('recipes.favorites') }}"><i data-lucide="heart"></i> Kedvenc receptek</a>
                            @if (Auth::user()->isAdmin())
                                <hr class="dropdown-divider">
                                <span class="dropdown-label">Szuperadmin</span>
                                <a href="{{ route('admin.ingredients') }}"><i data-lucide="carrot"></i> Alapanyagok</a>
                                <a href="{{ route('admin.recipes') }}"><i data-lucide="utensils"></i> Receptek</a>
                                <a href="{{ route('admin.users') }}"><i data-lucide="users"></i> Felhasználók</a>
                            @endif
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"><i data-lucide="log-out"></i> Kijelentkezés</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="dropdown desktop-user">
                    <button type="button" class="dropdown-trigger" popovertarget="mobileMenu" title="Bejelentkezés">
                        <img src="{{ asset('images/profile_icon.svg') }}" alt="Bejelentkezés" class="profile-icon">
                        <i data-lucide="chevron-down" class="dropdown-arrow"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-panel">
                            <a href="{{ route('login') }}"><i data-lucide="log-in"></i> Bejelentkezés</a>
                            <a href="{{ route('register') }}"><i data-lucide="user-plus"></i> Regisztráció</a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    {{-- Mobile menu: the profile icon opens it (popover attribute, no JavaScript needed). --}}
    <div id="mobileMenu" class="mobile-menu-overlay" popover>
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">Menü</span>
            <button type="button" class="mobile-menu-close" popovertarget="mobileMenu" popovertargetaction="hide" aria-label="Menü bezárása">
                <i data-lucide="x"></i>
            </button>
        </div>
        <nav class="mobile-menu">
            @auth
                <a href="{{ route('profile.index') }}"><i data-lucide="user"></i> Profil</a>
                <a href="{{ route('recipes.create') }}"><i data-lucide="plus"></i> Új recept</a>
                <a href="{{ route('recipes.my') }}"><i data-lucide="book-open"></i> Saját receptek</a>
                <a href="{{ route('recipes.favorites') }}"><i data-lucide="heart"></i> Kedvenc receptek</a>
                @if (Auth::user()->isAdmin())
                    <hr class="mobile-menu-divider">
                    <span class="mobile-menu-label">Szuperadmin</span>
                    <a href="{{ route('admin.ingredients') }}"><i data-lucide="carrot"></i> Alapanyagok</a>
                    <a href="{{ route('admin.recipes') }}"><i data-lucide="utensils"></i> Receptek</a>
                    <a href="{{ route('admin.users') }}"><i data-lucide="users"></i> Felhasználók</a>
                @endif
                <hr class="mobile-menu-divider">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i data-lucide="log-out"></i> Kijelentkezés</button>
                </form>
            @else
                <a href="{{ route('login') }}"><i data-lucide="log-in"></i> Bejelentkezés</a>
                <a href="{{ route('register') }}"><i data-lucide="user-plus"></i> Regisztráció</a>
            @endauth
        </nav>
    </div>

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.cookie-notice')

    <a href="#top" class="scroll-to-top" title="Vissza a tetejére">
        <i data-lucide="arrow-up"></i>
    </a>

    <script>
        document.addEventListener('submit', event => {
            const form = event.target;
            if (form.dataset.confirm && !confirm((form.dataset.confirmTitle || 'Biztosan folytatod?') + '\n\n' + form.dataset.confirm)) {
                event.preventDefault();
            }
        });

        lucide.createIcons();
    </script>
</body>
</html>
