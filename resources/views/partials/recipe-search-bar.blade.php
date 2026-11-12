{{-- Search bar, active filters, Filters and Sort modals in one form (a single submit sends everything).
     The modals are popovers: the browser opens and closes them, no JavaScript needed.
     Variables: $searchAction, $searchPlaceholder (optional), $activeFilterCount and the category lists. --}}
@php
    $filterGroups = [
        ['param' => 'meal_time', 'title' => 'Étkezés', 'items' => $mealTimes],
        ['param' => 'food_type', 'title' => 'Ételtípus', 'items' => $foodTypes],
        ['param' => 'diet', 'title' => 'Diéta', 'items' => $diets],
        ['param' => 'free_from', 'title' => 'Érzékenység', 'items' => $freeFroms],
        ['param' => 'cuisine', 'title' => 'Konyha', 'items' => $cuisines],
    ];
    $urlWithoutFilters = request()->fullUrlWithoutQuery(['meal_time', 'food_type', 'diet', 'free_from', 'cuisine', 'page']) . '#recipes';
@endphp
<form action="{{ $searchAction }}#recipes" method="GET" id="searchForm">
    <div class="search-bar">
        <div class="search-row">
            <div class="search-input-group">
                <i data-lucide="search" class="search-input-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder ?? 'Receptek keresése...' }}" class="search-input" autofocus>
            </div>
            <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
            <button type="button" class="btn-filters {{ $activeFilterCount > 0 ? 'has-filters' : '' }}" popovertarget="filtersModal">
                <i data-lucide="filter"></i> Szűrők
                @if ($activeFilterCount > 0)
                    <span class="filter-count">{{ $activeFilterCount }}</span>
                @endif
            </button>
            <span class="search-divider"></span>
            <button type="button" class="btn-sort" popovertarget="sortModal"><i data-lucide="arrow-up-down"></i> Rendezés</button>
        </div>
    </div>

    @if ($activeFilterCount > 0)
        <div class="active-filters">
            @foreach ($filterGroups as $group)
                @foreach ($group['items'] as $item)
                    @if (in_array($item->id, (array) request($group['param'])))
                        @php
                            $otherValues = array_values(array_diff((array) request($group['param']), [$item->id]));
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery([$group['param'] => $otherValues, 'page' => null]) }}#recipes" class="active-filter" title="Szűrő eltávolítása">
                            {{ $group['param'] === 'free_from' ? $item->name . ' nélkül' : $item->name }} ✕
                        </a>
                    @endif
                @endforeach
            @endforeach
            @if ($activeFilterCount > 1)
                <a href="{{ $urlWithoutFilters }}" class="active-filters-clear">Összes törlése</a>
            @endif
        </div>
    @endif

    <div id="filtersModal" class="modal-content" popover>
        <div class="modal-header">
            <h3>Szűrők</h3>
            <button type="button" class="close-btn" popovertarget="filtersModal" popovertargetaction="hide">&times;</button>
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
            <a href="{{ $urlWithoutFilters }}" class="btn-reset">Szűrők törlése</a>
            <button type="submit" class="btn-apply">Szűrés alkalmazása</button>
        </div>
    </div>

    <div id="sortModal" class="modal-content modal-small" popover>
        <div class="modal-header">
            <h3>Rendezés</h3>
            <button type="button" class="close-btn" popovertarget="sortModal" popovertargetaction="hide">&times;</button>
        </div>
        <div class="modal-body">
            <div class="filter-options">
                @foreach (['date' => 'Legújabb', 'popularity' => 'Legnépszerűbb'] as $value => $label)
                    <label class="filter-chip">
                        <input type="radio" name="sort" value="{{ $value }}"
                            {{ request('sort', 'date') == $value ? 'checked' : '' }}>
                        <span>
                            {{ $label }}
                            @if ($value === 'date')
                                <small class="chip-note">(alapértelmezett)</small>
                            @endif
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn-apply">Rendezés alkalmazása</button>
        </div>
    </div>
</form>
