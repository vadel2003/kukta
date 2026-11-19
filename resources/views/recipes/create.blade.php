@extends('layouts.app')

@if (isset($recipe))
    @section('title', 'Recept szerkesztése')
@else
    @section('title', 'Új recept')
@endif

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    @php
        $isEdit = isset($recipe);

        $formAction = route('recipes.store');
        $title = '';
        $description = '';
        $prepTime = '';
        $difficulty = '';
        $servings = '';
        $thumbnail = '';
        if ($isEdit) {
            $formAction = route('recipes.update', $recipe->id);
            $title = $recipe->title;
            $description = $recipe->description;
            $prepTime = $recipe->prep_time;
            $difficulty = $recipe->difficulty;
            $servings = $recipe->servings;
            $thumbnail = $recipe->thumbnail;
        }

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
        $stepCount = count(old('steps', $stepValues));
        if ($stepCount < 3) {
            $stepCount = 3;
        }
        $ingredientCount = count(old('ingredients', $ingredientValues));
        if ($ingredientCount < 3) {
            $ingredientCount = 3;
        }

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

    <div class="column">
        <div>
            <a href="{{ route('home') }}" class="back_button"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
            @if ($isEdit)
                <h1>Recept szerkesztése</h1>
            @else
                <h1>Új recept feltöltése</h1>
            @endif
        </div>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="recipe_form">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="two_columns">
                <div class="box">
                    <h2 class="box_title">
                        <span class="title_icon"><i data-lucide="clipboard-list"></i></span>
                        Alapadatok
                    </h2>

                    <div class="form_group">
                        <label for="title">Recept címe <span class="error_message">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $title) }}" required minlength="5" maxlength="100" autofocus>
                        @error('title')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="description">Leírás <span class="error_message">*</span></label>
                        <textarea name="description" id="description" rows="18" required minlength="5" maxlength="1000">{{ old('description', $description) }}</textarea>
                        @error('description')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="prep_time">Elkészítési idő (perc) <span class="error_message">*</span></label>
                        <input type="number" name="prep_time" id="prep_time" value="{{ old('prep_time', $prepTime) }}" required min="3" max="1440">
                        @error('prep_time')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="difficulty">Nehézség <span class="error_message">*</span></label>
                        <select name="difficulty" id="difficulty" required>
                            <option value="">-- Válassz --</option>
                            @foreach ($difficulties as $value => $label)
                                <option value="{{ $value }}" @if (strval(old('difficulty', $difficulty)) === strval($value)) selected @endif>{{ ucfirst($label) }}</option>
                            @endforeach
                        </select>
                        @error('difficulty')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form_group">
                        <label for="servings">Adag <span class="error_message">*</span></label>
                        <input type="number" name="servings" id="servings" value="{{ old('servings', $servings) }}" required min="1" max="50">
                        @error('servings')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="box">
                    <h2 class="box_title">
                        <span class="title_icon"><i data-lucide="image"></i></span>
                        Kép <span class="error_message">*</span>
                    </h2>

                    <div>
                        <h3 class="image_title">Tölts fel saját képet</h3>
                        <p class="hint">JPG, PNG vagy WebP kép, legfeljebb 2 MB.</p>
                        @if ($errors->any())
                            <p class="warning">
                                Az űrlap hiba miatt visszatöltődött. Ha képet töltöttél fel, a böngésző nem tudja megőrizni, kérjük, válaszd ki újra!
                            </p>
                        @endif
                        <input type="file" name="thumbnail_image" accept="image/jpeg,image/png,image/webp">
                        @error('thumbnail_image')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="images">
                        <h3 class="image_title">Vagy válassz előre definiált képet</h3>
                        <p class="hint">Ha saját képet is feltöltesz, az lesz a recept képe.</p>
                        <div class="image_grid">
                            @foreach ($defaultImages as $imageValue => $imageLabel)
                                <label class="image_option">
                                    <input type="radio" name="default_image" value="{{ $imageValue }}" class="image_radio"
                                        @if (old('default_image', $thumbnail) == $imageValue) checked @endif>
                                    <span class="image_box">
                                        <img src="{{ asset($imageValue) }}" alt="">
                                        <span class="image_name">{{ $imageLabel }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('default_image')
                            <span class="error_message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="box">
                <h2 class="box_title">
                    <span class="title_icon"><i data-lucide="chef-hat"></i></span>
                    Elkészítés lépései <span class="error_message">*</span>
                </h2>
                <p class="hint">Legalább 3 lépés kell, mindegyikhez válassz kategóriát. Az üres sorok nem mentődnek.</p>

                <div class="form_group">
                    <div id="steps">
                        @for ($i = 0; $i < $stepCount; $i++)
                            @php
                                $stepDescription = '';
                                $stepCategory = '';
                                if (isset($stepValues[$i])) {
                                    $stepDescription = $stepValues[$i]['description'];
                                    $stepCategory = $stepValues[$i]['step_category_id'];
                                }
                            @endphp
                            <div class="step_item">
                                <label>{{ $i + 1 }}. lépés</label>
                                <input type="text" name="steps[{{ $i }}][description]" value="{{ old('steps.' . $i . '.description', $stepDescription) }}" placeholder="Add meg a(z) {{ $i + 1 }}. lépést" minlength="5" maxlength="200">
                                <select name="steps[{{ $i }}][step_category_id]">
                                    <option value="">-- Kategória --</option>
                                    @foreach ($stepCategories as $category)
                                        <option value="{{ $category->id }}" @if (old('steps.' . $i . '.step_category_id', $stepCategory) == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="remove_row" title="Lépés eltávolítása" onclick="removeRow(this)" @if ($stepCount <= 3) disabled @endif>×</button>
                                @error('steps.' . $i . '.description')
                                    <span class="error_message">{{ $message }}</span>
                                @enderror
                                @error('steps.' . $i . '.step_category_id')
                                    <span class="error_message">{{ $message }}</span>
                                @enderror
                            </div>
                        @endfor
                    </div>
                    @error('steps')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                    <button type="button" class="white_button" onclick="addRow(stepsContainer)">+ Lépés hozzáadása</button>
                </div>
            </div>

            <div class="box">
                <h2 class="box_title">
                    <span class="title_icon"><i data-lucide="cooking-pot"></i></span>
                    Alapanyagok <span class="error_message">*</span>
                </h2>
                <p class="hint">Legalább 3 alapanyag kell, mennyiséggel és mértékegységgel. Válassz a listából, vagy írd be az új alapanyag nevét, ha nincs benne. Az üres sorok nem mentődnek.</p>

                <div class="form_group">
                    <div id="ingredients">
                        @for ($i = 0; $i < $ingredientCount; $i++)
                            @php
                                $ingredientName = '';
                                $ingredientQuantity = '';
                                $ingredientUnit = '';
                                if (isset($ingredientValues[$i])) {
                                    $ingredientName = $ingredientValues[$i]['name'];
                                    $ingredientQuantity = $ingredientValues[$i]['quantity'];
                                    $ingredientUnit = $ingredientValues[$i]['unit'];
                                }
                            @endphp
                            <div class="ingredient_item">
                                <input type="text" name="ingredients[{{ $i }}][name]" list="ingredient_options" value="{{ old('ingredients.' . $i . '.name', $ingredientName) }}" placeholder="Alapanyag neve" minlength="2" maxlength="50">

                                <input type="number" name="ingredients[{{ $i }}][quantity]" step="0.01" min="0.1" max="10000" placeholder="Mennyiség" value="{{ old('ingredients.' . $i . '.quantity', $ingredientQuantity) }}">

                                <select name="ingredients[{{ $i }}][unit]">
                                    <option value="">-- Mértékegység --</option>
                                    @foreach ($units as $unitId => $unitName)
                                        <option value="{{ $unitId }}" @if (strval(old('ingredients.' . $i . '.unit', $ingredientUnit)) === strval($unitId)) selected @endif>{{ $unitName }}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="remove_row" title="Alapanyag eltávolítása" onclick="removeRow(this)" @if ($ingredientCount <= 3) disabled @endif>×</button>

                                @error('ingredients.' . $i . '.name')
                                    <span class="error_message">{{ $message }}</span>
                                @enderror
                                @error('ingredients.' . $i . '.quantity')
                                    <span class="error_message">{{ $message }}</span>
                                @enderror
                                @error('ingredients.' . $i . '.unit')
                                    <span class="error_message">{{ $message }}</span>
                                @enderror
                            </div>
                        @endfor
                    </div>

                    <datalist id="ingredient_options">
                        @foreach ($ingredients as $ingredient)
                            <option value="{{ $ingredient->name }}"></option>
                        @endforeach
                    </datalist>

                    <button type="button" class="white_button" onclick="addRow(ingredientsContainer)">+ Alapanyag hozzáadása</button>

                    @error('ingredients')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="box">
                <h2 class="box_title">
                    <span class="title_icon"><i data-lucide="tags"></i></span>
                    Kategóriák
                </h2>

                <div class="category_group">
                    <h3>Napszak <span class="error_message">*</span></h3>
                    <div class="checkboxes">
                        @foreach ($mealTimes as $item)
                            <label>
                                <input type="checkbox" name="meal_times[]" value="{{ $item->id }}" @if (in_array($item->id, $checkedMealTimes)) checked @endif>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('meal_times')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category_group">
                    <h3>Étel típusa <span class="error_message">*</span></h3>
                    <div class="checkboxes">
                        @foreach ($foodTypes as $item)
                            <label>
                                <input type="checkbox" name="food_types[]" value="{{ $item->id }}" @if (in_array($item->id, $checkedFoodTypes)) checked @endif>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('food_types')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category_group">
                    <h3>Étrend <span class="error_message">*</span></h3>
                    <div class="checkboxes">
                        @foreach ($diets as $item)
                            <label>
                                <input type="checkbox" name="diets[]" value="{{ $item->id }}" @if (in_array($item->id, $checkedDiets)) checked @endif>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('diets')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category_group">
                    <h3>Mentesség</h3>
                    <p class="hint">Jelöld be, amitől a recept mentes.</p>
                    <div class="checkboxes">
                        @foreach ($freeFroms as $item)
                            <label>
                                <input type="checkbox" name="free_from[]" value="{{ $item->id }}" @if (in_array($item->id, $checkedFreeFroms)) checked @endif>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('free_from')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="category_group">
                    <h3>Konyha <span class="error_message">*</span></h3>
                    <div class="checkboxes">
                        @foreach ($cuisines as $item)
                            <label>
                                <input type="checkbox" name="cuisines[]" value="{{ $item->id }}" @if (in_array($item->id, $checkedCuisines)) checked @endif>
                                @if ($item->thumbnail)
                                    <img src="{{ asset($item->thumbnail) }}" alt="" class="category_icon">
                                @endif
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('cuisines')
                        <span class="error_message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ($isEdit)
                <button type="submit" class="big_button orange">Módosítások mentése</button>
            @else
                <button type="submit" class="big_button orange">Recept feltöltése</button>
            @endif
        </form>
    </div>

    <script>
        const stepsContainer = document.getElementById('steps');
        const ingredientsContainer = document.getElementById('ingredients');

        function addRow(container) {
            const newRow = container.lastElementChild.cloneNode(true);

            const fields = newRow.querySelectorAll('input, select');
            for (let i = 0; i < fields.length; i++) {
                fields[i].value = '';
            }

            const errors = newRow.querySelectorAll('.error_message');
            for (let i = 0; i < errors.length; i++) {
                errors[i].remove();
            }

            container.appendChild(newRow);
            renumberRows();
        }

        function removeRow(button) {
            const row = button.parentElement;
            const container = row.parentElement;
            if (container.children.length <= 3) {
                return;
            }

            row.remove();
            renumberRows();
        }

        function renumberRows() {
            const steps = stepsContainer.children;
            for (let i = 0; i < steps.length; i++) {
                const input = steps[i].querySelector('input');
                input.name = 'steps[' + i + '][description]';
                input.placeholder = 'Add meg a(z) ' + (i + 1) + '. lépést';
                steps[i].querySelector('label').textContent = (i + 1) + '. lépés';
                steps[i].querySelector('select').name = 'steps[' + i + '][step_category_id]';
                steps[i].querySelector('.remove_row').disabled = steps.length <= 3;
            }

            const ingredients = ingredientsContainer.children;
            for (let i = 0; i < ingredients.length; i++) {
                const inputs = ingredients[i].querySelectorAll('input');
                inputs[0].name = 'ingredients[' + i + '][name]';
                inputs[1].name = 'ingredients[' + i + '][quantity]';
                ingredients[i].querySelector('select').name = 'ingredients[' + i + '][unit]';
                ingredients[i].querySelector('.remove_row').disabled = ingredients.length <= 3;
            }
        }
    </script>
@endsection
