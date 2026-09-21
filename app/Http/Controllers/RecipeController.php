<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\StepCategory;
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
        $stepCategories = StepCategory::orderBy('id')->get();
        return view('recipes.create', compact('ingredients', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines', 'stepCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:1', 'max:1440'],
            'difficulty' => ['required', 'string', Rule::in(['könnyű', 'közepes', 'nehéz'])],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'max:1000'],
            'steps.*.step_category_id' => ['nullable', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'numeric', 'min:0.1'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:20'],
            'meal_times' => ['nullable', 'array'],
            'meal_times.*' => ['exists:meal_time,id'],
            'food_types' => ['required', 'array', 'min:1'],
            'food_types.*' => ['exists:food_type,id'],
            'diet' => ['nullable', 'integer', 'exists:diet,id'],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['exists:allergen,id'],
            'cuisines' => ['nullable', 'array'],
            'cuisines.*' => ['exists:cuisine,id'],
            'thumbnail_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'default_image' => ['nullable', 'string'],
        ], [
            'food_types.required' => 'Válassz legalább egy ételtípust!',
            'food_types.min' => 'Válassz legalább egy ételtípust!',
            'ingredients.*.quantity.min' => 'A mennyiség legalább 0,1 legyen!',
        ]);

        // Lépések előfeldolgozása: üres sor kihagyása + kategória kötelező
        $stepsToSave = [];
        if (!empty($validated['steps'])) {
            foreach ($validated['steps'] as $stepData) {
                $description = trim($stepData['description'] ?? '');
                $categoryId = $stepData['step_category_id'] ?? null;

                // Üres leírás -> nem mentünk felesleges üres adatot
                if ($description === '') {
                    continue;
                }
                // Van leírás, de nincs kategória -> hiba (még mentés előtt)
                if (empty($categoryId)) {
                    return back()
                        ->withErrors(['steps' => 'Minden lépéshez válassz kategóriát!'])
                        ->withInput();
                }
                $stepsToSave[] = [
                    'description' => $description,
                    'step_category_id' => $categoryId,
                ];
            }
        }

        // Alapanyagok előfeldolgozása (üres sor kihagyása, mennyiség + mértékegység kötelező)
        $ingredientsToSave = [];
        foreach ($validated['ingredients'] ?? [] as $ingredient) {
            $name = trim($ingredient['name'] ?? '');
            $quantity = $ingredient['quantity'] ?? null;
            $unit = trim($ingredient['unit'] ?? '');

            // Üres sor (nincs név) -> kihagyjuk, nem mentünk felesleges adatot
            if ($name === '') {
                continue;
            }

            // Van név, de nincs mennyiség -> hiba
            if ($quantity === null || $quantity === '') {
                return back()
                    ->withErrors(['ingredients' => 'Minden alapanyaghoz adj meg mennyiséget!'])
                    ->withInput();
            }
            // Van név, de nincs mértékegység -> hiba
            if ($unit === '') {
                return back()
                    ->withErrors(['ingredients' => 'Minden alapanyaghoz válassz mértékegységet!'])
                    ->withInput();
            }

            $ingredientsToSave[] = [
                'name' => $name,
                'quantity' => $quantity,
                'unit' => $unit,
            ];
        }

        // Kötelező minimumok ellenőrzése
        if (count($stepsToSave) < 3) {
            return back()
                ->withErrors(['steps' => 'Adj meg legalább 3 lépést!'])
                ->withInput();
        }
        if (count($ingredientsToSave) < 3) {
            return back()
                ->withErrors(['ingredients' => 'Adj meg legalább 3 alapanyagot!'])
                ->withInput();
        }

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
            'prep_time' => $validated['prep_time'],
            'difficulty' => $validated['difficulty'],
            'servings' => $validated['servings'],
            'thumbnail' => $thumbnail,
            'creation_date' => now(),
            'user_id' => Auth::id(),
        ]);

        // 2. Lépések mentése (csak a kitöltött, érvényes sorok)
        $stepNumber = 1;
        foreach ($stepsToSave as $stepData) {
            Step::create([
                'description' => $stepData['description'],
                'step_category_id' => $stepData['step_category_id'],
                'recipe_id' => $recipe->id,
                'order' => $stepNumber,
            ]);
            $stepNumber++;
        }

        // 3. Alapanyagok feldolgozása
        foreach ($ingredientsToSave as $ingredient) {
            $ingredientModel = Ingredient::firstOrCreate(['name' => $ingredient['name']]);
            $recipe->ingredients()->attach($ingredientModel->id, [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
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

    public function myRecipes(Request $request)
    {
        $hasAnyRecipes = Recipe::where('user_id', Auth::id())->exists();

        $query = Recipe::where('user_id', Auth::id())
            ->withCount('favorites')
            ->withCount('scores')
            ->withAvg('scores', 'score')
            ->searchAndFilter($request);

        $sort = $request->input('sort', 'relevance');
        $search = $request->input('search');

        switch ($sort) {
            case 'date':
                $query->orderBy('creation_date', 'desc');
                break;

            case 'popularity':
                $query->withCount('favorites')
                    ->orderBy('favorites_count', 'desc');
                break;

            default: // relevance
                if ($search) {
                    $query->orderByRaw('CASE WHEN title LIKE ? THEN 1 WHEN description LIKE ? THEN 2 ELSE 3 END', ["%{$search}%", "%{$search}%"]);
                }
                $query->orderBy('creation_date', 'desc');
        }

        $myRecipes = $query->paginate(21);

        // Kellhet a szív-gomb állapotához, ha valaki a saját receptjét is kedvencnek jelölte
        $favoriteIds = Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray();

        if ($request->ajax()) {
            $html = view('partials.recipe-gallery', [
                'recipes' => $myRecipes,
                'favoriteIds' => $favoriteIds,
                'showOwnerActions' => true,
            ])->render();
            return response()->json([
                'html' => $html,
                'hasMore' => $myRecipes->hasMorePages(),
            ]);
        }

        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $allergens = Allergen::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        return view('recipes.my', [
            'recipes' => $myRecipes,
            'favoriteIds' => $favoriteIds,
            'showOwnerActions' => true,
            'hasAnyRecipes' => $hasAnyRecipes,
            'mealTimes' => $mealTimes,
            'foodTypes' => $foodTypes,
            'diets' => $diets,
            'allergens' => $allergens,
            'cuisines' => $cuisines,
        ]);
    }

    public function favorites(Request $request)
    {
        $hasAnyFavorites = Favorite::where('user_id', Auth::id())->exists();

        // A recipe táblából indulunk (nem a favorites-ból), mert a keresés/szűrés a recept
        // mezőin/kapcsolatain dolgozik. A favorites táblához a bejelentkezett felhasználóra
        // szűkítve kapcsolódunk (JOIN), így csak a ténylegesen kedvencnek jelölt receptek
        // jönnek vissza, és a "favorited_at" oszlop is elérhető lesz a rendezéshez.
        $query = Recipe::query()
            ->join('favorites', function ($join) {
                $join->on('favorites.recipe_id', '=', 'recipe.id')
                    ->where('favorites.user_id', Auth::id());
            })
            ->select('recipe.*', 'favorites.created_at as favorited_at')
            ->with('user')
            ->withCount('favorites')
            ->withCount('scores')
            ->withAvg('scores', 'score')
            ->searchAndFilter($request);

        $sort = $request->input('sort', 'relevance');
        $search = $request->input('search');

        switch ($sort) {
            case 'date':
                $query->orderBy('recipe.creation_date', 'desc');
                break;

            case 'popularity':
                $query->withCount('favorites')
                    ->orderBy('favorites_count', 'desc');
                break;

            default: // relevance
                if ($search) {
                    $query->orderByRaw('CASE WHEN recipe.title LIKE ? THEN 1 WHEN recipe.description LIKE ? THEN 2 ELSE 3 END', ["%{$search}%", "%{$search}%"]);
                }
                // Külön eset a főoldalhoz/saját receptekhez képest: alapból NEM a recept
                // létrehozási dátuma, hanem a kedvencnek jelölés ideje szerint rendezünk -
                // így a legutóbb kedvencnek jelölt recept kerül előre.
                $query->orderBy('favorited_at', 'desc');
        }

        $favoriteRecipes = $query->paginate(21);
        $favoriteIds = $favoriteRecipes->pluck('id')->toArray();

        if ($request->ajax()) {
            $html = view('partials.recipe-gallery', [
                'recipes' => $favoriteRecipes,
                'favoriteIds' => $favoriteIds,
                'removeOnUnfavorite' => true,
            ])->render();
            return response()->json([
                'html' => $html,
                'hasMore' => $favoriteRecipes->hasMorePages(),
            ]);
        }

        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $allergens = Allergen::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        return view('recipes.favorites', [
            'recipes' => $favoriteRecipes,
            'favoriteIds' => $favoriteIds,
            'removeOnUnfavorite' => true,
            'hasAnyFavorites' => $hasAnyFavorites,
            'mealTimes' => $mealTimes,
            'foodTypes' => $foodTypes,
            'diets' => $diets,
            'allergens' => $allergens,
            'cuisines' => $cuisines,
        ]);
    }

    public function toggleFavorite(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        $user = Auth::user();

        $existing = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
            $isFavorited = true;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'isFavorited' => $isFavorited,
                'favoriteCount' => $recipe->favorites()->count(),
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

    public function assistant($id)
    {
        $recipe = Recipe::with([
            'steps' => fn ($q) => $q->orderBy('order'),
            'ingredients',
        ])->findOrFail($id);

        $averageScore = round($recipe->averageScore() ?? 0, 1);
        $userScore = Auth::check()
            ? $recipe->scores()->where('user_id', Auth::id())->first()
            : null;

        return view('recipes.assistant', compact('recipe', 'averageScore', 'userScore'));
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

    // Nem bejelentkezett felhasználó csillagra kattintásából induló értékelés:
    // ha még nincs bejelentkezve, elküldjük a login oldalra, onnan sikeres belépés
    // után automatikusan visszatér ide és lementjük az értékelést.
    public function rateViaLink(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        $score = (int) $request->query('score');

        if ($score < 1 || $score > 5) {
            return redirect()->route('recipes.assistant', $id);
        }

        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        Score::updateOrCreate(
            ['user_id' => Auth::id(), 'recipe_id' => $recipe->id],
            ['score' => $score]
        );

        return redirect()->route('recipes.show', $id)
            ->with('success', "Sikeresen értékelted {$score} csillagra a(z) \"{$recipe->title}\" receptet!");
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
        $stepCategories = StepCategory::orderBy('id')->get();

        return view('recipes.create', compact('recipe', 'ingredients', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines', 'stepCategories'));
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:1', 'max:1440'],
            'difficulty' => ['required', 'string', Rule::in(['könnyű', 'közepes', 'nehéz'])],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'max:1000'],
            'steps.*.step_category_id' => ['nullable', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'numeric', 'min:0.1'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:20'],
            'meal_times' => ['nullable', 'array'],
            'meal_times.*' => ['exists:meal_time,id'],
            'food_types' => ['required', 'array', 'min:1'],
            'food_types.*' => ['exists:food_type,id'],
            'diet' => ['nullable', 'integer', 'exists:diet,id'],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['exists:allergen,id'],
            'cuisines' => ['nullable', 'array'],
            'cuisines.*' => ['exists:cuisine,id'],
            'thumbnail_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'default_image' => ['nullable', 'string'],
        ], [
            'food_types.required' => 'Válassz legalább egy ételtípust!',
            'food_types.min' => 'Válassz legalább egy ételtípust!',
            'ingredients.*.quantity.min' => 'A mennyiség legalább 0,1 legyen!',
        ]);

        // Lépések előfeldolgozása: üres sor kihagyása + kategória kötelező
        $stepsToSave = [];
        if (!empty($validated['steps'])) {
            foreach ($validated['steps'] as $stepData) {
                $description = trim($stepData['description'] ?? '');
                $categoryId = $stepData['step_category_id'] ?? null;

                if ($description === '') {
                    continue;
                }
                if (empty($categoryId)) {
                    return back()
                        ->withErrors(['steps' => 'Minden lépéshez válassz kategóriát!'])
                        ->withInput();
                }
                $stepsToSave[] = [
                    'description' => $description,
                    'step_category_id' => $categoryId,
                ];
            }
        }

        // Alapanyagok előfeldolgozása (üres sor kihagyása, mennyiség + mértékegység kötelező)
        $ingredientsToSave = [];
        foreach ($validated['ingredients'] ?? [] as $ingredient) {
            $name = trim($ingredient['name'] ?? '');
            $quantity = $ingredient['quantity'] ?? null;
            $unit = trim($ingredient['unit'] ?? '');

            // Üres sor (nincs név) -> kihagyjuk, nem mentünk felesleges adatot
            if ($name === '') {
                continue;
            }

            // Van név, de nincs mennyiség -> hiba
            if ($quantity === null || $quantity === '') {
                return back()
                    ->withErrors(['ingredients' => 'Minden alapanyaghoz adj meg mennyiséget!'])
                    ->withInput();
            }
            // Van név, de nincs mértékegység -> hiba
            if ($unit === '') {
                return back()
                    ->withErrors(['ingredients' => 'Minden alapanyaghoz válassz mértékegységet!'])
                    ->withInput();
            }

            $ingredientsToSave[] = [
                'name' => $name,
                'quantity' => $quantity,
                'unit' => $unit,
            ];
        }

        // Kötelező minimumok ellenőrzése
        if (count($stepsToSave) < 3) {
            return back()
                ->withErrors(['steps' => 'Adj meg legalább 3 lépést!'])
                ->withInput();
        }
        if (count($ingredientsToSave) < 3) {
            return back()
                ->withErrors(['ingredients' => 'Adj meg legalább 3 alapanyagot!'])
                ->withInput();
        }

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
            'prep_time' => $validated['prep_time'],
            'difficulty' => $validated['difficulty'],
            'servings' => $validated['servings'],
            'thumbnail' => $thumbnail,
        ]);

        // 3. Lépések frissítése (régi törlése, új beszúrása)
        $recipe->steps()->delete();

        $stepNumber = 1;
        foreach ($stepsToSave as $stepData) {
            Step::create([
                'description' => $stepData['description'],
                'step_category_id' => $stepData['step_category_id'],
                'recipe_id' => $recipe->id,
                'order' => $stepNumber,
            ]);
            $stepNumber++;
        }

        // 4. Alapanyagok frissítése (sync törli a régieket és beszúrja az újakat)
        $ingredientData = [];
        foreach ($ingredientsToSave as $ingredient) {
            $ingredientModel = Ingredient::firstOrCreate(['name' => $ingredient['name']]);
            $ingredientData[$ingredientModel->id] = [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ];
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
        $recipe = Recipe::findOrFail($id);

        if ($recipe->user_id !== Auth::id() && !Auth::user()?->isAdmin()) {
            abort(403);
        }

        $recipe->delete();

        return redirect()->back()->with('success', 'Recept sikeresen törölve!');
    }
}

