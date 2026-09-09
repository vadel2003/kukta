@extends('layouts.app')

@section('title', 'Kukta asszisztens – ' . $recipe->title)

@section('content')
<div class="assistant">

    {{-- -1. lépés: leírás + háttérkép --}}
    <section class="assistant-screen is-active">
        <div class="assistant-intro" style="background-image: url('{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}');">
            <div class="assistant-intro-overlay">
                <span class="assistant-badge">Kukta asszisztens</span>
                <h1>{{ $recipe->title }}</h1>
                <p>{{ $recipe->description }}</p>
            </div>
        </div>
    </section>

    {{-- 0. lépés: hozzávalók --}}
    <section class="assistant-screen">
        <h2 class="assistant-heading">Hozzávalók</h2>
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

            @auth
                <form id="assistantRatingForm" action="{{ route('recipes.score', $recipe->id) }}" method="POST" class="assistant-rating">
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
            @else
                <p class="assistant-rating-login">Az értékeléshez <a href="{{ route('login') }}">jelentkezz be</a>.</p>
            @endauth

            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-cook">Vissza a recepthez</a>
        </div>
    </section>

    {{-- Navigáció --}}
    <nav class="assistant-nav">
        <button type="button" id="assistantPrev" class="btn-assistant-nav">← Vissza</button>
        <span class="assistant-progress" id="assistantProgress"></span>
        <button type="button" id="assistantNext" class="btn-assistant-nav">Tovább →</button>
    </nav>

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

    prevBtn.addEventListener('click', () => { if (current > 0) showScreen(current - 1); });
    nextBtn.addEventListener('click', () => { if (current < screens.length - 1) showScreen(current + 1); });

    // ===== 2. Hozzávalók lapozása (dinamikus) =====
    const pagesContainer = document.getElementById('ingredientPages');
    const dotsContainer = document.getElementById('ingredientDots');
    const items = Array.from(document.querySelectorAll('#ingredientList .ai-ingredient'));
    const ROWS_PER_PAGE = 6;
    let currentPage = 0;

    function getColumns() {
        const w = window.innerWidth;
        if (w >= 1024) return 3; // desktop + tablet fekvő
        if (w >= 768)  return 2; // tablet álló
        return 1;                // mobil
    }

    function renderIngredientPages() {
        const cols = getColumns();
        const perPage = cols * ROWS_PER_PAGE;
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
            dot.textContent = p + 1;
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
    }

    renderIngredientPages();
    window.addEventListener('resize', renderIngredientPages);

    // ===== 3. Értékelés beküldése (AJAX) =====
    const ratingForm = document.getElementById('assistantRatingForm');
    if (ratingForm) {
        ratingForm.addEventListener('change', function (e) {
            if (!e.target.matches('input[name="score"]')) return;
            const value = e.target.value;

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