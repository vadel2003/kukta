<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kukta - @yield('title', 'Főoldal')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}?v={{ filemtime(public_path('images/favicon.svg')) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    @stack('styles')
    <script src="{{ asset('js/lucide.min.js') }}?v={{ filemtime(public_path('js/lucide.min.js')) }}"></script>
</head>
<body class="@yield('bodyClass')">
    <header>
        <div class="header-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/kukta-hat.svg') }}?v={{ filemtime(public_path('images/kukta-hat.svg')) }}" alt="" class="logo">
                <span class="logo-text">Kukta</span>
            </a>
        </div>

        <form action="{{ route('home') }}#recipes" method="GET" class="header-search">
            <div class="search-row">
                <div class="search-input-group">
                    <i data-lucide="search" class="search-input-icon"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Receptek keresése kulcsszó szerint..." class="search-input">
                </div>
                <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
                <button type="button" class="btn-filters" data-modal-open="filtersModal"><i data-lucide="filter"></i> Szűrők <span class="filter-count" hidden></span></button>
                <span class="search-divider"></span>
                <button type="button" class="btn-sort" data-modal-open="sortModal"><i data-lucide="arrow-up-down"></i> Rendezés</button>
            </div>
        </form>

        <div class="header-right">
            @auth
                <div class="dropdown desktop-user">
                    <div class="dropdown-trigger">
                        <img src="{{ asset('images/profile_icon.svg') }}?v={{ filemtime(public_path('images/profile_icon.svg')) }}" alt="Profil" class="profile-icon">
                        <i data-lucide="chevron-down" class="dropdown-arrow"></i>
                    </div>
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
                <button type="button" class="mobile-menu-btn" aria-label="Menü">
                    <i data-lucide="menu"></i>
                </button>
            @else
                <div class="dropdown desktop-user">
                    <div class="dropdown-trigger" title="Bejelentkezés">
                        <img src="{{ asset('images/profile_icon.svg') }}?v={{ filemtime(public_path('images/profile_icon.svg')) }}" alt="Bejelentkezés" class="profile-icon">
                        <i data-lucide="chevron-down" class="dropdown-arrow"></i>
                    </div>
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

    <div class="mobile-menu-overlay">
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">Menü</span>
            <button type="button" class="mobile-menu-close" aria-label="Menü bezárása">
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

    <button id="scrollToTop" class="scroll-to-top" title="Vissza a tetejére">
        <i data-lucide="arrow-up"></i>
    </button>

    {{-- Shared confirmation dialog. Usage: <form ... data-confirm="Message" data-confirm-title="Title (optional)"> --}}
    <div id="confirmModal" class="modal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h3 class="confirm-modal-title"></h3>
                <button type="button" class="close-btn" data-modal-close>&times;</button>
            </div>
            <div class="modal-body">
                <p class="confirm-modal-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline" data-modal-close>Mégse</button>
                <button type="button" id="confirmModalSubmit" class="btn-delete">Igen, törlöm</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        let formToConfirm = null;

        /**
         * Opens a modal by its ID.
         */
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add('active');
        }

        /**
         * Closes a modal by its ID.
         */
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.remove('active');
        }

        /**
         * AJAX request to the app that returns the parsed JSON response.
         * Rejects if the response status is not OK (e.g. expired session or validation error).
         */
        function fetchJson(url, options = {}) {
            options.headers = {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            };
            return fetch(url, options).then(response => {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.json();
            });
        }

        /**
         * Updates the counter on the Filters buttons and the active filter chips from the checked filters.
         */
        function updateFilterSummary() {
            const form = document.getElementById('searchForm');
            const box = document.getElementById('activeFilters');
            if (!form || !box) return;

            const checked = form.querySelectorAll('#filtersModal input[type="checkbox"]:checked');

            document.querySelectorAll('.btn-filters').forEach(button => {
                const badge = button.querySelector('.filter-count');
                if (badge) {
                    badge.textContent = checked.length;
                    badge.hidden = checked.length === 0;
                }
                button.classList.toggle('has-filters', checked.length > 0);
            });

            box.innerHTML = '';
            checked.forEach(input => {
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'active-filter';
                chip.title = 'Szűrő eltávolítása';
                chip.textContent = input.dataset.label + ' ✕';
                chip.addEventListener('click', () => {
                    input.checked = false;
                    form.requestSubmit();
                });
                box.appendChild(chip);
            });

            if (checked.length > 1) {
                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.className = 'active-filters-clear';
                clearButton.textContent = 'Összes törlése';
                clearButton.addEventListener('click', () => {
                    clearFilterCheckboxes();
                    form.requestSubmit();
                });
                box.appendChild(clearButton);
            }
        }

        /**
         * Unchecks every filter in the Filters modal.
         */
        function clearFilterCheckboxes() {
            document.querySelectorAll('#filtersModal input[type="checkbox"]').forEach(input => {
                input.checked = false;
            });
        }

        /**
         * Opens the shared confirmation dialog. Its confirm button submits the given form.
         */
        function openConfirmModal(form, title, message) {
            formToConfirm = form;
            document.querySelector('.confirm-modal-title').textContent = title;
            document.querySelector('.confirm-modal-message').textContent = message;
            openModal('confirmModal');
        }

        /**
         * Character counter under maxlength fields, visible from 80% of the limit.
         */
        function updateCounter(field) {
            const counter = field.parentElement.querySelector('.char-counter');
            if (!counter) return;
            counter.textContent = field.value.length + ' / ' + field.maxLength;
            counter.classList.toggle('char-counter--visible', field.value.length >= field.maxLength * 0.8);
        }

        document.addEventListener('click', event => {
            const openButton = event.target.closest('[data-modal-open]');
            if (openButton) openModal(openButton.dataset.modalOpen);

            const closeButton = event.target.closest('[data-modal-close]');
            if (closeButton) closeButton.closest('.modal').classList.remove('active');

            if (event.target.classList.contains('modal')) event.target.classList.remove('active');
        });

        updateFilterSummary();

        const filtersResetButton = document.querySelector('#filtersModal .btn-reset');
        if (filtersResetButton) filtersResetButton.addEventListener('click', clearFilterCheckboxes);

        document.querySelectorAll('#sortModal input[name="sort"]').forEach(radio => {
            radio.addEventListener('change', () => radio.form.requestSubmit());
        });

        if (!document.getElementById('filtersModal')) {
            document.querySelectorAll('.header-search .btn-filters, .header-search .btn-sort, .header-search .search-divider').forEach(element => {
                element.style.display = 'none';
            });
        }

        document.getElementById('confirmModalSubmit').addEventListener('click', () => {
            if (formToConfirm) formToConfirm.submit();
        });

        document.addEventListener('submit', event => {
            const form = event.target;
            if (!form.dataset.confirm) return;
            event.preventDefault();
            openConfirmModal(form, form.dataset.confirmTitle || 'Biztosan folytatod?', form.dataset.confirm);
        });

        if (window.matchMedia('(max-width: 768px)').matches) {
            document.querySelectorAll('.search-input').forEach(input => {
                input.placeholder = 'Keresés...';
            });
        } else if (window.matchMedia('(max-width: 1200px)').matches) {
            document.querySelector('.header-search .search-input').placeholder = 'Keresés...';
        }

        const heroImage = document.querySelector('.hero-image');
        const desktopSearchBar = document.querySelector('.recipes-section .search-bar');
        const mobileSearchBar = document.querySelector('.mobile-search-sticky .search-bar');
        const isMobileHero = !(heroImage && heroImage.offsetHeight > 0);
        const referenceElement = isMobileHero
            ? ((mobileSearchBar && mobileSearchBar.offsetHeight > 0) ? mobileSearchBar : desktopSearchBar)
            : heroImage;
        const header = document.querySelector('header');
        if (referenceElement && header) {
            const referenceRect = referenceElement.getBoundingClientRect();
            const searchBarOffset = isMobileHero
                ? referenceRect.top + window.scrollY
                : referenceRect.top + window.scrollY + referenceElement.offsetHeight / 2;
            const headerBottom = header.getBoundingClientRect().bottom;
            const extraDelay = window.matchMedia('(max-width: 768px)').matches ? 0 : 80;

            window.addEventListener('scroll', () => {
                header.classList.toggle('scrolled', window.scrollY >= searchBarOffset - headerBottom + extraDelay);
            });
        }

        document.querySelectorAll('.header-search, #searchForm, .mobile-search-sticky form').forEach(form => {
            form.addEventListener('submit', event => {
                const gallery = document.getElementById('recipe-gallery');
                if (!gallery) return;

                const targetUrl = form.action.split('#')[0];
                const targetPath = new URL(targetUrl, window.location.href).pathname;
                if (targetPath !== window.location.pathname) return;

                event.preventDefault();

                const mainForm = document.getElementById('searchForm');
                if (mainForm && form !== mainForm) {
                    mainForm.querySelector('input[name="search"]').value = form.querySelector('input[name="search"]').value;
                    mainForm.requestSubmit();
                    return;
                }

                const spinner = document.getElementById('loading-spinner');
                const loadMoreBtn = document.getElementById('load-more-btn');

                function hideSpinner() {
                    spinner.style.display = 'none';
                    gallery.style.opacity = '1';
                }

                currentPage = 1;
                if (loadMoreBtn) loadMoreBtn.style.display = 'none';
                spinner.style.display = 'flex';
                gallery.style.opacity = '0.5';

                const params = new URLSearchParams(new FormData(form));
                fetchJson(targetUrl + '?' + params.toString())
                    .then(data => {
                        gallery.innerHTML = data.html;
                        lucide.createIcons();

                        history.replaceState(null, '', targetUrl + '?' + params.toString() + '#recipes');

                        closeModal('filtersModal');
                        closeModal('sortModal');
                        updateFilterSummary();
                        document.querySelectorAll('input[name="search"]').forEach(input => {
                            input.value = params.get('search') || '';
                        });

                        if (data.hasMore && loadMoreBtn) {
                            loadMoreBtn.style.display = 'block';
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.textContent = 'További receptek betöltése...';
                        }

                        const recipesSection = document.getElementById('recipes');
                        if (recipesSection) recipesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });

                        const images = Array.from(gallery.querySelectorAll('img'));
                        let loadedCount = images.filter(image => image.complete).length;
                        if (loadedCount === images.length) {
                            hideSpinner();
                            return;
                        }
                        images.filter(image => !image.complete).forEach(image => {
                            image.addEventListener('load', () => {
                                loadedCount++;
                                if (loadedCount === images.length) hideSpinner();
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        hideSpinner();
                    });
            });
        });

        document.addEventListener('click', event => {
            if (!event.target.matches('#load-more-btn')) return;

            const button = event.target;
            const gallery = document.getElementById('recipe-gallery');
            const spinner = document.getElementById('loading-spinner');

            currentPage++;
            button.disabled = true;
            button.textContent = 'Betöltés...';
            spinner.style.display = 'flex';

            const url = new URL(window.location.href);
            url.searchParams.set('page', currentPage);

            fetchJson(url)
                .then(data => {
                    gallery.insertAdjacentHTML('beforeend', data.html);
                    lucide.createIcons();
                    if (!data.hasMore) {
                        button.remove();
                    } else {
                        button.disabled = false;
                        button.textContent = 'További receptek betöltése...';
                    }
                    spinner.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.style.display = 'none';
                    button.disabled = false;
                    button.textContent = 'További receptek betöltése...';
                });
        });

        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', () => {
            scrollToTopBtn.classList.toggle('visible', window.scrollY > 300);
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        document.addEventListener('submit', event => {
            const form = event.target.closest('.card-favorite-form, .banner-favorite-form');
            if (!form) return;

            event.preventDefault();

            const button = form.querySelector('.btn-favorite-card, .btn-favorite-banner');
            const badge = form.querySelector('.favorite-badge');

            fetchJson(form.action, { method: 'POST' })
                .then(data => {
                    if (form.hasAttribute('data-remove-card') && !data.isFavorited) {
                        const card = form.closest('.recipe-card');
                        if (card) {
                            card.remove();

                            const gallery = document.querySelector('.recipe-gallery');
                            if (gallery && gallery.querySelectorAll('.recipe-card').length === 0) {
                                const empty = document.createElement('p');
                                empty.textContent = 'Még nincsenek kedvenc receptjeid.';
                                gallery.replaceWith(empty);
                            }
                            return;
                        }
                    }

                    button.classList.toggle('favorited', data.isFavorited);
                    if (badge) badge.textContent = data.favoriteCount;
                    button.title = data.isFavorited ? 'Kedvenc törlése' : 'Kedvencnek jelölöm';
                    lucide.createIcons();
                })
                .catch(error => console.error('Error:', error));
        });

        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileMenuClose = document.querySelector('.mobile-menu-close');
        const desktopUserTrigger = document.querySelector('header .desktop-user .dropdown-trigger');

        desktopUserTrigger.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();
            mobileMenuOverlay.classList.toggle('open');
        });

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenuOverlay.classList.toggle('open');
            });
        }

        mobileMenuClose.addEventListener('click', () => {
            mobileMenuOverlay.classList.remove('open');
        });

        document.addEventListener('click', event => {
            if (mobileMenuOverlay.classList.contains('open') &&
                !mobileMenuOverlay.contains(event.target) &&
                !(mobileMenuBtn && mobileMenuBtn.contains(event.target)) &&
                !desktopUserTrigger.contains(event.target)) {
                mobileMenuOverlay.classList.remove('open');
            }
        });

        document.querySelectorAll('input[maxlength], textarea[maxlength]').forEach(updateCounter);
        document.addEventListener('input', event => {
            if (event.target.matches('input[maxlength], textarea[maxlength]')) updateCounter(event.target);
        });

        document.querySelectorAll('.select-all-checkbox').forEach(selectAll => {
            const table = selectAll.closest('table');
            const checkboxes = table.querySelectorAll('.row-checkbox');
            const bulkForm = document.querySelector('.bulk-delete-form');
            const bulkBtn = bulkForm ? bulkForm.querySelector('.bulk-delete-btn') : null;
            const bulkLabel = bulkBtn ? bulkBtn.textContent : '';

            function updateBulkButton() {
                const checkedCount = table.querySelectorAll('.row-checkbox:checked').length;
                if (bulkBtn) {
                    bulkBtn.disabled = checkedCount === 0;
                    bulkBtn.textContent = checkedCount > 0 ? bulkLabel + ' (' + checkedCount + ')' : bulkLabel;
                }
                selectAll.checked = checkboxes.length > 0 && checkedCount === checkboxes.length;
            }

            selectAll.addEventListener('change', () => {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateBulkButton();
            });

            checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateBulkButton));

            updateBulkButton();
        });

        document.querySelectorAll('.bulk-delete-form').forEach(form => {
            form.addEventListener('submit', event => {
                event.preventDefault();
                const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                openConfirmModal(form, 'Biztosan törlöd a kijelölt elemeket?', 'A kijelölt ' + checkedCount + ' elem véglegesen törlődik. Ez a művelet nem visszavonható.');
            });
        });

        lucide.createIcons();
    </script>
</body>
</html>
