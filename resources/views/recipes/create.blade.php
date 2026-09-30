@extends('layouts.app')

@section('title', isset($recipe) ? 'Recept szerkesztése' : 'Új recept')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}?v={{ filemtime(public_path('css/admin/admin.css')) }}">
@endpush

@section('content')
    @php
        $isEdit = isset($recipe);

        // Lépések előkészítése szerkesztéshez (order szerint rendezve)
        $stepValues = [];
        if ($isEdit) {
            foreach ($recipe->steps->sortBy('order') as $step) {
                $stepValues[] = [
                    'description' => $step->description,
                    'step_category_id' => $step->step_category_id,
                ];
            }
        }

        // Alapanyagok előkészítése szerkesztéshez
        $ingredientValues = [];
        if ($isEdit) {
            foreach ($recipe->ingredients as $index => $ingredient) {
                $ingredientValues[$index] = [
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                    'quantity' => $ingredient->pivot->quantity,
                    'unit' => $ingredient->pivot->unit,
                ];
            }
        }
    @endphp

    <div class="card-stack">
        <div>
            <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            <h1>{{ $isEdit ? 'Recept szerkesztése' : 'Új recept feltöltése' }}</h1>
        </div>

        @if (session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

    <form method="POST" action="{{ $isEdit ? route('recipes.update', $recipe->id) : route('recipes.store') }}" enctype="multipart/form-data" class="form-sections">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid-2col">
        <div class="content-card">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="clipboard-list"></i></span>
                Alapadatok
            </h2>

            <div class="form-group">
                <label for="title">Recept címe <span class="form-error">*</span></label>
                <div class="field-control">
                    {{-- textarea (nem input), hogy a teljes 100 karakter látsszon; az Entert a lenti JS tiltja, mert a cím egysoros adat --}}
                    <textarea name="title" id="title" rows="2" required maxlength="100" autofocus>{{ old('title', $recipe->title ?? '') }}</textarea>
                    <small class="char-counter">0 / 100</small>
                </div>
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Leírás <span class="form-error">*</span></label>
                <div class="field-control">
                    <textarea name="description" id="description" rows="18" required maxlength="1000">{{ old('description', $recipe->description ?? '') }}</textarea>
                    <small class="char-counter">0 / 1000</small>
                </div>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="prep_time">Elkészítési idő (perc) <span class="form-error">*</span></label>
                <input type="number" name="prep_time" id="prep_time" value="{{ old('prep_time', $recipe->prep_time ?? '') }}" required min="1" max="1440">
                @error('prep_time')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="difficulty">Nehézség <span class="form-error">*</span></label>
                <select name="difficulty" id="difficulty" required>
                    <option value="">-- Válassz --</option>
                    @foreach (['könnyű', 'közepes', 'nehéz'] as $level)
                        <option value="{{ $level }}" {{ old('difficulty', $recipe->difficulty ?? '') == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                    @endforeach
                </select>
                @error('difficulty')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="servings">Adag <span class="form-error">*</span></label>
                <input type="number" name="servings" id="servings" value="{{ old('servings', $recipe->servings ?? '') }}" required min="1" max="50">
                @error('servings')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="content-card">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="image"></i></span>
                Kép <span class="form-error">*</span>
            </h2>

            <div>
                <h3 class="image-section-title">Tölts fel saját képet</h3>
                {{-- Hiba miatti visszatöltéskor a böngésző biztonsági okból nem tölti vissza a
                     fájlmezőt, ezért szólunk, ha a felhasználó előzőleg saját képet választott.
                     old() csak hibás beküldés utáni visszairányításkor tartalmaz adatot. --}}
                @if (old('had_upload') === '1')
                    <p class="form-warning">
                        Az űrlap hiba miatt visszatöltődött. A feltöltött képet a böngésző nem tudja megőrizni, kérjük, válaszd ki újra!
                    </p>
                @endif
                {{-- a JS állítja 1-re, ha saját képet választott (így tudjuk, kell-e a fenti figyelmeztetés) --}}
                <input type="hidden" name="had_upload" value="0" class="had-upload">
                <label class="upload-box">
                    <input type="file" name="thumbnail_image" accept="image/jpeg,image/png,image/gif,image/webp" class="upload-input">
                    <img src="{{ asset('images/recipes/default/recipe_placeholder.jpg') }}" alt="" class="upload-placeholder">
                    <span class="upload-hint">+</span>
                </label>
                @error('thumbnail_image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="image-section">
                <h3 class="image-section-title">Vagy válassz előre definiált képet</h3>
                <div class="image-picker">
                    @php
                        // Fájlnév => megjelenő név. A tömb sorrendje = a választó sorrendje.
                        // Új alapkép hozzáadásakor ide is fel kell venni.
                        $defaultImages = [
                            'soup_thumbnail.svg'        => 'Leves',
                            'main_course_thumbnail.svg' => 'Főétel',
                            'dessert_thumbnail.svg'     => 'Desszert',
                            'starter_thumbnail.svg'     => 'Előétel / Nasi',
                            'side_dish_thumbnail.svg'   => 'Köret',
                            'salad_thumbnail.svg'       => 'Saláta',
                            'pasta_thumbnail.svg'       => 'Tészta',
                            'breakfast_thumbnail.svg'   => 'Reggeli',
                            'bakery_thumbnail.svg'      => 'Pékáru',
                            'fruit_thumbnail.svg'       => 'Gyümölcs',
                            'drink_thumbnail.svg'       => 'Ital',
                            'preserve_thumbnail.svg'    => 'Befőtt',
                        ];
                    @endphp
                    @foreach ($defaultImages as $imageName => $imageLabel)
                        @php
                            $imagePath = public_path('images/recipes/default/' . $imageName);
                            $imageValue = 'images/recipes/default/' . $imageName;
                        @endphp
                        {{-- ha egy fájl hiányzik a mappából, kihagyjuk (ne legyen törött kép) --}}
                        @continue(!is_file($imagePath))
                        <label class="image-option">
                            {{-- a rádiógomb láthatatlan, de ez küldi az értéket; a stílust a mögötte lévő kártya kapja (CSS :checked + ...) --}}
                            <input type="radio" name="default_image" value="{{ $imageValue }}" class="image-option-input"
                                {{ old('default_image', $recipe->thumbnail ?? '') == $imageValue ? 'checked' : '' }}>
                            <span class="image-option-card">
                                {{-- ?v=... : ha a képfájl változik, a böngésző nem a régit mutatja a cache-ből --}}
                                <img src="{{ asset($imageValue) }}?v={{ filemtime($imagePath) }}" alt="">
                                <span class="image-option-label">{{ $imageLabel }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('default_image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        </div>

        <div class="content-card">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="chef-hat"></i></span>
                Elkészítés lépései <span class="form-error">*</span>
            </h2>

            <div class="form-group">
                <div id="steps-container">
                    @php
                        // Ha szerkesztés van, a meglévő lépések; ha nincs, 3 üres mező
                        $stepCount = $isEdit && count($stepValues) > 0 ? count($stepValues) : 3;
                    @endphp
                    @for ($i = 0; $i < $stepCount; $i++)
                        <div class="step-item">
                            <label>{{ $i + 1 }}. lépés</label>
                            <input type="text" name="steps[{{ $i }}][description]" value="{{ old('steps.' . $i . '.description', $stepValues[$i]['description'] ?? '') }}" placeholder="Add meg a(z) {{ $i + 1 }}. lépést" maxlength="1000">
                            <small class="char-counter">0 / 1000</small>
                            <select name="steps[{{ $i }}][step_category_id]">
                                <option value="">-- Kategória --</option>
                                @foreach ($stepCategories as $category)
                                    <option value="{{ $category->id }}" {{ old('steps.' . $i . '.step_category_id', $stepValues[$i]['step_category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('steps.' . $i . '.description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                            <button type="button" class="remove-step" title="Lépés eltávolítása">×</button>
                        </div>
                    @endfor
                </div>
                @error('steps')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <button type="button" id="add-step" class="btn-outline">+ Lépés hozzáadása</button>
            </div>
        </div>

        <div class="content-card">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="cooking-pot"></i></span>
                Alapanyagok <span class="form-error">*</span>
            </h2>

            <div class="form-group">
                <div id="ingredients">
                    @php
                        // Ha szerkesztés van, a meglévő alapanyagok; ha nincs, 3 üres mező
                        $ingredientCount = $isEdit && count($ingredientValues) > 0 ? count($ingredientValues) : 3;
                    @endphp
                    @for ($i = 0; $i < $ingredientCount; $i++)
                        <div class="ingredient-item">
                            <input type="text" name="ingredients[{{ $i }}][name]" list="ingredient-options" value="{{ old('ingredients.' . $i . '.name', $ingredientValues[$i]['name'] ?? '') }}" placeholder="Alapanyag neve" maxlength="50">
                            <small class="char-counter">0 / 50</small>

                            <input type="number" name="ingredients[{{ $i }}][quantity]" step="0.1" min="0.1" placeholder="Mennyiség" value="{{ old('ingredients.' . $i . '.quantity', $ingredientValues[$i]['quantity'] ?? '') }}">

                            <select name="ingredients[{{ $i }}][unit]">
                                <option value="">-- Mértékegység --</option>
                                <option value="g" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'g' ? 'selected' : '' }}>g</option>
                                <option value="kg" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="ml" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'ml' ? 'selected' : '' }}>ml</option>
                                <option value="l" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'l' ? 'selected' : '' }}>l</option>
                                <option value="db" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'db' ? 'selected' : '' }}>db</option>
                                <option value="csésze" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'csésze' ? 'selected' : '' }}>csésze</option>
                                <option value="evőkanál" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'evőkanál' ? 'selected' : '' }}>evőkanál</option>
                                <option value="teáskanál" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'teáskanál' ? 'selected' : '' }}>teáskanál</option>
                                <option value="csipet" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'csipet' ? 'selected' : '' }}>csipet</option>
                                <option value="ízlés szerint" {{ old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') == 'ízlés szerint' ? 'selected' : '' }}>ízlés szerint</option>
                            </select>

                            <button type="button" class="remove-ingredient" title="Alapanyag eltávolítása">×</button>

                            @error('ingredients.' . $i . '.name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                            @error('ingredients.' . $i . '.quantity')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                            @error('ingredients.' . $i . '.unit')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endfor
                </div>

                <datalist id="ingredient-options">
                    @foreach ($ingredients as $ingredient)
                        <option value="{{ $ingredient->name }}"></option>
                    @endforeach
                </datalist>

                <button type="button" id="add-ingredient" class="btn-outline">+ Alapanyag hozzáadása</button>

                @error('ingredients')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="content-card">
            <h2 class="content-title">
                <span class="title-icon"><i data-lucide="tags"></i></span>
                Kategóriák
            </h2>

            <div>
                <h3 style="margin-bottom: 0.25rem;">Napszak</h3>
                <div class="checkbox-group">
                    @foreach ($mealTimes as $mealTime)
                        <label>
                            <input type="checkbox" name="meal_times[]" value="{{ $mealTime->id }}"
                                {{ (is_array(old('meal_times')) && in_array($mealTime->id, old('meal_times'))) || ($isEdit && $recipe->mealTimes->contains($mealTime->id)) ? 'checked' : '' }}>
                            {{ $mealTime->name }}
                        </label>
                    @endforeach
                </div>
                @error('meal_times')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 1rem;">
                <h3 style="margin-bottom: 0.25rem;">Étel típusa <span class="form-error">*</span></h3>
                <div class="checkbox-group">
                    @foreach ($foodTypes as $foodType)
                        <label>
                            <input type="checkbox" name="food_types[]" value="{{ $foodType->id }}"
                                {{ (is_array(old('food_types')) && in_array($foodType->id, old('food_types'))) || ($isEdit && $recipe->foodTypes->contains($foodType->id)) ? 'checked' : '' }}>
                            {{ $foodType->name }}
                        </label>
                    @endforeach
                </div>
                @error('food_types')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 1rem;">
                <h3 style="margin-bottom: 0.25rem;">Étrend</h3>
                <div class="checkbox-group">
                    @foreach ($diets as $diet)
                        <label>
                            <input type="radio" name="diet" value="{{ $diet->id }}"
                                {{ old('diet', $isEdit ? $recipe->diets->pluck('id')->first() ?? '' : '') == $diet->id ? 'checked' : '' }}>
                            {{ $diet->name }}
                        </label>
                    @endforeach
                </div>
                @error('diet')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 1rem;">
                <h3 style="margin-bottom: 0.25rem;">Érzékenység</h3>
                <div class="checkbox-group">
                    @foreach ($allergens as $allergen)
                        <label>
                            <input type="checkbox" name="allergens[]" value="{{ $allergen->id }}"
                                {{ (is_array(old('allergens')) && in_array($allergen->id, old('allergens'))) || ($isEdit && $recipe->allergens->contains($allergen->id)) ? 'checked' : '' }}>
                            {{ $allergen->name }}
                        </label>
                    @endforeach
                </div>
                @error('allergens')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 1rem;">
                <h3 style="margin-bottom: 0.25rem;">Konyha</h3>
                <div class="checkbox-group">
                    @foreach ($cuisines as $cuisine)
                        <label>
                            <input type="checkbox" name="cuisines[]" value="{{ $cuisine->id }}"
                                {{ (is_array(old('cuisines')) && in_array($cuisine->id, old('cuisines'))) || ($isEdit && $recipe->cuisines->contains($cuisine->id)) ? 'checked' : '' }}>
                            {{ $cuisine->name }}
                        </label>
                    @endforeach
                </div>
                @error('cuisines')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-cook btn-cook-primary">{{ $isEdit ? 'Módosítások mentése' : 'Recept feltöltése' }}</button>
    </form>
    </div>

    @include('partials.image-cropper')

    <script>
        // A cím textarea, de egysoros adat: Enterre ne törjön sort,
        // beillesztett sortörés helyett pedig szóköz kerüljön bele
        const titleInput = document.getElementById('title');
        titleInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') e.preventDefault();
        });
        titleInput.addEventListener('input', function () {
            if (this.value.includes('\n')) this.value = this.value.replace(/\n/g, ' ');
        });

        // Saját kép előnézet
        const thumbnailInput = document.querySelector('.upload-input');
        const thumbnailPreview = document.querySelector('.upload-placeholder');
        const defaultImageRadios = document.querySelectorAll('.image-option-input');
        const hadUploadInput = document.querySelector('.had-upload');
        // Fájl kiválasztása után a közös vágó ablak nyílik meg, és egy 1240x800-as,
        // tömörített JPEG kerül a file inputba (partials/image-cropper.blade.php).
        // Az arány (1.55 : 1) a recept kártyák képéhez igazodik (.recipe-image: kb. 308x200 px),
        // és megegyezik az alapképek arányával (.image-option-card img: aspect-ratio 1.55).
        // A méretet a RecipeController validációja is ellenőrzi - ha itt változik, ott is kell!
        const thumbnailCropper = setupImageCropper({
            input: thumbnailInput,
            width: 1240,
            height: 800,
            quality: 0.85,
            onApply: function (blob) {
                thumbnailPreview.src = URL.createObjectURL(blob);
                thumbnailPreview.style.opacity = '1';
                hadUploadInput.value = '1';
                // saját kép választásakor az alapkép-választás törlődik (a szerver úgyis a feltöltöttet menti)
                defaultImageRadios.forEach(radio => radio.checked = false);
            },
        });

        // alapkép választásakor a feltöltött saját kép törlődik, hogy egyértelmű legyen, melyik lesz mentve
        defaultImageRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                thumbnailCropper.clear();
                thumbnailPreview.style.opacity = '0';
                hadUploadInput.value = '0';
            });
        });

        document.getElementById('add-step').addEventListener('click', function() {
            const container = document.getElementById('steps-container');
            const steps = container.querySelectorAll('.step-item');
            const lastStep = steps[steps.length - 1];
            const newStep = lastStep.cloneNode(true);

            // Input és select érték törlése
            const input = newStep.querySelector('input');
            input.value = '';
            const select = newStep.querySelector('select');
            if (select) select.value = '';

            // Hibaüzenet törlése (ha volt előzőleg)
            newStep.querySelectorAll('span').forEach(s => s.remove());

            // Karakterszámláló visszaállítása
            const stepCounter = newStep.querySelector('.char-counter');
            if (stepCounter) stepCounter.textContent = '0 / ' + input.maxLength;

            container.appendChild(newStep);
            relabelSteps();
            updateStepRemoveButtons();
        });

        // Lépés sor eltávolítása
        document.getElementById('steps-container').addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-step');
            if (!btn) return;
            const rows = this.querySelectorAll('.step-item');
            if (rows.length <= 3) return;
            btn.closest('.step-item').remove();
            relabelSteps();
            updateStepRemoveButtons();
        });

        // Lépések címkéinek és neveinek újraszámozása
        function relabelSteps() {
            document.querySelectorAll('#steps-container .step-item').forEach((row, index) => {
                row.querySelector('label').textContent = (index + 1) + '. lépés';
                const input = row.querySelector('input');
                input.name = 'steps[' + index + '][description]';
                input.placeholder = 'Add meg a(z) ' + (index + 1) + '. lépést';
                const select = row.querySelector('select');
                if (select) select.name = 'steps[' + index + '][step_category_id]';
            });
        }

        // × gombok letiltása, ha csak 3 lépés van (eltüntetés helyett, hogy mindig ott legyenek)
        function updateStepRemoveButtons() {
            const rows = document.querySelectorAll('#steps-container .step-item');
            const canRemove = rows.length > 3;
            rows.forEach(function(row) {
                const btn = row.querySelector('.remove-step');
                if (btn) btn.disabled = !canRemove;
            });
        }

        // Alapanyag sor hozzáadása
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const container = document.getElementById('ingredients');
            const rows = container.querySelectorAll('.ingredient-item');
            const lastRow = rows[rows.length - 1];
            const newRow = lastRow.cloneNode(true);

            newRow.querySelector('input[name*="[name]"]').value = '';
            newRow.querySelector('input[name*="[quantity]"]').value = '';
            newRow.querySelector('select[name*="[unit]"]').value = '';

            newRow.querySelectorAll('span').forEach(s => s.remove());

            // Karakterszámláló visszaállítása
            const ingCounter = newRow.querySelector('.char-counter');
            if (ingCounter) ingCounter.textContent = '0 / ' + newRow.querySelector('input[name*="[name]"]').maxLength;

            container.appendChild(newRow);
            reindexIngredients();
            updateIngredientRemoveButtons();
        });

        // Alapanyag sor eltávolítása
        document.getElementById('ingredients').addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-ingredient');
            if (!btn) return;
            const rows = this.querySelectorAll('.ingredient-item');
            if (rows.length <= 3) return;
            btn.closest('.ingredient-item').remove();
            reindexIngredients();
            updateIngredientRemoveButtons();
        });

        // Alapanyag sorok újraindexelése
        function reindexIngredients() {
            const rows = document.querySelectorAll('#ingredients .ingredient-item');
            rows.forEach((row, index) => {
                row.querySelector('input[name*="[name]"]').name = 'ingredients[' + index + '][name]';
                row.querySelector('input[name*="[quantity]"]').name = 'ingredients[' + index + '][quantity]';
                row.querySelector('select[name*="[unit]"]').name = 'ingredients[' + index + '][unit]';
            });
        }

        // × gombok letiltása, ha csak 3 alapanyag van (eltüntetés helyett, hogy mindig ott legyenek)
        function updateIngredientRemoveButtons() {
            const rows = document.querySelectorAll('#ingredients .ingredient-item');
            const canRemove = rows.length > 3;
            rows.forEach(function(row) {
                const btn = row.querySelector('.remove-ingredient');
                if (btn) btn.disabled = !canRemove;
            });
        }

        // Induláskor elrejtjük a felesleges × gombokat
        updateStepRemoveButtons();
        updateIngredientRemoveButtons();
    </script>
@endsection
