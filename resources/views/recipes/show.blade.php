@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="recipe-detail">
    <!-- Felső szekció: kép balra, hozzávalók jobbra -->
    <section class="recipe-top">
        <!-- Bal oldal: kép + info -->
        <div class="recipe-left">
            <div class="recipe-banner">
                <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="banner-image">
                @auth
                    <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="banner-favorite-form">
                        @csrf
                        <button type="submit" class="btn-favorite-banner {{ $isFavorited ? 'favorited' : '' }}" title="{{ $isFavorited ? 'Kedvenc törlése' : 'Kedvencnek jelölöm' }}">
                            {{ $isFavorited ? '❤️' : '🤍' }}
                        </button>
                        <span class="favorite-badge">{{ $favoriteCount }}</span>
                    </form>
                @endauth
            </div>

            <h1 class="recipe-title">{{ $recipe->title }}</h1>

            <div class="recipe-info">
                <div class="recipe-meta">
                    <div class="meta-author">
                        <img src="{{ $recipe->user->avatar ? asset($recipe->user->avatar) : asset('images/default_avatar.svg') }}" alt="Profilkép" class="author-avatar">
                        <span>{{ $recipe->user->name }}</span>
                    </div>
                    <div class="meta-date">
                        <span class="meta-icon">📅</span>
                        <span>{{ $recipe->creation_date->format('Y. m. d.') }}</span>
                    </div>
                </div>

                {{-- ⭐ Csillagos értékelés szekció --}}
                <div class="star-rating-section">
                    <span class="stars">{{ str_repeat('★', round($averageScore ?? 0)) }}{{ str_repeat('☆', 5 - round($averageScore ?? 0)) }}</span>
                    <span class="rating-number">{{ number_format($averageScore ?? 0, 1) }}</span>
                    <span class="review-count">({{ $scoreCount }} értékelés)</span>
                </div>

                <p class="recipe-description">{{ $recipe->description }}</p>
            </div>
        </div>

        <!-- Jobb oldal: hozzávalók -->
        <div class="content-card ingredients-card">
            <h2 class="content-title">
                <span class="title-icon">🥘</span>
                Hozzávalók
            </h2>
            <ul class="ingredients-list">
                @foreach ($recipe->ingredients as $ingredient)
                    <li class="ingredient-item">
                        <span class="ingredient-quantity">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span>
                        <span class="ingredient-name">{{ $ingredient->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- Alsó szekció: elkészítés -->
    <section class="content-card steps-card">
        <h2 class="content-title">
            <span class="title-icon">👨‍🍳</span>
            Elkészítés
        </h2>
        <ol class="steps-list">
            @foreach ($recipe->steps as $step)
                <li class="step-item">
                    <div class="step-number">{{ $loop->iteration }}</div>
                    <p class="step-text">{{ $step->description }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    <!-- Értékelések szekció -->
    <section class="content-card reviews-card">
        <h2 class="content-title">
            Értékelések
        </h2>

        <div class="rating-summary">
            <!-- Bal oldal: átlag + csillagok + darabszám -->
            <div class="rating-summary-left">
                <div class="rating-average">{{ number_format($averageScore, 1) }}</div>
                <div class="rating-stars-display">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= round($averageScore) ? 'filled' : '' }}">★</span>
                    @endfor
                </div>
                <div class="rating-count">{{ $scoreCount }} értékelés</div>
            </div>

            <!-- Jobb oldal: eloszlás sávok -->
            <div class="rating-summary-right">
                @for ($i = 5; $i >= 1; $i--)
                    <div class="rating-bar">
                        <span class="rating-bar-label">{{ $i }}★</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: {{ $distributionPercentages[$i]['percentage'] }}%"></div>
                        </div>
                        <span class="rating-bar-count">{{ $distributionPercentages[$i]['count'] }}</span>
                    </div>
                @endfor
            </div>
        </div>

        <div class="rating-divider"></div>

        <!-- Saját értékelés blokk -->
        @auth
            <div class="rating-personal">
                <h3 class="rating-personal-title">Értékeld a receptet!</h3>
                <form id="ratingForm" action="{{ route('recipes.score', $recipe->id) }}" method="POST">
                    @csrf
                    <div class="rating-stars-interactive">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="star-label">
                                <input type="radio" name="score" value="{{ $i }}" 
                                       {{ $userScore && $userScore->score == $i ? 'checked' : '' }} 
                                       class="star-input">
                                <span class="star-icon {{ $userScore && $i <= $userScore->score ? 'filled' : '' }}">★</span>
                            </label>
                        @endfor
                    </div>
                    @if ($userScore)
                        <p class="rating-personal-status" id="ratingStatus">A te értékelésed: {{ $userScore->score }} csillag</p>
                    @else
                        <p class="rating-personal-status" id="ratingStatus">Kattints egy csillagra az értékeléshez</p>
                    @endif
                </form>
            </div>
        @else
            <div class="rating-personal">
                <p class="rating-login-prompt">
                    Az értékeléshez <a href="{{ route('login') }}">jelentkezz be</a>
                </p>
            </div>
        @endauth
    </section>

</div>

@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ratingForm');
    if (!form) return;

    const stars = document.querySelectorAll('.star-input');
    const starLabels = document.querySelectorAll('.star-label');

    // Hover effekt: balról az adott csillagig narancsra vált
    starLabels.forEach(label => {
        label.addEventListener('mouseenter', function() {
            const hoverValue = parseInt(this.querySelector('.star-input').value);
            starLabels.forEach(l => {
                const icon = l.querySelector('.star-icon');
                const starValue = parseInt(l.querySelector('.star-input').value);
                if (starValue <= hoverValue) {
                    icon.classList.add('filled');
                }
            });
        });

        label.addEventListener('mouseleave', function() {
            // Visszaállítás az aktuálisan kiválasztott értékre
            const checked = document.querySelector('.star-input:checked');
            const checkedValue = checked ? parseInt(checked.value) : 0;
            starLabels.forEach(l => {
                const icon = l.querySelector('.star-icon');
                const starValue = parseInt(l.querySelector('.star-input').value);
                if (starValue <= checkedValue) {
                    icon.classList.add('filled');
                } else {
                    icon.classList.remove('filled');
                }
            });
        });
    });

    stars.forEach(star => {
        star.addEventListener('change', function() {
            const selectedValue = this.value;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Átlag frissítése
                    document.querySelector('.rating-average').textContent = data.averageScore.toFixed(1);

                    // Csillagok frissítése (összesítő)
                    const starsDisplay = document.querySelectorAll('.rating-stars-display .star');
                    starsDisplay.forEach((star, index) => {
                        if (index < Math.round(data.averageScore)) {
                            star.classList.add('filled');
                        } else {
                            star.classList.remove('filled');
                        }
                    });

                    // Darabszám frissítése
                    document.querySelector('.rating-count').textContent = data.scoreCount + ' értékelés';

                    // Eloszlás sávok frissítése
                    for (let i = 5; i >= 1; i--) {
                        const barFill = document.querySelector(`.rating-bar:nth-child(${6 - i}) .rating-bar-fill`);
                        const barCount = document.querySelector(`.rating-bar:nth-child(${6 - i}) .rating-bar-count`);
                        if (barFill && barCount && data.distribution[i]) {
                            barFill.style.width = data.distribution[i].percentage + '%';
                            barCount.textContent = data.distribution[i].count;
                        }
                    }

                    // Saját kattintható csillagok frissítése
                    const interactiveIcons = document.querySelectorAll('.rating-stars-interactive .star-icon');
                    interactiveIcons.forEach((icon, index) => {
                        if (index + 1 <= parseInt(selectedValue)) {
                            icon.classList.add('filled');
                        } else {
                            icon.classList.remove('filled');
                        }
                    });

                    // Státusz frissítése
                    const status = document.getElementById('ratingStatus');
                    if (status) {
                        status.textContent = `A te értékelésed: ${selectedValue} csillag`;
                        status.style.color = '#e67e22';
                        setTimeout(() => {
                            status.style.color = '';
                        }, 2000);
                    }
                }
            })
            .catch(error => {
                console.error('Hiba:', error);
            });
        });
    });
});
</script>
@endauth
@endsection