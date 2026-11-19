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
        <div class="header_left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/kukta-hat.svg') }}" alt="" class="logo">
                <span class="logo_text">Kukta</span>
            </a>
        </div>

        <div class="header_right">
            @auth
                <div class="dropdown desktop_user">
                    <button type="button" class="profile_button" popovertarget="menu_popup">
                        <img src="{{ asset('images/profile_icon.svg') }}" alt="Profil" class="profile_icon">
                        <i data-lucide="chevron-down" class="arrow"></i>
                    </button>
                    <div class="dropdown_menu">
                        <div class="dropdown_box">
                            <a href="{{ route('profile.index') }}"><i data-lucide="user"></i> Profil</a>
                            <a href="{{ route('recipes.create') }}"><i data-lucide="plus"></i> Új recept</a>
                            <a href="{{ route('recipes.my') }}"><i data-lucide="book-open"></i> Saját receptek</a>
                            <a href="{{ route('recipes.favorites') }}"><i data-lucide="heart"></i> Kedvenc receptek</a>
                            @if (Auth::user()->isAdmin())
                                <hr class="dropdown_line">
                                <span class="dropdown_title">Szuperadmin</span>
                                <a href="{{ route('admin.ingredients') }}"><i data-lucide="carrot"></i> Alapanyagok</a>
                                <a href="{{ route('admin.recipes') }}"><i data-lucide="utensils"></i> Receptek</a>
                                <a href="{{ route('admin.users') }}"><i data-lucide="users"></i> Felhasználók</a>
                            @endif
                            <hr class="dropdown_line">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"><i data-lucide="log-out"></i> Kijelentkezés</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="dropdown desktop_user">
                    <button type="button" class="profile_button" popovertarget="menu_popup" title="Bejelentkezés">
                        <img src="{{ asset('images/profile_icon.svg') }}" alt="Bejelentkezés" class="profile_icon">
                        <i data-lucide="chevron-down" class="arrow"></i>
                    </button>
                    <div class="dropdown_menu">
                        <div class="dropdown_box">
                            <a href="{{ route('login') }}"><i data-lucide="log-in"></i> Bejelentkezés</a>
                            <a href="{{ route('register') }}"><i data-lucide="user-plus"></i> Regisztráció</a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <div id="menu_popup" class="mobile_popup" popover>
        <div class="mobile_menu_top">
            <span class="mobile_menu_title">Menü</span>
            <button type="button" class="mobile_close" popovertarget="menu_popup" popovertargetaction="hide" title="Menü bezárása">
                <i data-lucide="x"></i>
            </button>
        </div>
        <nav class="mobile_menu">
            @auth
                <a href="{{ route('profile.index') }}"><i data-lucide="user"></i> Profil</a>
                <a href="{{ route('recipes.create') }}"><i data-lucide="plus"></i> Új recept</a>
                <a href="{{ route('recipes.my') }}"><i data-lucide="book-open"></i> Saját receptek</a>
                <a href="{{ route('recipes.favorites') }}"><i data-lucide="heart"></i> Kedvenc receptek</a>
                @if (Auth::user()->isAdmin())
                    <hr class="mobile_line">
                    <span class="mobile_small_title">Szuperadmin</span>
                    <a href="{{ route('admin.ingredients') }}"><i data-lucide="carrot"></i> Alapanyagok</a>
                    <a href="{{ route('admin.recipes') }}"><i data-lucide="utensils"></i> Receptek</a>
                    <a href="{{ route('admin.users') }}"><i data-lucide="users"></i> Felhasználók</a>
                @endif
                <hr class="mobile_line">
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

    @yield('hero')

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer_inside">
            <div class="footer_column">
                <h4>Elérhetőség</h4>
                <p><a href="mailto:info@kukta.hu"><i data-lucide="mail" class="footer_icon"></i> info@kukta.hu</a></p>
            </div>
        </div>
        <div class="footer_bottom">
            <p>&copy; {{ date('Y') }} Kukta</p>
        </div>
    </footer>

    <a href="#top" class="up_button" title="Vissza a tetejére">
        <i data-lucide="arrow-up"></i>
    </a>

    <script>
        const confirmForms = document.querySelectorAll('form[data-confirm]');
        for (let i = 0; i < confirmForms.length; i++) {
            confirmForms[i].addEventListener('submit', function (event) {
                if (!confirm(this.getAttribute('data-confirm'))) {
                    event.preventDefault();
                }
            });
        }

        lucide.createIcons();
    </script>
</body>
</html>
