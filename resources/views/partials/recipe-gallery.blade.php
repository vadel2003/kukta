@forelse ($recipes as $recipe)
    <div class="recipe-card">
        <div class="card-image-wrapper">
            <img src="{{ $recipe->thumbnail ? asset($recipe->thumbnail) : asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
            @auth
                <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="card-favorite-form">
                    @csrf
                    <button type="submit" class="btn-favorite-card {{ in_array($recipe->id, $favoriteIds) ? 'favorited' : '' }}" title="{{ in_array($recipe->id, $favoriteIds) ? 'Kedvenc törlése' : 'Kedvencnek jelölöm' }}">
                        {{ in_array($recipe->id, $favoriteIds) ? '❤️' : '🤍' }}
                    </button>
                    <span class="favorite-badge">{{ $recipe->favorites_count }}</span>
                </form>
            @endauth
        </div>
        <h2>{{ $recipe->title }}</h2>

        {{-- ⭐ Csillagos értékelés (statikus placeholder, backend később) --}}
        <div class="star-rating">
            <span class="stars">★★★★☆</span>
            <span class="rating-number">4.2</span>
            <span class="review-count">(12)</span>
        </div>

        <p class="recipe-description">{{ Str::limit($recipe->description, 100) }}</p>
        <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Megtekintés</a>

        {{-- Hover tooltip: a recept teljes leírása --}}
        <div class="card-tooltip">
            <p class="tooltip-description">{{ $recipe->description }}</p>
        </div>
    </div>
@empty
    <p class="no-results">Nem található recept a megadott szűrési feltételekkel.</p>
@endforelse