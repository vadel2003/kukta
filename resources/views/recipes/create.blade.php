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
        $stepCount = max(3, count(old('steps', $stepValues)));
        $ingredientCount = max(3, count(old('ingredients', $ingredientValues)));

        $categoryGroups = [
            ['field' => 'meal_times', 'title' => 'Napszak', 'items' => $mealTimes, 'relation' => 'mealTimes', 'required' => true],
            ['field' => 'food_types', 'title' => 'Étel típusa', 'items' => $foodTypes, 'relation' => 'foodTypes', 'required' => true],
            ['field' => 'diets', 'title' => 'Étrend', 'items' => $diets, 'relation' => 'diets', 'required' => true],
            ['field' => 'free_from', 'title' => 'Mentesség', 'items' => $freeFroms, 'relation' => 'freeFroms', 'required' => false],
            ['field' => 'cuisines', 'title' => 'Konyha', 'items' => $cuisines, 'relation' => 'cuisines', 'required' => true],
        ];
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
                            @foreach (\App\Models\Recipe::DIFFICULTIES as $value => $label)
                                <option value="{{ $value }}" {{ (string) old('difficulty', $recipe->difficulty ?? '') === (string) $value ? 'selected' : '' }}>{{ ucfirst($label) }}</option>
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
                            @foreach (\App\Models\Recipe::DEFAULT_IMAGES as $imageValue => $imageLabel)
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
                                <input type="text" name="steps[{{ $i }}][description]" value="{{ old('steps.' . $i . '.description', $stepValues[$i]['description'] ?? '') }}" placeholder="Add meg a(z) {{ $i + 1 }}. lépést" minlength="5" maxlength="1000">
                                <select name="steps[{{ $i }}][step_category_id]">
                                    <option value="">-- Kategória --</option>
                                    @foreach ($stepCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('steps.' . $i . '.step_category_id', $stepValues[$i]['step_category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('steps.' . $i . '.description')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                @error('steps.' . $i . '.step_category_id')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <button type="button" class="remove-row" title="Lépés eltávolítása">×</button>
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
                <p class="field-hint">Legalább 3 alapanyag kell, mennyiséggel és mértékegységgel. Válassz a listából, vagy írd be az új alapanyag nevét, ha nincs benne. Az üres sorok nem mentődnek.</p>

                <div class="form-group">
                    <div id="ingredients">
                        @for ($i = 0; $i < $ingredientCount; $i++)
                            <div class="ingredient-item">
                                <input type="text" name="ingredients[{{ $i }}][name]" list="ingredient-options" value="{{ old('ingredients.' . $i . '.name', $ingredientValues[$i]['name'] ?? '') }}" placeholder="Alapanyag neve" minlength="2" maxlength="50">

                                <input type="number" name="ingredients[{{ $i }}][quantity]" step="0.01" min="0.1" max="10000" placeholder="Mennyiség" value="{{ old('ingredients.' . $i . '.quantity', $ingredientValues[$i]['quantity'] ?? '') }}">

                                <select name="ingredients[{{ $i }}][unit]">
                                    <option value="">-- Mértékegység --</option>
                                    @foreach (\App\Models\IngredientRecipe::UNITS as $unitId => $unitName)
                                        <option value="{{ $unitId }}" {{ (string) old('ingredients.' . $i . '.unit', $ingredientValues[$i]['unit'] ?? '') === (string) $unitId ? 'selected' : '' }}>{{ $unitName }}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="remove-row" title="Alapanyag eltávolítása">×</button>

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

                @foreach ($categoryGroups as $group)
                    <div class="category-group">
                        <h3>{{ $group['title'] }} @if ($group['required'])<span class="form-error">*</span>@endif</h3>
                        @if ($group['field'] === 'free_from')
                            <p class="field-hint">Jelöld be, amitől a recept mentes.</p>
                        @endif
                        <div class="checkbox-group">
                            @foreach ($group['items'] as $item)
                                @php
                                    $relation = $group['relation'];
                                    $isChecked = is_array(old($group['field']))
                                        ? in_array($item->id, old($group['field']))
                                        : $isEdit && $recipe->$relation->contains($item->id);
                                @endphp
                                <label>
                                    <input type="checkbox" name="{{ $group['field'] }}[]" value="{{ $item->id }}" {{ $isChecked ? 'checked' : '' }}>
                                    @if ($item->thumbnail)
                                        <img src="{{ asset($item->thumbnail) }}" alt="" class="category-icon">
                                    @endif
                                    {{ $item->name }}
                                </label>
                            @endforeach
                        </div>
                        @error($group['field'])
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn-cook btn-cook-primary btn-recipe-submit">{{ $isEdit ? 'Módosítások mentése' : 'Recept feltöltése' }}</button>
        </form>
    </div>

    <script>
        const stepsContainer = document.getElementById('steps-container');
        const ingredientsContainer = document.getElementById('ingredients');

        /**
         * Renumbers the field names of the rows (steps[0]..., ingredients[0]...), and the labels of the steps.
         * At least 3 rows must remain, so the remove buttons are disabled at 3 rows.
         */
        function renumberRows(container) {
            Array.from(container.children).forEach((row, index) => {
                row.querySelectorAll('input, select').forEach(field => {
                    field.name = field.name.replace(/\[\d+\]/, '[' + index + ']');
                });
                if (container === stepsContainer) {
                    row.querySelector('label').textContent = (index + 1) + '. lépés';
                    row.querySelector('input').placeholder = 'Add meg a(z) ' + (index + 1) + '. lépést';
                }
            });
            container.querySelectorAll('.remove-row').forEach(button => {
                button.disabled = container.children.length <= 3;
            });
        }

        /**
         * Adds a new, empty row as a copy of the last row.
         */
        function addRow(container) {
            const newRow = container.lastElementChild.cloneNode(true);
            newRow.querySelectorAll('input, select').forEach(field => {
                field.value = '';
            });
            newRow.querySelectorAll('.form-error').forEach(error => error.remove());
            container.appendChild(newRow);
            renumberRows(container);
        }

        document.getElementById('add-step').addEventListener('click', () => addRow(stepsContainer));
        document.getElementById('add-ingredient').addEventListener('click', () => addRow(ingredientsContainer));

        [stepsContainer, ingredientsContainer].forEach(container => {
            container.addEventListener('click', event => {
                const removeButton = event.target.closest('.remove-row');
                if (!removeButton || container.children.length <= 3) return;
                removeButton.parentElement.remove();
                renumberRows(container);
            });
            renumberRows(container);
        });
    </script>
@endsection
