{{-- The recipe's "free from" labels (e.g. "Gluténmentes"). Renders nothing if there are none.
     Variables: $freeFroms, $modifier (CSS class for the desktop or the mobile placement). --}}
@if ($freeFroms->isNotEmpty())
    <div class="allergens-box {{ $modifier }}">
        <ul class="allergens-list">
            @foreach ($freeFroms as $freeFrom)
                <li class="allergen-tag">
                    <span class="category-icon allergen-icon" style="--allergen-icon: url('{{ asset($freeFrom->thumbnail) }}');"></span>
                    {{ $freeFrom->free_label }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
