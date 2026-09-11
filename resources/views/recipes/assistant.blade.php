@extends('layouts.app')

@section('title', 'Kukta asszisztens – ' . $recipe->title)
@section('bodyClass', 'assistant-page')

@section('content')
<div class="assistant">

    <a href="{{ route('recipes.show', $recipe->id) }}" class="assistant-close" aria-label="Kilépés az asszisztensből">✕</a>

    {{-- -1. lépés: leírás + háttérkép --}}
    <section class="assistant-screen is-active">
        <div class="assistant-intro" style="background-image: url('{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}');">
            <div class="assistant-greeting">
                {{-- Ide kerül majd egy gif a kabalafiguráról --}}
                <div class="assistant-mascot"><i data-lucide="chef-hat"></i></div>
                <p class="assistant-greeting-text">Szia! Én vagyok a Kukta asszisztensed, lépésről lépésre végigvezetlek a recepten.</p>
            </div>
            <div class="assistant-intro-overlay">
                <h1>{{ $recipe->title }}</h1>
                <p>{{ $recipe->description }}</p>
            </div>
        </div>
    </section>

    {{-- 0. lépés: hozzávalók --}}
    <section class="assistant-screen">
        <h2 class="assistant-heading">Hozzávalók <span class="ingredient-page-label" id="ingredientPageLabel"></span></h2>
        <div class="ingredient-pages" id="ingredientPages"></div>
        <div class="page-dots" id="ingredientDots"></div>
    </section>

    {{-- 1..n. lépések --}}
    @foreach ($recipe->steps as $step)
        <section class="assistant-screen">
            <div class="assistant-step">
                <div class="assistant-step-number">{{ $loop->iteration }}</div>
                <p class="assistant-step-text">{{ $step->description }}</p>
            </div>
        </section>
    @endforeach

    {{-- Befejezés: gratuláció + értékelés --}}
    <section class="assistant-screen">
        <div class="assistant-finish">
            <div class="finish-emoji">🎉</div>
            <h2 class="assistant-heading">Gratulálunk!</h2>
            <p>Sikeresen elkészítetted a(z) <strong>{{ $recipe->title }}</strong> receptet!</p>

            <form id="assistantRatingForm" data-authenticated="{{ auth()->check() ? '1' : '0' }}" data-rate-link="{{ route('recipes.rate.link', $recipe->id) }}" action="{{ route('recipes.score', $recipe->id) }}" method="POST" class="assistant-rating">
                @csrf
                <div class="assistant-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="assistant-star">
                            <input type="radio" name="score" value="{{ $i }}" {{ $userScore && $userScore->score == $i ? 'checked' : '' }}>
                            <span class="assistant-star-icon {{ $userScore && $i <= $userScore->score ? 'filled' : '' }}">★</span>
                        </label>
                    @endfor
                </div>
                <p class="assistant-rating-status" id="assistantRatingStatus">
                    {{ $userScore ? 'A te értékelésed: ' . $userScore->score . ' csillag' : 'Értékeld a receptet!' }}
                </p>
            </form>

            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-cook">Vissza a recepthez</a>
        </div>
    </section>

    {{-- Navigáció: nagy, oldalra rögzített nyilak --}}
    <nav class="assistant-nav">
        <button type="button" id="assistantPrev" class="btn-assistant-nav btn-assistant-prev" aria-label="Vissza">‹</button>
        <button type="button" id="assistantNext" class="btn-assistant-nav btn-assistant-next" aria-label="Tovább">›</button>
    </nav>
    <span class="assistant-progress" id="assistantProgress"></span>

    {{-- Rejtett hozzávaló lista – ebből épít lapokat a JS --}}
    <ul id="ingredientList" hidden>
        @foreach ($recipe->ingredients as $ingredient)
            <li class="ai-ingredient">
                <span class="ai-ingredient-qty">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span>
                <span class="ai-ingredient-name">{{ $ingredient->name }}</span>
            </li>
        @endforeach
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== 0. Hosszú lépés-szövegek szétosztása, ha nem férnének ki egy képernyőn =====
    // (a screens listát csak EZUTÁN olvassuk ki, hogy a felosztott képernyők is benne legyenek)
    repaginateLongSteps();

    function repaginateLongSteps() {
        const stepScreens = Array.from(document.querySelectorAll('.assistant-screen'))
            .filter(s => s.querySelector('.assistant-step'));

        stepScreens.forEach(screenEl => {
            const wasActive = screenEl.classList.contains('is-active');
            if (!wasActive) {
                screenEl.style.visibility = 'hidden';
                screenEl.classList.add('is-active');
            }

            const stepEl = screenEl.querySelector('.assistant-step');
            const ratio = stepEl.scrollHeight / screenEl.clientHeight;

            if (!wasActive) {
                screenEl.classList.remove('is-active');
                screenEl.style.visibility = '';
            }

            if (ratio > 1.05) {
                const partCount = Math.ceil(ratio);
                const textEl = screenEl.querySelector('.assistant-step-text');
                const parts = splitTextIntoParts(textEl.textContent.trim(), partCount);
                if (parts.length > 1) {
                    textEl.textContent = parts[0];
                    let insertAfter = screenEl;
                    for (let i = 1; i < parts.length; i++) {
                        const clone = screenEl.cloneNode(true);
                        clone.classList.remove('is-active');
                        clone.style.visibility = '';
                        clone.querySelector('.assistant-step-text').textContent = parts[i];
                        insertAfter.insertAdjacentElement('afterend', clone);
                        insertAfter = clone;
                    }
                }
            }
        });
    }

    // Egy hosszú szöveget mondatok mentén, kb. egyenlő méretű darabokra vág.
    // Ha nincs elég mondathatár (pl. egyetlen hosszú, vesszős mondat), szavanként vágunk.
    function splitTextIntoParts(text, n) {
        let chunks = text.match(/[^.!?]+[.!?]+["')\]]*\s*|[^.!?]+$/g) || [text];
        if (chunks.length < n) {
            chunks = text.match(/\S+\s*/g) || [text];
        }

        const target = text.length / n;
        const parts = [];
        let current = '';
        chunks.forEach(chunk => {
            current += chunk;
            if (current.length >= target && parts.length < n - 1) {
                parts.push(current.trim());
                current = '';
            }
        });
        if (current.trim()) parts.push(current.trim());
        return parts;
    }

    // ===== 1. Képernyők közötti navigáció =====
    const screens = Array.from(document.querySelectorAll('.assistant-screen'));
    const prevBtn = document.getElementById('assistantPrev');
    const nextBtn = document.getElementById('assistantNext');
    const progress = document.getElementById('assistantProgress');
    let current = 0;

    function showScreen(index) {
        current = index;
        screens.forEach((s, i) => s.classList.toggle('is-active', i === index));
        prevBtn.disabled = (current === 0);
        const isLast = current === screens.length - 1;
        nextBtn.style.visibility = isLast ? 'hidden' : 'visible';
        progress.textContent = (current + 1) + ' / ' + screens.length;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Ha épp a hozzávalók képernyőn vagyunk és van még hozzávaló-oldal,
    // a nyilak először azok között lapozzanak, csak utána váltsanak képernyőt.
    prevBtn.addEventListener('click', () => {
        const ingredientsScreen = pagesContainer.closest('.assistant-screen');
        if (screens[current] === ingredientsScreen && currentPage > 0) {
            currentPage--;
            showIngredientPage(currentPage);
            return;
        }
        if (current > 0) showScreen(current - 1);
    });

    nextBtn.addEventListener('click', () => {
        const ingredientsScreen = pagesContainer.closest('.assistant-screen');
        if (screens[current] === ingredientsScreen) {
            const pageCount = pagesContainer.querySelectorAll('.ingredient-grid').length;
            if (currentPage < pageCount - 1) {
                currentPage++;
                showIngredientPage(currentPage);
                return;
            }
        }
        if (current < screens.length - 1) showScreen(current + 1);
    });

    // ===== 2. Hozzávalók lapozása (dinamikus, a tényleges helyhez igazítva) =====
    const pagesContainer = document.getElementById('ingredientPages');
    const dotsContainer = document.getElementById('ingredientDots');
    const pageLabel = document.getElementById('ingredientPageLabel');
    const items = Array.from(document.querySelectorAll('#ingredientList .ai-ingredient'));
    const GRID_GAP = 12;              // .ingredient-grid gap
    const GRID_MARGIN_BOTTOM = 16;    // .ingredient-grid margin-bottom
    const DOTS_RESERVE = 24;          // .page-dot magassága + .page-dots margin-top (mindig fenntartjuk a helyét)
    let currentPage = 0;

    function getColumns() {
        const w = window.innerWidth;
        if (w >= 1024) return 3; // desktop + tablet fekvő
        if (w >= 768)  return 2; // tablet álló
        return 1;                // mobil
    }

    // Megméri, hány sor fér ki ténylegesen a képernyőn a fejléc és a pöttyök helye után.
    // A képernyő ilyenkor gyakran display:none (nem az aktív lépés), ezért mérés idejére
    // átmenetileg "aktívvá" tesszük (láthatatlanul), majd visszaállítjuk.
    function computeRowsPerPage(cols) {
        if (items.length === 0) return 1;

        const screenEl = pagesContainer.closest('.assistant-screen');
        const wasActive = screenEl.classList.contains('is-active');
        if (!wasActive) {
            screenEl.style.visibility = 'hidden';
            screenEl.classList.add('is-active');
        }

        const heading = document.querySelector('.assistant-heading');
        const headingStyle = getComputedStyle(heading);
        const headingSpace = heading.offsetHeight + parseFloat(headingStyle.marginBottom);

        const testGrid = document.createElement('div');
        testGrid.className = 'ingredient-grid';
        testGrid.style.gridTemplateColumns = 'repeat(' + cols + ', 1fr)';
        testGrid.appendChild(items[0].cloneNode(true));
        pagesContainer.appendChild(testGrid);
        const itemHeight = testGrid.firstChild.getBoundingClientRect().height || 50;
        pagesContainer.removeChild(testGrid);

        const available = screenEl.clientHeight - headingSpace - DOTS_RESERVE - GRID_MARGIN_BOTTOM;
        const rows = Math.floor((available + GRID_GAP) / (itemHeight + GRID_GAP));

        if (!wasActive) {
            screenEl.classList.remove('is-active');
            screenEl.style.visibility = '';
        }

        return Math.max(1, rows);
    }

    function renderIngredientPages() {
        const cols = getColumns();
        const perPage = cols * computeRowsPerPage(cols);
        const pageCount = Math.max(1, Math.ceil(items.length / perPage));
        currentPage = Math.min(currentPage, pageCount - 1);

        pagesContainer.innerHTML = '';
        dotsContainer.innerHTML = '';

        for (let p = 0; p < pageCount; p++) {
            const page = document.createElement('div');
            page.className = 'ingredient-grid';
            page.style.gridTemplateColumns = 'repeat(' + cols + ', 1fr)';
            items.slice(p * perPage, (p + 1) * perPage).forEach(item => page.appendChild(item));
            pagesContainer.appendChild(page);

            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'page-dot';
            dot.setAttribute('aria-label', (p + 1) + '. oldal');
            dot.addEventListener('click', () => { currentPage = p; showIngredientPage(p); });
            dotsContainer.appendChild(dot);
        }

        dotsContainer.style.display = (pageCount <= 1) ? 'none' : '';
        showIngredientPage(currentPage);
    }

    function showIngredientPage(p) {
        const pages = pagesContainer.querySelectorAll('.ingredient-grid');
        pages.forEach((pg, i) => pg.style.display = (i === p) ? 'grid' : 'none');
        dotsContainer.querySelectorAll('.page-dot').forEach((d, i) => d.classList.toggle('is-active', i === p));
        pageLabel.textContent = (p + 1) + ' / ' + pages.length;
    }

    renderIngredientPages();
    window.addEventListener('resize', renderIngredientPages);

    // ===== 3. Értékelés: hover-kitöltés + beküldés =====
    const ratingForm = document.getElementById('assistantRatingForm');
    if (ratingForm) {
        const isAuthenticated = ratingForm.dataset.authenticated === '1';
        const rateLink = ratingForm.dataset.rateLink;
        const starLabels = Array.from(ratingForm.querySelectorAll('.assistant-star'));

        // Hover: balról az adott csillagig narancsra vált (bejelentkezés nélkül is)
        starLabels.forEach(label => {
            label.addEventListener('mouseenter', function () {
                const hoverValue = parseInt(this.querySelector('input').value);
                starLabels.forEach(l => {
                    const starValue = parseInt(l.querySelector('input').value);
                    l.querySelector('.assistant-star-icon').classList.toggle('filled', starValue <= hoverValue);
                });
            });
        });

        ratingForm.addEventListener('mouseleave', function () {
            const checked = ratingForm.querySelector('input[name="score"]:checked');
            const checkedValue = checked ? parseInt(checked.value) : 0;
            starLabels.forEach(l => {
                const starValue = parseInt(l.querySelector('input').value);
                l.querySelector('.assistant-star-icon').classList.toggle('filled', starValue <= checkedValue);
            });
        });

        ratingForm.addEventListener('change', function (e) {
            if (!e.target.matches('input[name="score"]')) return;
            const value = e.target.value;

            // Bejelentkezés nélkül: átirányítjuk a link-alapú útvonalra, ami
            // bejelentkeztet, majd sikeres belépés után visszahozza és menti az értékelést.
            if (!isAuthenticated) {
                window.location.href = rateLink + '?score=' + value;
                return;
            }

            fetch(ratingForm.action, {
                method: 'POST',
                body: new FormData(ratingForm),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                ratingForm.querySelectorAll('.assistant-star-icon').forEach((icon, i) => {
                    icon.classList.toggle('filled', i < value);
                });
                document.getElementById('assistantRatingStatus').textContent =
                    'Köszönjük az értékelést! (' + value + ' csillag)';
            })
            .catch(() => {});
        });
    }

    // Kezdő képernyő
    showScreen(0);
});
</script>
@endsection