{{-- Mitől mentes a recept: kiemelt infósáv, hogy egy pillantással eldönthető legyen,
     ehető-e (pl. allergiásoknak). A címkén a teljes szó áll ("Gluténmentes",
     l. FreeFrom::free_label), különben a sima "Glutén" azt is jelenthetné,
     hogy a recept TARTALMAZ glutént. Ha semmitől sem mentes, nem jelenik meg.
     A show.blade.php kétszer húzza be (desktop / mobil hely), a $modifier osztály
     dönti el, melyik példány látszik az adott képernyőn. --}}
@if ($freeFroms->isNotEmpty())
    <div class="allergens-box {{ $modifier }}">
        <ul class="allergens-list">
            @foreach ($freeFroms as $freeFrom)
                <li class="allergen-tag">
                    <img src="{{ asset($freeFrom->thumbnail) }}" alt="" class="category-icon">
                    {{ $freeFrom->free_label }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
