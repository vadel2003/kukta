<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\MealTime;
use App\Models\FoodType;
use App\Models\Diet;
use App\Models\Allergen;
use App\Models\Cuisine;

class RecipeController extends Controller
{
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $allergens = Allergen::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();
        return view('recipes.create', compact('ingredients', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'step1' => ['nullable', 'string', 'max:255'],
            'step2' => ['nullable', 'string', 'max:255'],
            'step3' => ['nullable', 'string', 'max:255'],
            'step4' => ['nullable', 'string', 'max:255'],
            'step5' => ['nullable', 'string', 'max:255'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.id' => ['required', 'exists:ingredient,id'],
            'ingredients.*.quantity' => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required', 'string', 'max:50'],
            'meal_times' => ['nullable', 'array'],
            'meal_times.*' => ['exists:meal_time,id'],
            'food_types' => ['nullable', 'array'],
            'food_types.*' => ['exists:food_type,id'],
            'diet' => ['nullable', 'integer', 'exists:diet,id'],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['exists:allergen,id'],
            'cuisines' => ['nullable', 'array'],
            'cuisines.*' => ['exists:cuisine,id'],
            'thumbnail_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'default_image' => ['nullable', 'string'],
        ]);

        // 1. Recept létrehozása
        $thumbnail = null;

        // Saját kép feltöltése
        if ($request->hasFile('thumbnail_image')) {
            $file = $request->file('thumbnail_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/recipes'), $filename);
            $thumbnail = 'images/recipes/' . $filename;
        }
        // Előre definiált kép választása
        elseif (!empty($validated['default_image'])) {
            $thumbnail = $validated['default_image'];
        }

        $recipe = Recipe::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'thumbnail' => $thumbnail,
            'creation_date' => now(),
            'user_id' => Auth::id(),
        ]);

        // 2. Lépések feldolgozása (csak a nem üreseket menti)
        $stepNumber = 1;
        for ($i = 1; $i <= 5; $i++) {
            $stepField = 'step' . $i;
            if (!empty($validated[$stepField])) {
                Step::create([
                    'description' => $validated[$stepField],
                    'recipe_id' => $recipe->id,
                    'order' => $stepNumber,
                ]);
                $stepNumber++;
            }
        }

        // 3. Alapanyagok feldolgozása
        foreach ($validated['ingredients'] as $ingredient) {
            if (!empty($ingredient['id'])) {
                $recipe->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ]);
            }
        }

        // 4. Kategóriák mentése
        if (!empty($validated['meal_times'])) {
            $recipe->mealTimes()->attach($validated['meal_times']);
        }
        if (!empty($validated['food_types'])) {
            $recipe->foodTypes()->attach($validated['food_types']);
        }
        if (!empty($validated['diet'])) {
            $recipe->diets()->attach($validated['diet']);
        }
        if (!empty($validated['allergens'])) {
            $recipe->allergens()->attach($validated['allergens']);
        }
        if (!empty($validated['cuisines'])) {
            $recipe->cuisines()->attach($validated['cuisines']);
        }

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen feltöltve!');
    }

    public function myRecipes()
    {
        $myRecipes = Recipe::where('user_id', Auth::id())
            ->orderBy('creation_date', 'desc')
            ->get();

        return view('recipes.my', compact('myRecipes'));
    }

    public function favorites()
    {
        return view('recipes.favorites');
    }

    public function show($id)
    {
        $recipe = Recipe::with(['user', 'steps' => function($query) {
            $query->orderBy('order');
        }, 'ingredients'])->findOrFail($id);

        return view('recipes.show', compact('recipe'));
    }
}

