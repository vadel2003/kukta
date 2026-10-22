{{-- Lottie animation of a step category: <x-step-animation :category="$step->stepCategory" />
     An empty div; the JS loads the animation from data-src. Renders nothing if the category has no animation. --}}
@props(['category'])

@php
    $file = $category?->gif_filename ? 'lottie/' . $category->gif_filename : null;
@endphp

@if ($file && file_exists(public_path($file)))
    <div class="step-animation"
         data-src="{{ asset($file) }}?v={{ filemtime(public_path($file)) }}"
         role="img"
         aria-label="{{ $category->name }}"></div>
@endif
