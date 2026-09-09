@forelse ($recipes as $recipe)
    <div class="recipe-card">
        <div class="card-image-wrapper">
            <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
            @auth
                <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="card-favorite-form">
                    @csrf
                    <button type="submit" class="btn-favorite-card {{ in_array($recipe->id, $favoriteIds) ? 'favorited' : '' }}" title="{{ in_array($recipe->id, $favoriteIds) ? 'Kedvenc törlése' : 'Kedvencnek jelölöm' }}">
                        <i data-lucide="heart"></i>
                    </button>
                    <span class="favorite-badge">{{ $recipe->favorites_count }}</span>
                </form>
            @endauth
        </div>
        <h2>{{ $recipe->title }}</h2>

        {{-- ⭐ Csillagos értékelés (dinamikus) --}}
        <div class="star-rating">
            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= round($recipe->scores_avg_score ?? 0) ? 'filled' : '' }}">★</span>
                @endfor
            </span>
            <span class="rating-number">{{ number_format($recipe->scores_avg_score ?? 0, 1) }}</span>
            <span class="review-count">({{ $recipe->scores_count ?? 0 }})</span>
        </div>

        <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
        <div class="card-actions">
            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Részletek</a>
            <a href="{{ route('recipes.assistant', $recipe->id) }}" class="btn-spoon" title="Kukta asszisztens" aria-label="Kukta asszisztens">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <ellipse cx="8" cy="6.5" rx="4" ry="4.5"></ellipse>
                    <path d="M11.5 9.5 20 18"></path>
                </svg>
            </a>
        </div>

        {{-- Hover tooltip: a recept teljes leírása --}}
        <div class="card-tooltip">
            <p class="tooltip-description">{{ $recipe->description }}</p>
        </div>
    </div>
@empty
    <p class="no-results">Nem található recept a megadott szűrési feltételekkel.</p>
@endforelse