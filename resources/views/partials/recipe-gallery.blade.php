@forelse ($recipes as $recipe)
    <div class="recipe-card">
        <div class="card-image-wrapper">
            <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
            @auth
                <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="card-favorite-form" @if(!empty($removeOnUnfavorite)) data-remove-card="true" @endif>
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
                <i data-lucide="bot"></i>
            </a>
            @if (!empty($showOwnerActions))
                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-edit">Szerkesztés</a>
                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt a receptet?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Törlés</button>
                </form>
            @endif
        </div>

        {{-- Hover tooltip: a recept teljes leírása --}}
        <div class="card-tooltip">
            <p class="tooltip-description">{{ $recipe->description }}</p>
        </div>
    </div>
@empty
    <p class="no-results">Nem található recept a megadott szűrési feltételekkel.</p>
@endforelse