@extends('layouts.app')

@section('title', 'Kukta asszisztens – ' . $recipe->title)
@section('bodyClass', 'assistant-page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/assistant/assistant.css') }}?v={{ filemtime(public_path('css/assistant/assistant.css')) }}">
@endpush

@section('content')
    <div class="assistant" style="--assistant-bg-image: url('{{ $recipe->thumbnail_url }}');">
        <a href="{{ route('recipes.show', $recipe->id) }}" class="assistant-close" aria-label="Kilépés az asszisztensből"><i data-lucide="x"></i></a>

        <section class="assistant-screen is-active">
            <div class="assistant-intro" style="background-image: url('{{ $recipe->thumbnail_url }}');">
                <div class="assistant-intro-content">
                    <div class="assistant-intro-card assistant-greeting-card">
                        <div class="assistant-figure-slot">
                            <div class="assistant-figure" id="assistantFigure"
                                data-src="{{ asset('lottie/assistant.json') }}?v={{ filemtime(public_path('lottie/assistant.json')) }}">
                                <div class="assistant-figure-anim" role="img" aria-label="Kukta asszisztens, a borsó főzősegéd"></div>
                                <div class="assistant-figure-bubble" aria-live="polite"></div>
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
                        <x-step-animation :category="$step->stepCategory" />
                        <p class="assistant-step-text">{{ $step->description }}</p>
                    </div>
                </div>
            </section>
        @endforeach

        <section class="assistant-screen assistant-screen-finish">
            <div class="assistant-finish">
                <div class="content-card assistant-finish-card">
                    <div class="assistant-figure-slot"></div>

                    <form id="assistantRatingForm" data-authenticated="{{ Auth::check() ? '1' : '0' }}" data-rate-link="{{ route('recipes.rate.link', $recipe->id) }}" action="{{ route('recipes.rate', $recipe->id) }}" method="POST" class="assistant-rating">
                        @csrf
                        <div class="assistant-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="assistant-star">
                                    <input type="radio" name="score" value="{{ $i }}" {{ $userRating && $userRating->score == $i ? 'checked' : '' }}>
                                    <span class="assistant-star-icon {{ $userRating && $i <= $userRating->score ? 'filled' : '' }}">★</span>
                                </label>
                            @endfor
                        </div>
                        <p class="assistant-rating-status" id="assistantRatingStatus">
                            {{ $userRating ? 'A te értékelésed: ' . $userRating->score . ' csillag' : 'Értékeld a receptet!' }}
                        </p>
                    </form>

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

    <script src="{{ asset('js/lottie.min.js') }}?v={{ filemtime(public_path('js/lottie.min.js')) }}"></script>
    <script src="{{ asset('js/assistant-figure.js') }}?v={{ filemtime(public_path('js/assistant-figure.js')) }}"></script>
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

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const prevButton = document.getElementById('assistantPrev');
            const nextButton = document.getElementById('assistantNext');
            const nextZone = nextButton.closest('.assistant-nav-zone');
            const progress = document.getElementById('assistantProgress');
            const figureElement = document.getElementById('assistantFigure');
            const pagesContainer = document.getElementById('ingredientPages');
            const ingredientsScreen = pagesContainer.closest('.assistant-screen');
            const dotsContainer = document.getElementById('ingredientDots');
            const items = Array.from(document.querySelectorAll('#ingredientList .assistant-ingredient'));
            const stepAnimations = [];

            let screens = [];
            let current = 0;
            let currentIngredientPage = 0;
            let figure = null;
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
             * Shows the given screen: starts its step animation, moves the figure and updates the counter.
             */
            function showScreen(index) {
                const previous = current;
                current = index;
                screens.forEach((screen, i) => screen.classList.toggle('is-active', i === index));
                prevButton.disabled = current === 0;
                const isLast = current === screens.length - 1;
                nextZone.style.visibility = isLast ? 'hidden' : 'visible';
                progress.textContent = (current + 1) + ' / ' + screens.length;

                if (!reduceMotion) {
                    stepAnimations.forEach(item => {
                        if (item.screen === screens[index]) {
                            item.animation.goToAndPlay(0, true);
                        } else {
                            item.animation.stop();
                        }
                    });
                }

                const figureSlot = screens[index].querySelector('.assistant-figure-slot');
                if (figureSlot) figureSlot.appendChild(figureElement);

                if (figure && isLast && previous === index - 1) figure.goodbye();
                if (figure && index === 0 && previous !== 0) figure.sayHello();

                window.scrollTo({ top: 0, behavior: 'smooth' });
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

            document.querySelectorAll('.step-animation').forEach(element => {
                const animation = lottie.loadAnimation({
                    container: element,
                    renderer: 'svg',
                    loop: true,
                    autoplay: false,
                    path: element.dataset.src,
                });
                if (reduceMotion) {
                    animation.addEventListener('DOMLoaded', () => animation.goToAndStop(50, true));
                }
                stepAnimations.push({ screen: element.closest('.assistant-screen'), animation: animation });
            });

            fetchJson(figureElement.dataset.src)
                .then(data => {
                    figure = createAssistant(figureElement, data);
                    setTimeout(() => figure.hello(), 300);
                })
                .catch(error => console.error('Error:', error));

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

            const ratingForm = document.getElementById('assistantRatingForm');
            const ratingStarLabels = Array.from(ratingForm.querySelectorAll('.assistant-star'));

            /**
             * Fills the rating stars up to the given score.
             */
            function fillRatingStars(score) {
                ratingStarLabels.forEach(label => {
                    const starValue = parseInt(label.querySelector('input').value);
                    label.querySelector('.assistant-star-icon').classList.toggle('filled', starValue <= score);
                });
            }

            ratingStarLabels.forEach(label => {
                label.addEventListener('mouseenter', () => fillRatingStars(parseInt(label.querySelector('input').value)));
            });

            ratingForm.addEventListener('mouseleave', () => {
                const checked = ratingForm.querySelector('input[name="score"]:checked');
                fillRatingStars(checked ? parseInt(checked.value) : 0);
            });

            ratingForm.addEventListener('change', event => {
                const score = parseInt(event.target.value);

                if (ratingForm.dataset.authenticated !== '1') {
                    window.location.href = ratingForm.dataset.rateLink + '?score=' + score;
                    return;
                }

                fetchJson(ratingForm.action, { method: 'POST', body: new FormData(ratingForm) })
                    .then(() => {
                        fillRatingStars(score);
                        document.getElementById('assistantRatingStatus').textContent = 'Köszönjük az értékelést! (' + score + ' csillag)';
                    })
                    .catch(error => console.error('Error:', error));
            });

            showScreen(0);
        });
    </script>
@endsection
