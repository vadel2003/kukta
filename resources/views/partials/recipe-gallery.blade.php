@forelse ($recipes as $recipe)
    <div class="recipe-card">
        <div class="card-image-wrapper">
            <img src="{{ $recipe->thumbnail_url }}" alt="{{ $recipe->title }}" class="recipe-image">
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
                <span class="icon-assistant" aria-hidden="true"></span>
            </a>
            @if (!empty($showOwnerActions))
                {{-- Saját receptek: külön sorban, a kártya stílusához illő keretes gombok --}}
                <div class="card-owner-actions">
                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-card-edit">
                        <i data-lucide="pencil"></i> Szerkesztés
                    </a>
                    {{-- data-confirm: beküldés előtt a közös megerősítő ablak jön fel (layouts/app.blade.php) --}}
                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST"
                        data-confirm-title="Biztosan törlöd a receptet?"
                        data-confirm="A(z) „{{ $recipe->title }}” recept véglegesen törlődik. Ez a művelet nem visszavonható.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-card-delete">
                            <i data-lucide="trash-2"></i> Törlés
                        </button>
                    </form>
                </div>
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