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
        // Hamburger menü
        document.querySelector('.hamburger').addEventListener('click', function() {
            document.querySelector('.header-right').classList.toggle('open');
        });

        // Modal kezelő függvények
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Modal bezárása ha a háttérre (overlay-re) kattintunk
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }

        // AJAX form submit kezelés
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const gallery = document.getElementById('recipe-gallery');
            const spinner = document.getElementById('loading-spinner');
            
            // Loading spinner megjelenítése
            spinner.style.display = 'flex';
            gallery.style.opacity = '0.5';
            
            // AJAX kérés - tömbös paraméterek megfelelő kezelése
            const formData = new FormData(form);
            const params = new URLSearchParams();
            for (const [key, value] of formData.entries()) {
                params.append(key, value);
            }
            fetch(form.action + '?' + params.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    gallery.innerHTML = data.html;
                    
                    // Várakozás a képek betöltődésére
                    const images = gallery.querySelectorAll('img');
                    let loadedCount = 0;
                    
                    if (images.length === 0) {
                        spinner.style.display = 'none';
                        gallery.style.opacity = '1';
                        return;
                    }
                    
                    images.forEach(img => {
                        if (img.complete) {
                            loadedCount++;
                        } else {
                            img.addEventListener('load', () => {
                                loadedCount++;
                                if (loadedCount === images.length) {
                                    spinner.style.display = 'none';
                                    gallery.style.opacity = '1';
                                }
                            });
                        }
                    });
                    
                    if (loadedCount === images.length) {
                        spinner.style.display = 'none';
                        gallery.style.opacity = '1';
                    }
                })
                .catch(error => {
                    console.error('Hiba:', error);
                    spinner.style.display = 'none';
                    gallery.style.opacity = '1';
                });
        });
    </script>
</body>
</html>