{{-- The recipe's "free from" labels (e.g. "Gluténmentes"). Renders nothing if there are none.
     Variables: $freeFroms, $modifier (CSS class for the desktop or the mobile placement). --}}
@if (count($freeFroms) > 0)
    <div class="allergens-box {{ $modifier }}">
        <ul class="allergens-list">
            @foreach ($freeFroms as $freeFrom)
                <li class="allergen-tag">
                    <img src="{{ asset($freeFrom->thumbnail) }}" alt="" class="category-icon">
                    {{ $freeFrom->label }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
