@extends('layouts.app')

@section('title', 'Kukta asszisztens – ' . $recipe->title)
@section('bodyClass', 'assistant-page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/assistant/assistant.css') }}">
@endsection

@section('content')
    <div class="assistant" style="--assistant-bg-image: url('{{ asset($recipe->thumbnail) }}');">
        <a href="{{ route('recipes.show', $recipe->id) }}" class="assistant-close" aria-label="Kilépés az asszisztensből"><i data-lucide="x"></i></a>

        <section class="assistant-screen is-active">
            <div class="assistant-intro" style="background-image: url('{{ asset($recipe->thumbnail) }}');">
                <div class="assistant-intro-content">
                    <div class="assistant-intro-card assistant-greeting-card">
                        <div class="assistant-figure-slot">
                            <div class="assistant-figure">
                                <img src="{{ asset('images/assistant-figure.svg') }}" alt="Kukta asszisztens, a borsó főzősegéd" class="assistant-figure-image">
                                <p class="assistant-figure-bubble">Szia!<br>Én vagyok az asszisztensed.<br>Induljon a főzés!</p>
                            </div>
                        </div>
                    </div>
                    <div class="assistant-intro-card assistant-intro-overlay">
                        <h1>{{ $recipe->title }}</h1>
                        <p>{{ $recipe->description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="assistant-screen">
            <div class="assistant-ingredients">
                <div class="content-card assistant-ingredients-card">
                    <h2 class="assistant-heading">Hozzávalók</h2>
                    <div class="ingredient-pages" id="ingredientPages"></div>
                    <div class="page-dots" id="ingredientDots"></div>
                </div>
            </div>
        </section>

        @foreach ($recipe->steps as $step)
            <section class="assistant-screen">
                <div class="assistant-step">
                    <div class="content-card assistant-step-card">
                        <div class="assistant-step-number">{{ $loop->iteration }}</div>
                        <img src="{{ asset($step->stepCategory->thumbnail) }}" alt="{{ $step->stepCategory->name }}" class="step-image">
                        <p class="assistant-step-text">{{ $step->description }}</p>
                    </div>
                </div>
            </section>
        @endforeach

        <section class="assistant-screen assistant-screen-finish">
            <div class="assistant-finish">
                <div class="content-card assistant-finish-card">
                    <div class="assistant-figure-slot">
                        <div class="assistant-figure">
                            <img src="{{ asset('images/assistant-figure.svg') }}" alt="Kukta asszisztens, a borsó főzősegéd" class="assistant-figure-image">
                            <p class="assistant-figure-bubble">Jó étvágyat!</p>
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST" class="assistant-rating">
                            @csrf
                            <div class="assistant-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="submit" name="score" value="{{ $i }}" class="assistant-star {{ $userRating && $i <= $userRating->score ? 'filled' : '' }}" title="{{ $i }} csillag">★</button>
                                @endfor
                            </div>
                            <p class="assistant-rating-status">
                                {{ $userRating ? 'A te értékelésed: ' . $userRating->score . ' csillag' : 'Értékeld a receptet!' }}
                            </p>
                        </form>
                    @else
                        <p class="assistant-rating-status">
                            Az értékeléshez <a href="{{ route('recipes.rate.login', $recipe->id) }}">jelentkezz be</a>
                        </p>
                    @endauth

                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-cook btn-cook-primary">Vissza a recepthez</a>
                </div>
            </div>
        </section>

        <nav class="assistant-nav">
            <div class="assistant-nav-zone assistant-nav-zone-prev">
                <button type="button" id="assistantPrev" class="btn-assistant-nav btn-assistant-prev" aria-label="Vissza"><i data-lucide="chevron-left"></i></button>
            </div>
            <div class="assistant-nav-zone assistant-nav-zone-next">
                <button type="button" id="assistantNext" class="btn-assistant-nav btn-assistant-next" aria-label="Tovább"><i data-lucide="chevron-right"></i></button>
            </div>
        </nav>
        <span class="assistant-progress" id="assistantProgress"></span>

        <ul id="ingredientList" hidden>
            @foreach ($recipe->ingredients as $ingredient)
                <li class="assistant-ingredient">
                    <span class="assistant-ingredient-qty">{{ str_replace('.', ',', (float) $ingredient->pivot->quantity) }} {{ \App\Models\IngredientRecipe::UNITS[$ingredient->pivot->unit] ?? '' }}</span>
                    <span class="assistant-ingredient-name">{{ $ingredient->name }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /** Swipes shorter than this (px) do not change the page. */
            const SWIPE_MIN = 50;
            /** The gap of .ingredient-grid (px). */
            const GRID_GAP = 12;
            /** The margin-bottom of .ingredient-grid (px). */
            const GRID_MARGIN_BOTTOM = 16;
            /** Space reserved for the page dots (px): .page-dot height + .page-dots margin-top. */
            const DOTS_RESERVE = 24;

            const prevButton = document.getElementById('assistantPrev');
            const nextButton = document.getElementById('assistantNext');
            const nextZone = nextButton.closest('.assistant-nav-zone');
            const progress = document.getElementById('assistantProgress');
            const pagesContainer = document.getElementById('ingredientPages');
            const ingredientsScreen = pagesContainer.closest('.assistant-screen');
            const dotsContainer = document.getElementById('ingredientDots');
            const items = Array.from(document.querySelectorAll('#ingredientList .assistant-ingredient'));

            let screens = [];
            let current = 0;
            let currentIngredientPage = 0;
            let touchStartX = 0;
            let touchStartY = 0;

            /**
             * Measures a hidden screen by making it active but invisible during the measurement.
             *
             * @param {HTMLElement} screen
             * @param {function(): *} measure the function that does the measuring
             * @returns {*} the return value of measure()
             */
            function measureScreen(screen, measure) {
                const wasActive = screen.classList.contains('is-active');
                if (!wasActive) {
                    screen.style.visibility = 'hidden';
                    screen.classList.add('is-active');
                }

                const result = measure();

                if (!wasActive) {
                    screen.classList.remove('is-active');
                    screen.style.visibility = '';
                }
                return result;
            }

            /**
             * Splits step texts that do not fit on one screen into several consecutive screens.
             */
            function repaginateLongSteps() {
                document.querySelectorAll('.assistant-screen').forEach(screen => {
                    const stepElement = screen.querySelector('.assistant-step');
                    if (!stepElement) return;

                    const ratio = measureScreen(screen, () => stepElement.scrollHeight / screen.clientHeight);
                    if (ratio <= 1.05) return;

                    const textElement = screen.querySelector('.assistant-step-text');
                    const parts = splitTextIntoParts(textElement.textContent.trim(), Math.ceil(ratio));
                    if (parts.length <= 1) return;

                    textElement.textContent = parts[0];
                    let insertAfter = screen;
                    parts.slice(1).forEach(part => {
                        const clone = screen.cloneNode(true);
                        clone.classList.remove('is-active');
                        clone.querySelector('.assistant-step-text').textContent = part;
                        insertAfter.insertAdjacentElement('afterend', clone);
                        insertAfter = clone;
                    });
                });
            }

            /**
             * Splits a text into roughly equal parts at sentence boundaries (by words if there are not enough sentences).
             *
             * @param {string} text
             * @param {number} count the number of parts
             * @returns {string[]}
             */
            function splitTextIntoParts(text, count) {
                let chunks = text.match(/[^.!?]+[.!?]+["')\]]*\s*|[^.!?]+$/g) || [text];
                if (chunks.length < count) {
                    chunks = text.match(/\S+\s*/g) || [text];
                }

                const target = text.length / count;
                const parts = [];
                let part = '';
                chunks.forEach(chunk => {
                    part += chunk;
                    if (part.length >= target && parts.length < count - 1) {
                        parts.push(part.trim());
                        part = '';
                    }
                });
                if (part.trim()) parts.push(part.trim());
                return parts;
            }

            /**
             * Shows the given screen and updates the counter.
             */
            function showScreen(index) {
                current = index;
                screens.forEach((screen, i) => screen.classList.toggle('is-active', i === index));
                prevButton.disabled = current === 0;
                nextZone.style.visibility = current === screens.length - 1 ? 'hidden' : 'visible';
                progress.textContent = (current + 1) + ' / ' + screens.length;

                window.scrollTo(0, 0);
            }

            /**
             * Number of columns in the ingredient grid, based on the screen width.
             */
            function getColumns() {
                if (window.innerWidth >= 1024) return 3;
                if (window.innerWidth >= 768) return 2;
                return 1;
            }

            /**
             * How many ingredient rows fit on the ingredients screen next to the heading, paddings and dots.
             */
            function computeRowsPerPage(columns) {
                if (items.length === 0) return 1;

                return measureScreen(ingredientsScreen, () => {
                    const heading = document.querySelector('.assistant-heading');
                    const headingSpace = heading.offsetHeight + parseFloat(getComputedStyle(heading).marginBottom);

                    const testGrid = document.createElement('div');
                    testGrid.className = 'ingredient-grid';
                    testGrid.style.gridTemplateColumns = 'repeat(' + columns + ', 1fr)';
                    testGrid.appendChild(items[0].cloneNode(true));
                    pagesContainer.appendChild(testGrid);
                    const itemHeight = testGrid.firstChild.getBoundingClientRect().height || 50;
                    pagesContainer.removeChild(testGrid);

                    const card = pagesContainer.closest('.assistant-ingredients-card');
                    const cardStyle = getComputedStyle(card);
                    const wrapperStyle = getComputedStyle(card.parentElement);
                    const paddingSpace = parseFloat(cardStyle.paddingTop) + parseFloat(cardStyle.paddingBottom)
                        + parseFloat(wrapperStyle.paddingTop) + parseFloat(wrapperStyle.paddingBottom);

                    const available = ingredientsScreen.clientHeight - paddingSpace - headingSpace - DOTS_RESERVE - GRID_MARGIN_BOTTOM;
                    return Math.max(1, Math.floor((available + GRID_GAP) / (itemHeight + GRID_GAP)));
                });
            }

            /**
             * Splits the ingredients into pages by the number of rows that fit, with page dots.
             */
            function renderIngredientPages() {
                const columns = getColumns();
                const perPage = columns * computeRowsPerPage(columns);
                const pageCount = Math.max(1, Math.ceil(items.length / perPage));
                currentIngredientPage = Math.min(currentIngredientPage, pageCount - 1);

                pagesContainer.innerHTML = '';
                dotsContainer.innerHTML = '';

                for (let page = 0; page < pageCount; page++) {
                    const grid = document.createElement('div');
                    grid.className = 'ingredient-grid';
                    grid.style.gridTemplateColumns = 'repeat(' + columns + ', 1fr)';
                    items.slice(page * perPage, (page + 1) * perPage).forEach(item => grid.appendChild(item));
                    pagesContainer.appendChild(grid);

                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'page-dot';
                    dot.setAttribute('aria-label', (page + 1) + '. oldal');
                    dot.addEventListener('click', () => {
                        currentIngredientPage = page;
                        showIngredientPage(page);
                    });
                    dotsContainer.appendChild(dot);
                }

                dotsContainer.style.display = pageCount <= 1 ? 'none' : '';
                showIngredientPage(currentIngredientPage);
            }

            /**
             * Shows the given ingredient page.
             */
            function showIngredientPage(page) {
                pagesContainer.querySelectorAll('.ingredient-grid').forEach((grid, i) => {
                    grid.style.display = i === page ? 'grid' : 'none';
                });
                dotsContainer.querySelectorAll('.page-dot').forEach((dot, i) => dot.classList.toggle('is-active', i === page));
            }

            repaginateLongSteps();
            screens = Array.from(document.querySelectorAll('.assistant-screen'));

            prevButton.addEventListener('click', () => {
                if (screens[current] === ingredientsScreen && currentIngredientPage > 0) {
                    currentIngredientPage--;
                    showIngredientPage(currentIngredientPage);
                    return;
                }
                if (current > 0) showScreen(current - 1);
            });

            nextButton.addEventListener('click', () => {
                const pageCount = pagesContainer.querySelectorAll('.ingredient-grid').length;
                if (screens[current] === ingredientsScreen && currentIngredientPage < pageCount - 1) {
                    currentIngredientPage++;
                    showIngredientPage(currentIngredientPage);
                    return;
                }
                if (current < screens.length - 1) showScreen(current + 1);
            });

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') document.querySelector('.assistant-close').click();
                if (event.key === 'ArrowLeft') prevButton.click();
                if (event.key === 'ArrowRight') nextButton.click();
            });

            document.addEventListener('touchstart', event => {
                touchStartX = event.changedTouches[0].clientX;
                touchStartY = event.changedTouches[0].clientY;
            }, { passive: true });

            document.addEventListener('touchend', event => {
                const deltaX = event.changedTouches[0].clientX - touchStartX;
                const deltaY = event.changedTouches[0].clientY - touchStartY;
                if (Math.abs(deltaX) < SWIPE_MIN || Math.abs(deltaX) < Math.abs(deltaY) * 1.5) return;
                if (deltaX < 0) {
                    nextButton.click();
                } else {
                    prevButton.click();
                }
            }, { passive: true });

            document.querySelectorAll('.assistant-nav-zone').forEach(zone => {
                zone.addEventListener('click', event => {
                    if (event.target === zone) zone.querySelector('button').click();
                });
            });

            renderIngredientPages();
            window.addEventListener('resize', renderIngredientPages);

            showScreen(0);
        });
    </script>
@endsection
