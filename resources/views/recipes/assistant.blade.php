@extends('layouts.app')

@section('title', 'Kukta asszisztens – ' . $recipe->title)
@section('bodyClass', 'assistant_page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/assistant.css') }}">
@endsection

@section('content')
    @php
        $ingredientPages = ceil($recipe->ingredients->count() / 5);
    @endphp

    <div class="assistant">
        <a href="{{ route('recipes.show', $recipe->id) }}" class="exit_button" title="Kilépés az asszisztensből"><i data-lucide="x"></i></a>

        <section class="screen active">
            <div class="intro" style="background-image: url('{{ asset($recipe->thumbnail) }}');">
                <div class="intro_inside">
                    <div class="white_box greeting">
                        <div class="mascot_box">
                            <div class="mascot">
                                <img src="{{ asset('images/assistant-figure.svg') }}" alt="Kukta asszisztens, a borsó főzősegéd" class="mascot_image">
                                <p class="speech_bubble">Szia!<br>Én vagyok az asszisztensed.<br>Induljon a főzés!</p>
                            </div>
                        </div>
                    </div>
                    <div class="white_box intro_text">
                        <h1>{{ $recipe->title }}</h1>
                        <p>{{ $recipe->description }}</p>
                    </div>
                </div>
            </div>
        </section>

        @foreach ($recipe->ingredients->chunk(5) as $chunk)
            <section class="screen">
                <div class="ingredients_page">
                    <div class="box ingredients_box">
                        <h2 class="big_title">
                            Hozzávalók
                            @if ($ingredientPages > 1)
                                ({{ $loop->iteration }}/{{ $ingredientPages }})
                            @endif
                        </h2>
                        <ul class="ingredient_grid">
                            @foreach ($chunk as $ingredient)
                                @php
                                    $quantity = (float) $ingredient->pivot->quantity;
                                @endphp
                                <li class="ingredient_box">
                                    <span class="amount">{{ str_replace('.', ',', $quantity) }} {{ $units[$ingredient->pivot->unit] }}</span>
                                    <span class="ingredient_text">{{ $ingredient->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endforeach

        @foreach ($recipe->steps as $step)
            <section class="screen">
                <div class="step_page">
                    <div class="box step_box">
                        <div class="big_number">{{ $loop->iteration }}</div>
                        <img src="{{ asset($step->stepCategory->thumbnail) }}" alt="{{ $step->stepCategory->name }}" class="step_image">
                        <p class="step_big_text">{{ $step->description }}</p>
                    </div>
                </div>
            </section>
        @endforeach

        <section class="screen last_screen">
            <div class="finish_page">
                <div class="box finish_box">
                    <div class="mascot_box">
                        <div class="mascot">
                            <img src="{{ asset('images/assistant-figure.svg') }}" alt="Kukta asszisztens, a borsó főzősegéd" class="mascot_image">
                            <p class="speech_bubble">Jó étvágyat!</p>
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST">
                            @csrf
                            <div class="rate_stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="submit" name="score" value="{{ $i }}" class="rate_star @if ($userRating && $i <= $userRating->score) filled @endif" title="{{ $i }} csillag">★</button>
                                @endfor
                            </div>
                            <p class="rate_text">
                                @if ($userRating)
                                    A te értékelésed: {{ $userRating->score }} csillag
                                @else
                                    Értékeld a receptet!
                                @endif
                            </p>
                        </form>
                    @else
                        <p class="rate_text">
                            Az értékeléshez <a href="{{ route('recipes.rate.login', $recipe->id) }}">jelentkezz be</a>
                        </p>
                    @endauth

                    <a href="{{ route('recipes.show', $recipe->id) }}" class="big_button orange">Vissza a recepthez</a>
                </div>
            </div>
        </section>

        <div class="side left_side" id="prev_side">
            <button type="button" id="prev_button" class="arrow_button" title="Vissza"><i data-lucide="chevron-left"></i></button>
        </div>
        <div class="side right_side" id="next_side">
            <button type="button" id="next_button" class="arrow_button" title="Tovább"><i data-lucide="chevron-right"></i></button>
        </div>
        <span class="step_counter" id="progress"></span>
    </div>

    <script>
        const screens = document.querySelectorAll('.screen');
        const prevButton = document.getElementById('prev_button');
        const nextZone = document.getElementById('next_side');
        const progress = document.getElementById('progress');
        let current = 0;
        let touchStartX = 0;
        let touchStartY = 0;

        function showScreen(index) {
            current = index;

            for (let i = 0; i < screens.length; i++) {
                if (i == current) {
                    screens[i].classList.add('active');
                } else {
                    screens[i].classList.remove('active');
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

        document.getElementById('prev_side').addEventListener('click', prevScreen);
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

        document.addEventListener('touchstart', function (event) {
            touchStartX = event.changedTouches[0].clientX;
            touchStartY = event.changedTouches[0].clientY;
        });

        document.addEventListener('touchend', function (event) {
            const deltaX = event.changedTouches[0].clientX - touchStartX;
            const deltaY = event.changedTouches[0].clientY - touchStartY;

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
