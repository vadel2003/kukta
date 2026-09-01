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
use App\Models\Favorite;
use App\Models\Score;

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
            'steps' => ['nullable', 'array'],
            'steps.*' => ['nullable', 'string', 'max:255'],
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
        if (!empty($validated['steps'])) {
            $stepNumber = 1;
            foreach ($validated['steps'] as $stepDescription) {
                if (!empty($stepDescription)) {
                    Step::create([
                        'description' => $stepDescription,
                        'recipe_id' => $recipe->id,
                        'order' => $stepNumber,
                    ]);
                    $stepNumber++;
                }
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
            ->withCount('favorites')
            ->orderBy('creation_date', 'desc')
            ->get();

        return view('recipes.my', compact('myRecipes'));
    }

    public function favorites()
    {
        $favoriteRecipes = Auth::user()->favorites()
            ->with('recipe.user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('recipe');

        $favoriteRecipes->loadCount('favorites');

        return view('recipes.favorites', compact('favoriteRecipes'));
    }

    public function toggleFavorite($id)
    {
        $recipe = Recipe::findOrFail($id);
        $user = Auth::user();

        $existing = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
        }

        return back();
    }

    public function show($id)
    {
        $recipe = Recipe::with(['user', 'steps' => function($query) {
            $query->orderBy('order');
        }, 'ingredients', 'scores.user'])->findOrFail($id);

        $isFavorited = Auth::check() && Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->exists();

        $favoriteCount = $recipe->favorites()->count();

        $averageScore = round($recipe->averageScore() ?? 0, 1);
        $scoreCount = $recipe->scores()->count();
        $userScore = Auth::check() ? $recipe->scores()->where('user_id', Auth::id())->first() : null;

        // Eloszlás számítása
        $distribution = $recipe->scores()
            ->selectRaw('score, COUNT(*) as count')
            ->groupBy('score')
            ->pluck('count', 'score')
            ->toArray();

        $distributionPercentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $distribution[$i] ?? 0;
            $percentage = $scoreCount > 0 ? round(($count / $scoreCount) * 100) : 0;
            $distributionPercentages[$i] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        return view('recipes.show', compact('recipe', 'isFavorited', 'favoriteCount', 'averageScore', 'scoreCount', 'userScore', 'distributionPercentages'));
    }

    public function storeScore(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        $recipe = Recipe::findOrFail($id);

        Score::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'recipe_id' => $recipe->id,
            ],
            [
                'score' => $request->score,
            ]
        );

        // AJAX válasz
        if ($request->ajax()) {
            $averageScore = round($recipe->averageScore(), 1);
            $scoreCount = $recipe->scores()->count();

            $distribution = $recipe->scores()
                ->selectRaw('score, COUNT(*) as count')
                ->groupBy('score')
                ->pluck('count', 'score')
                ->toArray();

            $distributionPercentages = [];
            for ($i = 5; $i >= 1; $i--) {
                $count = $distribution[$i] ?? 0;
                $percentage = $scoreCount > 0 ? round(($count / $scoreCount) * 100) : 0;
                $distributionPercentages[$i] = [
                    'count' => $count,
                    'percentage' => $percentage,
                ];
            }

            return response()->json([
                'success' => true,
                'averageScore' => $averageScore,
                'scoreCount' => $scoreCount,
                'distribution' => $distributionPercentages,
            ]);
        }

        return redirect()->route('recipes.show', $id)->with('success', 'Értékelés mentve!');
    }

    public function edit($id)
    {
        $recipe = Recipe::with(['steps', 'ingredients', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $ingredients = Ingredient::orderBy('name')->get();
        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $allergens = Allergen::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        return view('recipes.create', compact('recipe', 'ingredients', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines'));
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'steps' => ['nullable', 'array'],
            'steps.*' => ['nullable', 'string', 'max:255'],
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

        // 1. Kép frissítése
        $thumbnail = $recipe->thumbnail;

        if ($request->hasFile('thumbnail_image')) {
            $file = $request->file('thumbnail_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/recipes'), $filename);
            $thumbnail = 'images/recipes/' . $filename;
        } elseif (!empty($validated['default_image'])) {
            $thumbnail = $validated['default_image'];
        }

        // 2. Recept adatok frissítése
        $recipe->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'thumbnail' => $thumbnail,
        ]);

        // 3. Lépések frissítése (régi törlése, új beszúrása)
        $recipe->steps()->delete();

        if (!empty($validated['steps'])) {
            $stepNumber = 1;
            foreach ($validated['steps'] as $stepDescription) {
                if (!empty($stepDescription)) {
                    Step::create([
                        'description' => $stepDescription,
                        'recipe_id' => $recipe->id,
                        'order' => $stepNumber,
                    ]);
                    $stepNumber++;
                }
            }
        }

        // 4. Alapanyagok frissítése (sync törli a régieket és beszúrja az újakat)
        $ingredientData = [];
        foreach ($validated['ingredients'] as $ingredient) {
            if (!empty($ingredient['id'])) {
                $ingredientData[$ingredient['id']] = [
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ];
            }
        }
        $recipe->ingredients()->sync($ingredientData);

        // 5. Kategóriák frissítése
        $recipe->mealTimes()->sync($validated['meal_times'] ?? []);
        $recipe->foodTypes()->sync($validated['food_types'] ?? []);
        $recipe->diets()->sync($validated['diet'] ?? []);
        $recipe->allergens()->sync($validated['allergens'] ?? []);
        $recipe->cuisines()->sync($validated['cuisines'] ?? []);

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen módosítva!');
    }

    public function destroy($id)
    {
        $recipe = Recipe::where('user_id', Auth::id())->findOrFail($id);
        $recipe->delete();

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen törölve!');
    }
}

