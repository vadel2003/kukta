@extends('layouts.app')

@section('title', 'Saját receptek')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="column">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>Saját receptek</h1>
        </div>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if (!$hasAnyRecipes)
            <p>Még nem töltöttél fel receptet. <a href="{{ route('recipes.create') }}">Tölts fel egyet most!</a></p>
        @else
            <section id="recipes" class="recipes">
                @php
                    $urlWithoutFilters = route('recipes.my') . '?search=' . urlencode(request('search')) . '&sort=' . request('sort', 'date') . '#recipes';
                @endphp
                <form action="{{ route('recipes.my') }}#recipes" method="GET">
                    <div class="search_bar">
                        <div class="search_row">
                            <div class="search_box">
                                <i data-lucide="search" class="search_icon"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Saját receptek keresése..." class="search_input" autofocus>
                            </div>
                            <button type="submit" class="search_button"><i data-lucide="search"></i> <span class="button_text">Keresés</span></button>
                            <button type="button" class="filter_button @if ($activeFilterCount > 0) filtered @endif" popovertarget="filter_popup">
                                <i data-lucide="filter"></i> <span class="button_text">Szűrők</span>
                                @if ($activeFilterCount > 0)
                                    <span class="filter_number">{{ $activeFilterCount }}</span>
                                @endif
                            </button>
                            <span class="search_line"></span>
                            <button type="button" class="sort_button" popovertarget="sort_popup"><i data-lucide="arrow-up-down"></i> <span class="button_text">Rendezés</span></button>
                        </div>
                    </div>

                    @if ($activeFilterCount > 0)
                        <div class="selected_filters">
                            @foreach ($mealTimes as $item)
                                @if (in_array($item->id, (array) request('meal_time')))
                                    @php
                                        $otherValues = [];
                                        foreach ((array) request('meal_time') as $value) {
                                            if ($value != $item->id) {
                                                $otherValues[] = $value;
                                            }
                                        }
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['meal_time' => $otherValues, 'page' => null]) }}#recipes" class="selected_filter" title="Szűrő eltávolítása">
                                        {{ $item->name }} ✕
                                    </a>
                                @endif
                            @endforeach
                            @foreach ($foodTypes as $item)
                                @if (in_array($item->id, (array) request('food_type')))
                                    @php
                                        $otherValues = [];
                                        foreach ((array) request('food_type') as $value) {
                                            if ($value != $item->id) {
                                                $otherValues[] = $value;
                                            }
                                        }
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['food_type' => $otherValues, 'page' => null]) }}#recipes" class="selected_filter" title="Szűrő eltávolítása">
                                        {{ $item->name }} ✕
                                    </a>
                                @endif
                            @endforeach
                            @foreach ($diets as $item)
                                @if (in_array($item->id, (array) request('diet')))
                                    @php
                                        $otherValues = [];
                                        foreach ((array) request('diet') as $value) {
                                            if ($value != $item->id) {
                                                $otherValues[] = $value;
                                            }
                                        }
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['diet' => $otherValues, 'page' => null]) }}#recipes" class="selected_filter" title="Szűrő eltávolítása">
                                        {{ $item->name }} ✕
                                    </a>
                                @endif
                            @endforeach
                            @foreach ($freeFroms as $item)
                                @if (in_array($item->id, (array) request('free_from')))
                                    @php
                                        $otherValues = [];
                                        foreach ((array) request('free_from') as $value) {
                                            if ($value != $item->id) {
                                                $otherValues[] = $value;
                                            }
                                        }
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['free_from' => $otherValues, 'page' => null]) }}#recipes" class="selected_filter" title="Szűrő eltávolítása">
                                        {{ $item->name }} nélkül ✕
                                    </a>
                                @endif
                            @endforeach
                            @foreach ($cuisines as $item)
                                @if (in_array($item->id, (array) request('cuisine')))
                                    @php
                                        $otherValues = [];
                                        foreach ((array) request('cuisine') as $value) {
                                            if ($value != $item->id) {
                                                $otherValues[] = $value;
                                            }
                                        }
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['cuisine' => $otherValues, 'page' => null]) }}#recipes" class="selected_filter" title="Szűrő eltávolítása">
                                        {{ $item->name }} ✕
                                    </a>
                                @endif
                            @endforeach
                            @if ($activeFilterCount > 1)
                                <a href="{{ $urlWithoutFilters }}" class="clear_filters">Összes törlése</a>
                            @endif
                        </div>
                    @endif

                    <div id="filter_popup" class="popup" popover>
                        <div class="popup_top">
                            <h3>Szűrők</h3>
                            <button type="button" class="close_button" popovertarget="filter_popup" popovertargetaction="hide">&times;</button>
                        </div>
                        <div class="popup_middle">
                            <div class="filter_group">
                                <h4>Étkezés</h4>
                                <div class="filter_list">
                                    @foreach ($mealTimes as $item)
                                        <label class="filter_option">
                                            <input type="checkbox" name="meal_time[]" value="{{ $item->id }}"
                                                @if (in_array($item->id, (array) request('meal_time'))) checked @endif>
                                            <span>
                                                @if ($item->thumbnail)
                                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                                @endif
                                                {{ $item->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="filter_group">
                                <h4>Ételtípus</h4>
                                <div class="filter_list">
                                    @foreach ($foodTypes as $item)
                                        <label class="filter_option">
                                            <input type="checkbox" name="food_type[]" value="{{ $item->id }}"
                                                @if (in_array($item->id, (array) request('food_type'))) checked @endif>
                                            <span>
                                                @if ($item->thumbnail)
                                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                                @endif
                                                {{ $item->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="filter_group">
                                <h4>Diéta</h4>
                                <div class="filter_list">
                                    @foreach ($diets as $item)
                                        <label class="filter_option">
                                            <input type="checkbox" name="diet[]" value="{{ $item->id }}"
                                                @if (in_array($item->id, (array) request('diet'))) checked @endif>
                                            <span>
                                                @if ($item->thumbnail)
                                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                                @endif
                                                {{ $item->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="filter_group">
                                <h4>Érzékenység</h4>
                                <p class="filter_text">Jelöld be, amit a recept <strong>nem</strong> tartalmazhat.</p>
                                <div class="filter_list">
                                    @foreach ($freeFroms as $item)
                                        <label class="filter_option">
                                            <input type="checkbox" name="free_from[]" value="{{ $item->id }}"
                                                @if (in_array($item->id, (array) request('free_from'))) checked @endif>
                                            <span>
                                                @if ($item->thumbnail)
                                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                                @endif
                                                {{ $item->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="filter_group">
                                <h4>Konyha</h4>
                                <div class="filter_list">
                                    @foreach ($cuisines as $item)
                                        <label class="filter_option">
                                            <input type="checkbox" name="cuisine[]" value="{{ $item->id }}"
                                                @if (in_array($item->id, (array) request('cuisine'))) checked @endif>
                                            <span>
                                                @if ($item->thumbnail)
                                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                                @endif
                                                {{ $item->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="popup_bottom">
                            <a href="{{ $urlWithoutFilters }}" class="reset_button">Szűrők törlése</a>
                            <button type="submit" class="apply_button">Szűrés alkalmazása</button>
                        </div>
                    </div>

                    <div id="sort_popup" class="popup small_popup" popover>
                        <div class="popup_top">
                            <h3>Rendezés</h3>
                            <button type="button" class="close_button" popovertarget="sort_popup" popovertargetaction="hide">&times;</button>
                        </div>
                        <div class="popup_middle">
                            <div class="filter_list">
                                <label class="filter_option">
                                    <input type="radio" name="sort" value="date" @if (request('sort', 'date') == 'date') checked @endif>
                                    <span>Legújabb <small class="option_note">(alapértelmezett)</small></span>
                                </label>
                                <label class="filter_option">
                                    <input type="radio" name="sort" value="popularity" @if (request('sort') == 'popularity') checked @endif>
                                    <span>Legnépszerűbb</span>
                                </label>
                            </div>
                        </div>
                        <div class="popup_bottom">
                            <button type="submit" class="apply_button">Rendezés alkalmazása</button>
                        </div>
                    </div>
                </form>

                <div class="recipe_cards">
                    @if (count($recipes) == 0)
                        <p class="no_results">Nem található recept a megadott szűrési feltételekkel.</p>
                    @endif
                    @foreach ($recipes as $recipe)
                        @php
                            $isFavorite = in_array($recipe->id, $favoriteIds);
                            $average = 0;
                            if ($recipe->ratings_avg_score) {
                                $average = $recipe->ratings_avg_score;
                            }
                        @endphp
                        <div class="recipe_card" id="recipe_{{ $recipe->id }}">
                            <div class="card_image">
                                <a href="{{ route('recipes.show', $recipe->id) }}">
                                    <img src="{{ asset($recipe->thumbnail) }}" alt="{{ $recipe->title }}" class="recipe_image">
                                </a>
                                @auth
                                    <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="heart_box">
                                        @csrf
                                        @if ($isFavorite)
                                            <button type="submit" class="heart_button favorited" title="Kedvenc törlése">
                                                <i data-lucide="heart"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="heart_button" title="Kedvencnek jelölöm">
                                                <i data-lucide="heart"></i>
                                            </button>
                                        @endif
                                        <span class="heart_count">{{ $recipe->favorites_count }}</span>
                                    </form>
                                @endauth
                            </div>
                            <div class="card_title">
                                <h2><a href="{{ route('recipes.show', $recipe->id) }}">{{ $recipe->title }}</a></h2>
                                <a href="{{ route('recipes.assistant', $recipe->id) }}" class="spoon_button" title="Kukta asszisztens">
                                    <span class="assistant_icon"></span>
                                </a>
                            </div>

                            <div class="rating">
                                <span class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($average))
                                            <span class="filled">★</span>
                                        @else
                                            <span>★</span>
                                        @endif
                                    @endfor
                                </span>
                                <span class="rating_number">{{ number_format($average, 1) }}</span>
                                <span class="review_count">({{ $recipe->ratings_count }})</span>
                            </div>

                            <p class="recipe_description" title="{{ $recipe->description }}">{{ Str::limit($recipe->description, 100) }}</p>
                            <div class="card_buttons">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="view_button">Részletek</a>
                                <a href="{{ route('recipes.assistant', $recipe->id) }}" class="spoon_button" title="Kukta asszisztens">
                                    <span class="assistant_icon"></span>
                                </a>
                                <div class="owner_buttons">
                                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="card_edit">
                                        <i data-lucide="pencil"></i> <span class="button_text">Szerkesztés</span>
                                    </a>
                                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" data-confirm="Biztosan törlöd a receptet? A(z) „{{ $recipe->title }}” recept véglegesen törlődik. Ez a művelet nem visszavonható.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="card_delete">
                                            <i data-lucide="trash-2"></i> <span class="button_text">Törlés</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($recipes->hasPages())
                    <nav class="pagination">
                        @if ($recipes->previousPageUrl())
                            <a href="{{ $recipes->previousPageUrl() }}#recipes" class="white_button">« Előző</a>
                        @endif
                        <span>{{ $recipes->currentPage() }} / {{ $recipes->lastPage() }} oldal</span>
                        @if ($recipes->nextPageUrl())
                            <a href="{{ $recipes->nextPageUrl() }}#recipes" class="white_button">Következő »</a>
                        @endif
                    </nav>
                @endif
            </section>
        @endif
    </div>
@endsection
