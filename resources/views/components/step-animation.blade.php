{{-- Lépéskategória Lottie animációja. Használat: <x-step-animation :category="$step->stepCategory" />
     Csak egy üres div-et renderel, az animációt a JS tölti bele a data-src alapján.
     Ha nincs kategória (vagy hozzá animáció), nem renderel semmit. --}}
@props(['category'])

@php
    $file = $category?->gif_filename ? 'lottie/' . $category->gif_filename : null;
@endphp

@if ($file && file_exists(public_path($file)))
    {{-- ?v=filemtime: a fájl hosszú ideig cache-elődik, így ha lecseréled, új URL-t kap --}}
    <div class="step-animation"
         data-src="{{ asset($file) }}?v={{ filemtime(public_path($file)) }}"
         role="img"
         aria-label="{{ $category->name }}"></div>
@endif
