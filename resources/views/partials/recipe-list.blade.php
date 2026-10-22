{{-- Recipe list: search, filters, sorting, recipe cards and the "load more" button.
     Variables: $searchAction, $searchPlaceholder (optional), $recipes, $favoriteIds and the category lists. --}}
<section id="recipes" class="recipes-section">
    @include('partials.recipe-search-bar')

    <div id="recipe-gallery" class="recipe-gallery">
        @include('partials.recipe-gallery')
    </div>

    @if ($recipes->hasMorePages())
        <button id="load-more-btn" class="btn-load-more">További receptek betöltése...</button>
    @endif

    <div id="loading-spinner" class="loading-spinner" style="display: none;">
        <div class="spinner"></div>
        <p>Betöltés...</p>
    </div>
</section>
