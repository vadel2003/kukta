{{-- Recipe cards. Variables: $recipes, $favoriteIds, $showOwnerActions (optional). --}}
@forelse ($recipes as $recipe)
    @php
        $isFavorite = in_array($recipe->id, $favoriteIds);
        $average = $recipe->ratings_avg_score ?? 0;
    @endphp
    <div class="recipe-card" id="recipe-{{ $recipe->id }}">
        <div class="card-image-wrapper">
            <a href="{{ route('recipes.show', $recipe->id) }}">
                <img src="{{ asset($recipe->thumbnail) }}" alt="{{ $recipe->title }}" class="recipe-image">
            </a>
            @auth
                <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="card-favorite-form">
                    @csrf
                    @if ($isFavorite)
                        <button type="submit" class="btn-favorite-card favorited" title="Kedvenc törlése">
                            <i data-lucide="heart"></i>
                        </button>
                    @else
                        <button type="submit" class="btn-favorite-card" title="Kedvencnek jelölöm">
                            <i data-lucide="heart"></i>
                        </button>
                    @endif
                    <span class="favorite-badge">{{ $recipe->favorites_count }}</span>
                </form>
            @endauth
        </div>
        <div class="card-title-row">
            <h2><a href="{{ route('recipes.show', $recipe->id) }}">{{ $recipe->title }}</a></h2>
            <a href="{{ route('recipes.assistant', $recipe->id) }}" class="btn-spoon" title="Kukta asszisztens">
                <span class="icon-assistant"></span>
            </a>
        </div>

        <div class="star-rating">
            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($average))
                        <span class="filled">★</span>
                    @else
                        <span>★</span>
                    @endif
                @endfor
            </span>
            <span class="rating-number">{{ number_format($average, 1) }}</span>
            <span class="review-count">({{ $recipe->ratings_count }})</span>
        </div>

        <p class="recipe-description" title="{{ $recipe->description }}">{{ Str::limit($recipe->description, 100) }}</p>
        <div class="card-actions">
            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-view">Részletek</a>
            <a href="{{ route('recipes.assistant', $recipe->id) }}" class="btn-spoon" title="Kukta asszisztens">
                <span class="icon-assistant"></span>
            </a>
            @if (isset($showOwnerActions))
                <div class="card-owner-actions">
                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-card-edit">
                        <i data-lucide="pencil"></i> <span class="btn-text">Szerkesztés</span>
                    </a>
                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" data-confirm="Biztosan törlöd a receptet? A(z) „{{ $recipe->title }}” recept véglegesen törlődik. Ez a művelet nem visszavonható.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-card-delete">
                            <i data-lucide="trash-2"></i> <span class="btn-text">Törlés</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@empty
    <p class="no-results">Nem található recept a megadott szűrési feltételekkel.</p>
@endforelse
