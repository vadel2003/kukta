{{--
    Kereső sáv + aktív szűrők + Szűrők/Rendezés modal - a főoldal, a Saját receptek
    és a Kedvenc receptek oldal is ezt használja, hogy ne kelljen 3x lemásolni.
    Elvárt változók: $searchAction (route), $mealTimes, $foodTypes, $diets,
    $allergens, $cuisines. Opcionális: $searchPlaceholder.

    FONTOS: a modalok tartalma (checkboxok, rádiógombok) szándékosan a <form> ELEMEN
    BELÜL van - így egyetlen submit mindent (keresőszó + szűrők + rendezés) egyszerre küld el.
    A modalok viszont a .search-bar dobozon KÍVÜL vannak: mobilon és görgetéskor a .search-bar
    el van rejtve, és egy rejtett szülőben a modal sem tudna megjelenni.
--}}
@php
    // Szűrőcsoportok: URL-paraméter => [cím, elemek]. Egy ciklus rajzolja ki mind az ötöt.
    $filterGroups = [
        'meal_time' => ['Étkezés', $mealTimes],
        'food_type' => ['Ételtípus', $foodTypes],
        'diet' => ['Diéta', $diets],
        'allergen' => ['Érzékenység', $allergens],
        'cuisine' => ['Konyha', $cuisines],
    ];
@endphp
<form action="{{ $searchAction }}#recipes" method="GET" id="searchForm">
    <div class="search-bar">
        <div class="search-row">
            <div class="search-input-group">
                <i data-lucide="search" class="search-input-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder ?? 'Receptek keresése kulcsszó szerint...' }}" class="search-input" autofocus>
            </div>
            <span class="search-divider"></span>
            <button type="button" class="btn-filters" onclick="openModal('filtersModal')"><i data-lucide="filter"></i> Szűrők <span class="filter-count" hidden></span></button>
            <span class="search-divider"></span>
            <button type="button" class="btn-sort" onclick="openModal('sortModal')"><i data-lucide="arrow-up-down"></i> Rendezés</button>
            <button type="submit" class="btn-search"><i data-lucide="search"></i> Keresés</button>
        </div>
    </div>

    {{-- Aktív szűrők (JS tölti ki a bepipált checkboxokból) --}}
    <div id="activeFilters" class="active-filters"></div>

    <!-- Szűrők Modal -->
    <div id="filtersModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Szűrők</h3>
                <button type="button" class="close-btn" onclick="closeModal('filtersModal')">&times;</button>
            </div>
            <div class="modal-body">
                @foreach ($filterGroups as $param => [$title, $items])
                    <div class="filter-group">
                        <h4>{{ $title }}</h4>
                        @if ($param === 'allergen')
                            <p class="filter-hint">Jelöld be, amit a recept <strong>nem</strong> tartalmazhat.</p>
                        @endif
                        <div class="filter-options">
                            @foreach ($items as $item)
                                {{-- data-label: ez a szöveg jelenik meg az aktív szűrő címkéjén --}}
                                <label class="filter-chip">
                                    <input type="checkbox" name="{{ $param }}[]" value="{{ $item->id }}"
                                        data-label="{{ $param === 'allergen' ? $item->name . ' nélkül' : $item->name }}"
                                        {{ in_array($item->id, (array) request($param)) ? 'checked' : '' }}>
                                    <span>{{ $item->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-reset" onclick="clearFilterCheckboxes()">Szűrők törlése</button>
                <button type="submit" class="btn-apply">Szűrés alkalmazása</button>
            </div>
        </div>
    </div>

    <!-- Rendezés Modal - egy opcióra kattintva azonnal rendez (onchange -> requestSubmit) -->
    <div id="sortModal" class="modal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h3>Rendezés</h3>
                <button type="button" class="close-btn" onclick="closeModal('sortModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="filter-options">
                    @foreach (['relevance' => 'Relevancia', 'date' => 'Legújabb', 'popularity' => 'Legnépszerűbb'] as $value => $label)
                        <label class="filter-chip">
                            <input type="radio" name="sort" value="{{ $value }}" onchange="this.form.requestSubmit()"
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
