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
