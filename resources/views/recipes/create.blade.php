@extends('layouts.app')

@section('title', isset($recipe) ? 'Recept szerkesztése' : 'Új recept')

@section('content')
    @php
        $isEdit = isset($recipe);

        // Lépések előkészítése szerkesztéshez (order szerint rendezve)
        $stepValues = [];
        if ($isEdit) {
            foreach ($recipe->steps->sortBy('order') as $step) {
                $stepValues[] = $step->description;
            }
        }

        // Alapanyagok előkészítése szerkesztéshez
        $ingredientValues = [];
        if ($isEdit) {
            foreach ($recipe->ingredients as $index => $ingredient) {
                $ingredientValues[$index] = [
                    'id' => $ingredient->id,
                    'quantity' => $ingredient->pivot->quantity,
                    'unit' => $ingredient->pivot->unit,
                ];
            }
        }
    @endphp

    <h1>{{ $isEdit ? 'Recept szerkesztése' : 'Új recept feltöltése' }}</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ $isEdit ? route('recipes.update', $recipe->id) : route('recipes.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="title">Recept címe</label>
            <input type="text" name="title" id="title" value="{{ old('title', $recipe->title ?? '') }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Leírás</label>
            <textarea name="description" id="description" rows="4" required>{{ old('description', $recipe->description ?? '') }}</textarea>
            @error('description')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Kép kiválasztása</label>

            <div>
                <h3>Válassz előre definiált képet</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @php
                        $defaultImages = glob(public_path('images/recipes/default/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE);
                    @endphp
                    @foreach ($defaultImages as $imagePath)
                        @php
                            $imageName = basename($imagePath);
                            $imageUrl = asset('images/recipes/default/' . $imageName);
                            $imageValue = 'images/recipes/default/' . $imageName;
                        @endphp
                        <label style="text-align: center; cursor: pointer;">
                            <input type="radio" name="default_image" value="{{ $imageValue }}"
                                {{ old('default_image', $recipe->thumbnail ?? '') == $imageValue ? 'checked' : '' }}>
                            <img src="{{ $imageUrl }}" alt="{{ $imageName }}" style="width: 100px; height: 100px; object-fit: cover; display: block;">
                            {{ $imageName }}
                        </label>
                    @endforeach
                </div>
                @error('default_image')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <h3>Vagy tölts fel saját képet</h3>
                <input type="file" name="thumbnail_image" accept="image/jpeg,image/png,image/gif,image/webp">
                @error('thumbnail_image')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label>Elkészítés lépései</label>
            <div id="steps-container">
                @php
                    // Ha szerkesztés van, a meglévő lépések; ha nincs, 5 üres mező
                    $stepCount = $isEdit && count($stepValues) > 0 ? count($stepValues) : 5;
                @endphp
                @for ($i = 0; $i < $stepCount; $i++)
                    <div class="step-item">
                        <label>{{ $i + 1 }}. lépés</label>
                        <input type="text" name="steps[]" value="{{ old('steps.' . $i, $stepValues[$i] ?? '') }}" placeholder="Add meg a(z) {{ $i + 1 }}. lépést">
                        @error('steps.' . $i)
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                @endfor
            </div>
            @error('steps')
                <span style="color: red;">{{ $message }}</span>
            @enderror
            <button type="button" id="add-step">+ Lépés hozzáadása</button>
        </div>

        <div>
            <label>Alapanyagok</label>
            <div id="ingredients">
                @for ($i = 0; $i < 5; $i++)
                    <div>
                        <select name="ingredients[{{ $i }}][id]">
                            <option value="">-- Válassz alapanyagot --</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" {{ old('ingredients.' . $i . '.id', $ingredientValues[$i]['id'] ?? '') == $ingredient->id ? 'selected' : '' }}>
                                    {{ $ingredient->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="ingredients[{{ $i }}][quantity]" step="0.1" min="0" placeholder="Mennyiség" value="{{ old('ingredients.' . $i . '.quantity', $ingredientValues[$i]['quantity'] ?? '') }}">

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

                        @error('ingredients.' . $i . '.id')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        @error('ingredients.' . $i . '.quantity')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        @error('ingredients.' . $i . '.unit')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                @endfor
            </div>
            @error('ingredients')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Kategóriák</label>

            <div>
                <h3>Napszak</h3>
                @foreach ($mealTimes as $mealTime)
                    <label>
                        <input type="checkbox" name="meal_times[]" value="{{ $mealTime->id }}"
                            {{ (is_array(old('meal_times')) && in_array($mealTime->id, old('meal_times'))) || ($isEdit && $recipe->mealTimes->contains($mealTime->id)) ? 'checked' : '' }}>
                        {{ $mealTime->name }}
                    </label>
                @endforeach
                @error('meal_times')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <h3>Étel típusa</h3>
                @foreach ($foodTypes as $foodType)
                    <label>
                        <input type="checkbox" name="food_types[]" value="{{ $foodType->id }}"
                            {{ (is_array(old('food_types')) && in_array($foodType->id, old('food_types'))) || ($isEdit && $recipe->foodTypes->contains($foodType->id)) ? 'checked' : '' }}>
                        {{ $foodType->name }}
                    </label>
                @endforeach
                @error('food_types')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <h3>Étrend</h3>
                @foreach ($diets as $diet)
                    <label>
                        <input type="radio" name="diet" value="{{ $diet->id }}"
                            {{ old('diet', $isEdit ? $recipe->diets->pluck('id')->first() ?? '' : '') == $diet->id ? 'checked' : '' }}>
                        {{ $diet->name }}
                    </label>
                @endforeach
                @error('diet')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <h3>Allergén</h3>
                @foreach ($allergens as $allergen)
                    <label>
                        <input type="checkbox" name="allergens[]" value="{{ $allergen->id }}"
                            {{ (is_array(old('allergens')) && in_array($allergen->id, old('allergens'))) || ($isEdit && $recipe->allergens->contains($allergen->id)) ? 'checked' : '' }}>
                        {{ $allergen->name }}
                    </label>
                @endforeach
                @error('allergens')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <h3>Konyha</h3>
                @foreach ($cuisines as $cuisine)
                    <label>
                        <input type="checkbox" name="cuisines[]" value="{{ $cuisine->id }}"
                            {{ (is_array(old('cuisines')) && in_array($cuisine->id, old('cuisines'))) || ($isEdit && $recipe->cuisines->contains($cuisine->id)) ? 'checked' : '' }}>
                        {{ $cuisine->name }}
                    </label>
                @endforeach
                @error('cuisines')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit">{{ $isEdit ? 'Módosítások mentése' : 'Recept feltöltése' }}</button>
    </form>

    <script>
        document.getElementById('add-step').addEventListener('click', function() {
            const container = document.getElementById('steps-container');
            const steps = container.querySelectorAll('.step-item');
            const lastStep = steps[steps.length - 1];
            const newStep = lastStep.cloneNode(true);
            const newIndex = steps.length;

            // Címke frissítése
            newStep.querySelector('label').textContent = (newIndex + 1) + '. lépés';

            // Input érték törlése
            const input = newStep.querySelector('input');
            input.value = '';
            input.placeholder = 'Add meg a(z) ' + (newIndex + 1) + '. lépést';

            // Hibaüzenet törlése (ha volt előzőleg)
            const errorSpan = newStep.querySelector('span');
            if (errorSpan) {
                errorSpan.remove();
            }

            container.appendChild(newStep);
        });
    </script>
@endsection
