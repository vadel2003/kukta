{{-- Recipe list: search, filters, sorting, recipe cards and the page links.
     Variables: $searchAction, $searchPlaceholder (optional), $recipes, $favoriteIds and the category lists. --}}
<section id="recipes" class="recipes-section">
    @include('partials.recipe-search-bar')

    <div class="recipe-gallery">
        @include('partials.recipe-gallery')
    </div>

    @if ($recipes->hasPages())
        <nav class="pagination">
            @if ($recipes->previousPageUrl())
                <a href="{{ $recipes->previousPageUrl() }}#recipes" class="btn-outline">« Előző</a>
            @endif
            <span>{{ $recipes->currentPage() }} / {{ $recipes->lastPage() }} oldal</span>
            @if ($recipes->nextPageUrl())
                <a href="{{ $recipes->nextPageUrl() }}#recipes" class="btn-outline">Következő »</a>
            @endif
        </nav>
    @endif
</section>
