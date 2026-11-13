@extends('layouts.app')

@section('title', 'Kukta asszisztens – ' . $recipe->title)
@section('bodyClass', 'assistant-page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/assistant/assistant.css') }}">
@endsection

@section('content')
    @php
        // 5 ingredients fit on one screen
        $ingredientPages = ceil($recipe->ingredients->count() / 5);
    @endphp

    <div class="assistant">
        <a href="{{ route('recipes.show', $recipe->id) }}" class="assistant-close" title="Kilépés az asszisztensből"><i data-lucide="x"></i></a>

        <section class="assistant-screen is-active">
            <div class="assistant-intro" style="background-image: url('{{ asset($recipe->thumbnail) }}');">
                <div class="assistant-intro-content">
                    <div class="assistant-intro-card assistant-greeting-card">
                        <div class="assistant-figure-slot">
                            <div class="assistant-figure">
                                <img src="{{ asset('images/assistant-figure.svg') }}" alt="Kukta asszisztens, a borsó főzősegéd" class="assistant-figure-image">
                                <p class="assistant-figure-bubble">Szia!<br>Én vagyok az asszisztensed.<br>Induljon a főzés!</p>
                            </div>
                        </div>
                    </div>
                    <div class="assistant-intro-card assistant-intro-overlay">
                        <h1>{{ $recipe->title }}</h1>
                        <p>{{ $recipe->description }}</p>
                    </div>
                </div>
            </div>
        </section>

        @foreach ($recipe->ingredients->chunk(5) as $chunk)
            <section class="assistant-screen">
                <div class="assistant-ingredients">
                    <div class="content-card assistant-ingredients-card">
                        <h2 class="assistant-heading">
                            Hozzávalók
                            @if ($ingredientPages > 1)
                                ({{ $loop->iteration }}/{{ $ingredientPages }})
                            @endif
                        </h2>
                        <ul class="ingredient-grid">
                            @foreach ($chunk as $ingredient)
                                @php
                                    $quantity = (float) $ingredient->pivot->quantity;
                                @endphp
                                <li class="assistant-ingredient">
                                    <span class="assistant-ingredient-qty">{{ str_replace('.', ',', $quantity) }} {{ $units[$ingredient->pivot->unit] }}</span>
                                    <span class="assistant-ingredient-name">{{ $ingredient->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endforeach

        @foreach ($recipe->steps as $step)
            <section class="assistant-screen">
                <div class="assistant-step">
                    <div class="content-card assistant-step-card">
                        <div class="assistant-step-number">{{ $loop->iteration }}</div>
                        <img src="{{ asset($step->stepCategory->thumbnail) }}" alt="{{ $step->stepCategory->name }}" class="step-image">
                        <p class="assistant-step-text">{{ $step->description }}</p>
                    </div>
                </div>
            </section>
        @endforeach

        <section class="assistant-screen assistant-screen-finish">
            <div class="assistant-finish">
                <div class="content-card assistant-finish-card">
                    <div class="assistant-figure-slot">
                        <div class="assistant-figure">
                            <img src="{{ asset('images/assistant-figure.svg') }}" alt="Kukta asszisztens, a borsó főzősegéd" class="assistant-figure-image">
                            <p class="assistant-figure-bubble">Jó étvágyat!</p>
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST">
                            @csrf
                            <div class="assistant-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="submit" name="score" value="{{ $i }}" class="assistant-star {{ $userRating && $i <= $userRating->score ? 'filled' : '' }}" title="{{ $i }} csillag">★</button>
                                @endfor
                            </div>
                            <p class="assistant-rating-status">
                                @if ($userRating)
                                    A te értékelésed: {{ $userRating->score }} csillag
                                @else
                                    Értékeld a receptet!
                                @endif
                            </p>
                        </form>
                    @else
                        <p class="assistant-rating-status">
                            Az értékeléshez <a href="{{ route('recipes.rate.login', $recipe->id) }}">jelentkezz be</a>
                        </p>
                    @endauth

                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-cook btn-cook-primary">Vissza a recepthez</a>
                </div>
            </div>
        </section>

        <div class="assistant-nav-zone assistant-nav-zone-prev" id="prevZone">
            <button type="button" id="prevButton" class="btn-assistant-nav" title="Vissza"><i data-lucide="chevron-left"></i></button>
        </div>
        <div class="assistant-nav-zone assistant-nav-zone-next" id="nextZone">
            <button type="button" id="nextButton" class="btn-assistant-nav" title="Tovább"><i data-lucide="chevron-right"></i></button>
        </div>
        <span class="assistant-progress" id="progress"></span>
    </div>

    <script>
        const screens = document.querySelectorAll('.assistant-screen');
        const prevButton = document.getElementById('prevButton');
        const nextZone = document.getElementById('nextZone');
        const progress = document.getElementById('progress');
        let current = 0;
        let touchStartX = 0;
        let touchStartY = 0;

        // shows the screen with the given number, the others are hidden
        function showScreen(index) {
            current = index;

            for (let i = 0; i < screens.length; i++) {
                if (i == current) {
                    screens[i].classList.add('is-active');
                } else {
                    screens[i].classList.remove('is-active');
                }
            }

            prevButton.disabled = current == 0;
            if (current == screens.length - 1) {
                nextZone.style.visibility = 'hidden';
            } else {
                nextZone.style.visibility = 'visible';
            }
            progress.textContent = (current + 1) + ' / ' + screens.length;
        }

        function prevScreen() {
            if (current > 0) {
                showScreen(current - 1);
            }
        }

        function nextScreen() {
            if (current < screens.length - 1) {
                showScreen(current + 1);
            }
        }

        // the whole side area is clickable, not just the button
        document.getElementById('prevZone').addEventListener('click', prevScreen);
        nextZone.addEventListener('click', nextScreen);

        document.addEventListener('keydown', function (event) {
            if (event.key == 'ArrowLeft') {
                prevScreen();
            }
            if (event.key == 'ArrowRight') {
                nextScreen();
            }
            if (event.key == 'Escape') {
                window.location.href = '{{ route('recipes.show', $recipe->id) }}';
            }
        });

        // swiping on mobile
        document.addEventListener('touchstart', function (event) {
            touchStartX = event.changedTouches[0].clientX;
            touchStartY = event.changedTouches[0].clientY;
        });

        document.addEventListener('touchend', function (event) {
            const deltaX = event.changedTouches[0].clientX - touchStartX;
            const deltaY = event.changedTouches[0].clientY - touchStartY;

            // vertical scrolling does not change the screen
            if (Math.abs(deltaY) > Math.abs(deltaX)) {
                return;
            }

            if (deltaX < -50) {
                nextScreen();
            } else if (deltaX > 50) {
                prevScreen();
            }
        });

        showScreen(0);
    </script>
@endsection
