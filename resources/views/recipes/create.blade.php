@extends('layouts.app')

@section('title', isset($recipe) ? 'Recept szerkesztése' : 'Új recept')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection

@section('content')
    @php
        $isEdit = isset($recipe);

        $stepValues = [];
        $ingredientValues = [];
        if ($isEdit) {
            foreach ($recipe->steps as $step) {
                $stepValues[] = [
                    'description' => $step->description,
                    'step_category_id' => $step->step_category_id,
                ];
            }
            foreach ($recipe->ingredients as $ingredient) {
                $ingredientValues[] = [
                    'name' => $ingredient->name,
                    'quantity' => $ingredient->pivot->quantity,
                    'unit' => $ingredient->pivot->unit,
                ];
            }
        }
        // at least 3 rows are shown
        $stepCount = count(old('steps', $stepValues));
        if ($stepCount < 3) {
            $stepCount = 3;
        }
        $ingredientCount = count(old('ingredients', $ingredientValues));
        if ($ingredientCount < 3) {
            $ingredientCount = 3;
        }

        // checked categories: from old() after a validation error, otherwise from the edited recipe
        $checkedMealTimes = [];
        $checkedFoodTypes = [];
        $checkedDiets = [];
        $checkedFreeFroms = [];
        $checkedCuisines = [];
        if ($errors->any()) {
            $checkedMealTimes = old('meal_times', []);
            $checkedFoodTypes = old('food_types', []);
            $checkedDiets = old('diets', []);
            $checkedFreeFroms = old('free_from', []);
            $checkedCuisines = old('cuisines', []);
        } elseif ($isEdit) {
            foreach ($recipe->mealTimes as $item) {
                $checkedMealTimes[] = $item->id;
            }
            foreach ($recipe->foodTypes as $item) {
                $checkedFoodTypes[] = $item->id;
            }
            foreach ($recipe->diets as $item) {
                $checkedDiets[] = $item->id;
            }
            foreach ($recipe->freeFroms as $item) {
                $checkedFreeFroms[] = $item->id;
            }
            foreach ($recipe->cuisines as $item) {
                $checkedCuisines[] = $item->id;
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
                        <input type="text" name="title" id="title" value="{{ old('title', $recipe->title ?? '') }}" required minlength="5" maxlength="100" autofocus>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Leírás <span class="form-error">*</span></label>
                        <textarea name="description" id="description" rows="18" required minlength="5" maxlength="1000">{{ old('description', $recipe->description ?? '') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prep_time">Elkészítési idő (perc) <span class="form-error">*</span></label>
                        <input type="number" name="prep_time" id="prep_time" value="{{ old('prep_time', $recipe->prep_time ?? '') }}" required min="3" max="1440">
                        @error('prep_time')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="difficulty">Nehézség <span class="form-error">*</span></label>
                        <select name="difficulty" id="difficulty" required>
                            <option value="">-- Válassz --</option>
                            @foreach ($difficulties as $value => $label)
                                <option value="{{ $value }}" {{ strval(old('difficulty', $recipe->difficulty ?? '')) === strval($value) ? 'selected' : '' }}>{{ ucfirst($label) }}</option>
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
                        <p class="field-hint">JPG, PNG vagy WebP kép, legfeljebb 2 MB.</p>
                        @if ($errors->any())
                            <p class="form-warning">
                                Az űrlap hiba miatt visszatöltődött. Ha képet töltöttél fel, a böngésző nem tudja megőrizni, kérjük, válaszd ki újra!
                            </p>
                        @endif
                        <input type="file" name="thumbnail_image" accept="image/jpeg,image/png,image/webp">
                        @error('thumbnail_image')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="image-section">
                        <h3 class="image-section-title">Vagy válassz előre definiált képet</h3>
                        <p class="field-hint">Ha saját képet is feltöltesz, az lesz a recept képe.</p>
                        <div class="image-picker">
                            @foreach ($defaultImages as $imageValue => $imageLabel)
                                <label class="image-option">
                                    <input type="radio" name="default_image" value="{{ $imageValue }}" class="image-option-input"
                                        {{ old('default_image', $recipe->thumbnail ?? '') == $imageValue ? 'checked' : '' }}>
                                    <span class="image-option-card">
                                        <img src="{{ asset($imageValue) }}" alt="">
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
                <p class="field-hint">Legalább 3 lépés kell, mindegyikhez válassz kategóriát. Az üres sorok nem mentődnek.</p>

                <div class="form-group">
                    <div id="steps-container">
                        @for ($i = 0; $i < $stepCount; $i++)
                            <div class="step-item">
                                <label>{{ $i + 1 }}. lépés</label>
                                <input type="text" name="steps[{{ $i }}][description]" value="{{ old('steps.' . $i . '.description', $stepValues[$i]['description'] ?? '') }}" placeholder="Add meg a(z) {{ $i + 1 }}. lépést" minlength="5" maxlength="200">
                                <select name="steps[{{ $i }}][step_category_id]">
                                    <option value="">-- Kategória --</option>
                                    @foreach ($stepCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('steps.' . $i . '.step_category_id', $stepValues[$i]['step_category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="remove-row" title="Lépés eltávolítása" onclick="removeRow(this)" {{ $stepCount <= 3 ? 'disabled' : '' }}>×</button>
                                @error('steps.' . $i . '.description')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                @error('steps.' . $i . '.step_category_id')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endfor
                    </div>
                    @error('steps')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <button type="button" class="btn-outline" onclick="addRow(stepsContainer)">+ Lépés hozzáadása</button>
                </div>
            </div>

            <div class="content-card">
                <h2 class="content-title">
                    <span class="title-icon"><i data-lucide="cooking-pot"></i></span>
                    Alapanyagok <span class="form-error">*</span>
                </h2>
                <p class="field-hint">Legalább 3 alapanyag kell, mennyiséggel és mértékegységgel. Válassz a listából, vagy írd be az új alapanyag nevét, ha nincs benne. Az üres sorok nem mentődnek.</p>

                <div class="form-group">
                    <div id="ingredients">
                        @for ($i = 0; $i < $ingredientCount; $i++)
                            <div class="ingredient-item">
                                <input type="text" name="ingredients[{{ $i }}][name]" list="ingredient-options" value="{{ old('ingredients.' . $i . '.name', $ingredientValues[$i]['name'] ?? '') }}" placeholder="Alapanyag neve" minlength="2" maxlength="50">

                                <input type="number" name="ingredients[{{ $i }}][quantity]" step="0.01" min="0.1" max="10000" placeholder="Mennyiség" value="{{ old('ingredients.' . $i . '.quantity', $ingredientValues[$i]['quantity'] ?? '') }}">

                                <select name="ingredients[{{ $i }}][unit]">
                                    <option value="">-- Mértékegység --</option>
                                    @foreach ($units as $unitId => $unitName)
                                        <option value="{{ $unitId }}" {{ strval(old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '')) === strval($unitId) ? 'selected' : '' }}>{{ $unitName }}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="remove-row" title="Alapanyag eltávolítása" onclick="removeRow(this)" {{ $ingredientCount <= 3 ? 'disabled' : '' }}>×</button>

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

                    <button type="button" class="btn-outline" onclick="addRow(ingredientsContainer)">+ Alapanyag hozzáadása</button>

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

                <div class="category-group">
                    <h3>Napszak <span class="form-error">*</span></h3>
                    <div class="checkbox-group">
                        @foreach ($mealTimes as $item)
                            <label>
                                <input type="checkbox" name="meal_times[]" value="{{ $item->id }}" {{ in_array($item->id, $checkedMealTimes) ? 'checked' : '' }}>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('meal_times')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category-group">
                    <h3>Étel típusa <span class="form-error">*</span></h3>
                    <div class="checkbox-group">
                        @foreach ($foodTypes as $item)
                            <label>
                                <input type="checkbox" name="food_types[]" value="{{ $item->id }}" {{ in_array($item->id, $checkedFoodTypes) ? 'checked' : '' }}>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('food_types')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category-group">
                    <h3>Étrend <span class="form-error">*</span></h3>
                    <div class="checkbox-group">
                        @foreach ($diets as $item)
                            <label>
                                <input type="checkbox" name="diets[]" value="{{ $item->id }}" {{ in_array($item->id, $checkedDiets) ? 'checked' : '' }}>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('diets')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category-group">
                    <h3>Mentesség</h3>
                    <p class="field-hint">Jelöld be, amitől a recept mentes.</p>
                    <div class="checkbox-group">
                        @foreach ($freeFroms as $item)
                            <label>
                                <input type="checkbox" name="free_from[]" value="{{ $item->id }}" {{ in_array($item->id, $checkedFreeFroms) ? 'checked' : '' }}>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('free_from')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category-group">
                    <h3>Konyha <span class="form-error">*</span></h3>
                    <div class="checkbox-group">
                        @foreach ($cuisines as $item)
                            <label>
                                <input type="checkbox" name="cuisines[]" value="{{ $item->id }}" {{ in_array($item->id, $checkedCuisines) ? 'checked' : '' }}>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                @endif
                                {{ $item->name }}
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

    <script>
        const stepsContainer = document.getElementById('steps-container');
        const ingredientsContainer = document.getElementById('ingredients');

        // adds a new, empty row as a copy of the last row
        function addRow(container) {
            const newRow = container.lastElementChild.cloneNode(true);

            const fields = newRow.querySelectorAll('input, select');
            for (let i = 0; i < fields.length; i++) {
                fields[i].value = '';
            }

            const errors = newRow.querySelectorAll('.form-error');
            for (let i = 0; i < errors.length; i++) {
                errors[i].remove();
            }

            container.appendChild(newRow);
            renumberRows();
        }

        // removes a row, at least 3 rows must remain
        function removeRow(button) {
            const row = button.parentElement;
            const container = row.parentElement;
            if (container.children.length <= 3) {
                return;
            }

            row.remove();
            renumberRows();
        }

        // renumbers the field names (steps[0], steps[1], ...) and disables the remove buttons at 3 rows
        function renumberRows() {
            const steps = stepsContainer.children;
            for (let i = 0; i < steps.length; i++) {
                const input = steps[i].querySelector('input');
                input.name = 'steps[' + i + '][description]';
                input.placeholder = 'Add meg a(z) ' + (i + 1) + '. lépést';
                steps[i].querySelector('label').textContent = (i + 1) + '. lépés';
                steps[i].querySelector('select').name = 'steps[' + i + '][step_category_id]';
                steps[i].querySelector('.remove-row').disabled = steps.length <= 3;
            }

            const ingredients = ingredientsContainer.children;
            for (let i = 0; i < ingredients.length; i++) {
                const inputs = ingredients[i].querySelectorAll('input');
                inputs[0].name = 'ingredients[' + i + '][name]';
                inputs[1].name = 'ingredients[' + i + '][quantity]';
                ingredients[i].querySelector('select').name = 'ingredients[' + i + '][unit]';
                ingredients[i].querySelector('.remove-row').disabled = ingredients.length <= 3;
            }
        }
    </script>
@endsection
