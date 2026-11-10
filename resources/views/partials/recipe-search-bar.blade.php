{{-- Search bar, active filters, Filters and Sort modals in one form (a single submit sends everything).
     Variables: $searchAction, $searchPlaceholder (optional), $mealTimes, $foodTypes, $diets, $freeFroms, $cuisines. --}}
@php
    $filterGroups = [
        ['param' => 'meal_time', 'title' => 'Étkezés', 'items' => $mealTimes],
        ['param' => 'food_type', 'title' => 'Ételtípus', 'items' => $foodTypes],
        ['param' => 'diet', 'title' => 'Diéta', 'items' => $diets],
        ['param' => 'free_from', 'title' => 'Érzékenység', 'items' => $freeFroms],
        ['param' => 'cuisine', 'title' => 'Konyha', 'items' => $cuisines],
    ];
@endphp
<form action="{{ $searchAction }}#recipes" method="GET" id="searchForm">
    <div class="search-bar">
        <div class="search-row">
            <div class="search-input-group">
                <i data-lucide="search" class="search-input-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder ?? 'Receptek keresése kulcsszó szerint...' }}" class="search-input" autofocus>
            </div>
            <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
            <button type="button" class="btn-filters" data-modal-open="filtersModal"><i data-lucide="filter"></i> Szűrők <span class="filter-count" hidden></span></button>
            <span class="search-divider"></span>
            <button type="button" class="btn-sort" data-modal-open="sortModal"><i data-lucide="arrow-up-down"></i> Rendezés</button>
        </div>
    </div>

    <div id="activeFilters" class="active-filters"></div>

    <div id="filtersModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Szűrők</h3>
                <button type="button" class="close-btn" data-modal-close>&times;</button>
            </div>
            <div class="modal-body">
                @foreach ($filterGroups as $group)
                    <div class="filter-group">
                        <h4>{{ $group['title'] }}</h4>
                        @if ($group['param'] === 'free_from')
                            <p class="filter-hint">Jelöld be, amit a recept <strong>nem</strong> tartalmazhat.</p>
                        @endif
                        <div class="filter-options">
                            @foreach ($group['items'] as $item)
                                <label class="filter-chip">
                                    <input type="checkbox" name="{{ $group['param'] }}[]" value="{{ $item->id }}"
                                        data-label="{{ $group['param'] === 'free_from' ? $item->name . ' nélkül' : $item->name }}"
                                        {{ in_array($item->id, (array) request($group['param'])) ? 'checked' : '' }}>
                                    <span>
                                        @if ($item->thumbnail)
                                            <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                        @endif
                                        {{ $item->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-reset">Szűrők törlése</button>
                <button type="submit" class="btn-apply">Szűrés alkalmazása</button>
            </div>
        </div>
    </div>

    <div id="sortModal" class="modal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h3>Rendezés</h3>
                <button type="button" class="close-btn" data-modal-close>&times;</button>
            </div>
            <div class="modal-body">
                <div class="filter-options">
                    @foreach (['relevance' => 'Relevancia', 'date' => 'Legújabb', 'popularity' => 'Legnépszerűbb'] as $value => $label)
                        <label class="filter-chip">
                            <input type="radio" name="sort" value="{{ $value }}"
                                {{ request('sort', 'relevance') == $value ? 'checked' : '' }}>
                            <span>
                                {{ $label }}
                                @if ($value === 'relevance')
                                    <small class="chip-note">(alapértelmezett)</small>
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>
