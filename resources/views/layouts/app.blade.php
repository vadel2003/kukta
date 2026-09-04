<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kukta - @yield('title', 'Főoldal')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <header>
        <div class="header-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/kukta-logo.svg') }}" alt="Kukta" class="logo">
                <img src="{{ asset('images/kukta-sapka.svg') }}" alt="Kukta" class="logo-mobile">
            </a>
        </div>

        <form action="{{ route('home') }}" method="GET" class="header-search">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés..." class="search-input">
            <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
            <button type="button" class="btn-filters" onclick="openModal('filtersModal')"><i data-lucide="filter"></i> Szűrők</button>
            <button type="button" class="btn-sort" onclick="openModal('sortModal')"><i data-lucide="arrow-up-down"></i> Rendezés</button>
        </form>

        <span class="hamburger">☰</span>

        <div class="header-right">
            @auth
                <div class="dropdown desktop-user">
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
                <button type="button" class="mobile-menu-btn" aria-label="Menü">
                    <i data-lucide="menu"></i>
                </button>
            @else
                <a href="{{ route('login') }}" class="login-link">
                    <img src="{{ asset('images/profile_icon.png') }}" alt="Bejelentkezés" class="profile-icon mobile-login-icon">
                    <span class="login-text">Bejelentkezés</span>
                </a>
            @endauth
        </div>

    </header>

    {{-- Mobil oldalsó menü panel --}}
    <div class="mobile-menu-overlay">
        <nav class="mobile-menu">
            @auth
                <a href="{{ route('profile.index') }}">Profil</a>
                <a href="{{ route('recipes.create') }}">Új recept</a>
                <a href="{{ route('recipes.my') }}">Saját receptek</a>
                <a href="{{ route('recipes.favorites') }}">Kedvenc receptek</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Kijelentkezés</button>
                </form>
            @else
                <a href="{{ route('login') }}">Bejelentkezés</a>
            @endauth
        </nav>
    </div>

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <button id="scrollToTop" class="scroll-to-top" title="Vissza a tetejére">
        <i data-lucide="arrow-up"></i>
    </button>

    <script>
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

        // Scroll figyelés - kereső sáv megjelenítése header-ben
        // Egyszer, betöltéskor mérjük le a search-bar pozícióját
        const searchBar = document.querySelector('.recipes-section .search-bar');
        const header = document.querySelector('header');
        if (searchBar && header) {
            const searchBarOffset = searchBar.getBoundingClientRect().top + window.scrollY;
            const headerHeight = header.offsetHeight;

            window.addEventListener('scroll', function() {
                header.classList.toggle('scrolled',
                    window.scrollY >= searchBarOffset - headerHeight);
            });
        }

        // AJAX form submit kezelés
        const searchForm = document.getElementById('searchForm');
        if (searchForm) searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const gallery = document.getElementById('recipe-gallery');
            const spinner = document.getElementById('loading-spinner');
            const loadMoreBtn = document.getElementById('load-more-btn');
            
            // "Load more" állapot reset
            currentPage = 1;
            if (loadMoreBtn) {
                loadMoreBtn.style.display = 'none';
            }
            
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
                    
                    // "Load more" gomb frissítése
                    if (data.hasMore) {
                        if (loadMoreBtn) {
                            loadMoreBtn.style.display = 'block';
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.textContent = 'További receptek betöltése...';
                        }
                    }
                    
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

        // "Load more" gomb kezelése
        let currentPage = 1;

        document.addEventListener('click', function(e) {
            if (!e.target.matches('#load-more-btn')) return;
            
            const btn = e.target;
            const gallery = document.getElementById('recipe-gallery');
            const spinner = document.getElementById('loading-spinner');
            
            currentPage++;
            btn.disabled = true;
            btn.textContent = 'Betöltés...';
            spinner.style.display = 'flex';
            
            const url = new URL(window.location.href);
            url.searchParams.set('page', currentPage);
            
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                gallery.insertAdjacentHTML('beforeend', data.html);
                if (!data.hasMore) {
                    btn.remove();
                } else {
                    btn.disabled = false;
                    btn.textContent = 'További receptek betöltése...';
                }
                spinner.style.display = 'none';
            })
            .catch(error => {
                console.error('Hiba:', error);
                spinner.style.display = 'none';
                btn.disabled = false;
                btn.textContent = 'További receptek betöltése...';
            });
        });

        // Scroll to top gomb kezelése
        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Kedvenc toggle AJAX kezelése
        document.addEventListener('submit', function(e) {
            const form = e.target.closest('.card-favorite-form, .banner-favorite-form');
            if (!form) return;

            e.preventDefault();

            const btn = form.querySelector('.btn-favorite-card, .btn-favorite-banner');
            const badge = form.querySelector('.favorite-badge');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;

                // Kártya eltávolítása a kedvenc listából törléskor
                if (form.hasAttribute('data-remove-card') && !data.isFavorited) {
                    const card = form.closest('.recipe-card');
                    if (card) {
                        card.remove();

                        // Ha nincs több kártya, üzenet megjelenítése
                        const gallery = document.querySelector('.recipe-gallery');
                        if (gallery && gallery.querySelectorAll('.recipe-card').length === 0) {
                            const empty = document.createElement('p');
                            empty.textContent = 'Még nincsenek kedvenc receptjeid.';
                            gallery.replaceWith(empty);
                        }

                        return;
                    }
                }

                btn.classList.toggle('favorited', data.isFavorited);
                if (badge) badge.textContent = data.favoriteCount;
                btn.title = data.isFavorited ? 'Kedvenc törlése' : 'Kedvencnek jelölöm';
                lucide.createIcons();
            })
            .catch(error => console.error('Hiba:', error));
        });

        // Mobil menü toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        if (mobileMenuBtn && mobileMenuOverlay) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenuOverlay.classList.toggle('open');
            });

            // Kattintás az overlay-n kívül bezárja a menüt
            document.addEventListener('click', function(e) {
                if (mobileMenuOverlay.classList.contains('open') &&
                    !mobileMenuOverlay.contains(e.target) &&
                    !mobileMenuBtn.contains(e.target)) {
                    mobileMenuOverlay.classList.remove('open');
                }
            });
        }

        // Lucide ikonok inicializálása
        lucide.createIcons();
    </script>
</body>
</html>