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
use App\Models\FreeFrom;
use App\Models\Cuisine;
use App\Models\Favorite;
use App\Models\Rating;

class RecipeController extends Controller
{
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $freeFroms = FreeFrom::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();
        $stepCategories = StepCategory::orderBy('id')->get();
        return view('recipes.create', compact('ingredients', 'mealTimes', 'foodTypes', 'diets', 'freeFroms', 'cuisines', 'stepCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:1', 'max:1440'],
            'difficulty' => ['required', 'integer', Rule::in(array_keys(Recipe::DIFFICULTIES))],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'max:1000'],
            'steps.*.step_category_id' => ['nullable', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'numeric', 'min:0.1'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:20'],
            'meal_times' => ['required', 'array', 'min:1'],
            'meal_times.*' => ['exists:meal_time,id'],
            'food_types' => ['required', 'array', 'min:1'],
            'food_types.*' => ['exists:food_type,id'],
            'diets' => ['required', 'array', 'min:1'],
            'diets.*' => ['exists:diet,id'],
            'free_from' => ['nullable', 'array'],
            'free_from.*' => ['exists:free_from,id'],
            'cuisines' => ['required', 'array', 'min:1'],
            'cuisines.*' => ['exists:cuisine,id'],
            // kép kötelező: vagy feltöltött saját kép, vagy kiválasztott alapkép
            // A böngésző a feltöltés előtt 1240x800-as JPEG-re vágja a képet (recipes/create.blade.php).
            // A JS megkerülhető, ezért itt is ellenőrizzük: más méret/formátum nem jöhet be.
            'thumbnail_image' => ['nullable', 'required_without:default_image', 'image', 'mimes:jpeg', 'dimensions:width=1240,height=800', 'max:2048'],
            'default_image' => ['nullable', 'string'],
        ], [
            'meal_times.required' => 'Válassz legalább egy napszakot!',
            'meal_times.min' => 'Válassz legalább egy napszakot!',
            'food_types.required' => 'Válassz legalább egy ételtípust!',
            'food_types.min' => 'Válassz legalább egy ételtípust!',
            'diets.required' => 'Válassz legalább egy étrendet!',
            'diets.min' => 'Válassz legalább egy étrendet!',
            'cuisines.required' => 'Válassz legalább egy konyhát!',
            'cuisines.min' => 'Válassz legalább egy konyhát!',
            'ingredients.*.quantity.min' => 'A mennyiség legalább 0,1 legyen!',
            'thumbnail_image.required_without' => 'Tölts fel saját képet, vagy válassz egy alapképet!',
            'thumbnail_image.required' => 'Tölts fel saját képet, vagy válassz egy alapképet!',
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
            // A fájlnév saját generált név fix .jpg kiterjesztéssel (a validáció csak JPEG-et
            // enged), nem a feltöltő által megadott névből vesszük. uniqid(): egyedi azonosító,
            // hogy két egyszerre feltöltött kép ne írja felül egymást.
            $filename = time() . '_' . uniqid() . '.jpg';
            $request->file('thumbnail_image')->move(public_path('images/recipes'), $filename);
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
                'position' => $stepNumber,
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

        // 4. Kategóriák mentése (a mentességen kívül mind kötelező, ezért csak ott kell üres-ellenőrzés)
        $recipe->mealTimes()->attach($validated['meal_times']);
        $recipe->foodTypes()->attach($validated['food_types']);
        $recipe->diets()->attach($validated['diets']);
        if (!empty($validated['free_from'])) {
            $recipe->freeFroms()->attach($validated['free_from']);
        }
        $recipe->cuisines()->attach($validated['cuisines']);

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen feltöltve!');
    }

    public function myRecipes(Request $request)
    {
        $hasAnyRecipes = Recipe::where('user_id', Auth::id())->exists();

        $query = Recipe::where('user_id', Auth::id())
            ->withCount('favorites')
            ->withCount('ratings')
            ->withAvg('ratings', 'score')
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
        $freeFroms = FreeFrom::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        return view('recipes.my', [
            'recipes' => $myRecipes,
            'favoriteIds' => $favoriteIds,
            'showOwnerActions' => true,
            'hasAnyRecipes' => $hasAnyRecipes,
            'mealTimes' => $mealTimes,
            'foodTypes' => $foodTypes,
            'diets' => $diets,
            'freeFroms' => $freeFroms,
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
            ->withCount('ratings')
            ->withAvg('ratings', 'score')
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
        $freeFroms = FreeFrom::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        return view('recipes.favorites', [
            'recipes' => $favoriteRecipes,
            'favoriteIds' => $favoriteIds,
            'removeOnUnfavorite' => true,
            'hasAnyFavorites' => $hasAnyFavorites,
            'mealTimes' => $mealTimes,
            'foodTypes' => $foodTypes,
            'diets' => $diets,
            'freeFroms' => $freeFroms,
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
            $query->orderBy('position');
        }, 'ingredients', 'ratings.user'])->findOrFail($id);

        $isFavorited = Auth::check() && Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->exists();

        $favoriteCount = $recipe->favorites()->count();

        $averageRating = round($recipe->averageRating() ?? 0, 1);
        $ratingCount = $recipe->ratings()->count();
        $userRating = Auth::check() ? $recipe->ratings()->where('user_id', Auth::id())->first() : null;

        // Eloszlás számítása
        $distribution = $recipe->ratings()
            ->selectRaw('score, COUNT(*) as count')
            ->groupBy('score')
            ->pluck('count', 'score')
            ->toArray();

        $distributionPercentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $distribution[$i] ?? 0;
            $percentage = $ratingCount > 0 ? round(($count / $ratingCount) * 100) : 0;
            $distributionPercentages[$i] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        return view('recipes.show', compact('recipe', 'isFavorited', 'favoriteCount', 'averageRating', 'ratingCount', 'userRating', 'distributionPercentages'));
    }

    public function assistant($id)
    {
        $recipe = Recipe::with([
            // a lépések kategóriáját is egyben betöltjük (az animációhoz kell)
            'steps' => fn ($q) => $q->orderBy('position')->with('stepCategory'),
            'ingredients',
        ])->findOrFail($id);

        $averageRating = round($recipe->averageRating() ?? 0, 1);
        $userRating = Auth::check()
            ? $recipe->ratings()->where('user_id', Auth::id())->first()
            : null;

        return view('recipes.assistant', compact('recipe', 'averageRating', 'userRating'));
    }

    public function storeRating(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        $recipe = Recipe::findOrFail($id);

        Rating::updateOrCreate(
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
            $averageRating = round($recipe->averageRating(), 1);
            $ratingCount = $recipe->ratings()->count();

            $distribution = $recipe->ratings()
                ->selectRaw('score, COUNT(*) as count')
                ->groupBy('score')
                ->pluck('count', 'score')
                ->toArray();

            $distributionPercentages = [];
            for ($i = 5; $i >= 1; $i--) {
                $count = $distribution[$i] ?? 0;
                $percentage = $ratingCount > 0 ? round(($count / $ratingCount) * 100) : 0;
                $distributionPercentages[$i] = [
                    'count' => $count,
                    'percentage' => $percentage,
                ];
            }

            return response()->json([
                'success' => true,
                'averageRating' => $averageRating,
                'ratingCount' => $ratingCount,
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

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'recipe_id' => $recipe->id],
            ['score' => $score]
        );

        return redirect()->route('recipes.show', $id)
            ->with('success', "Sikeresen értékelted {$score} csillagra a(z) \"{$recipe->title}\" receptet!");
    }

    public function edit($id)
    {
        $recipe = Recipe::with(['steps', 'ingredients', 'mealTimes', 'foodTypes', 'diets', 'freeFroms', 'cuisines'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $ingredients = Ingredient::orderBy('name')->get();
        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $freeFroms = FreeFrom::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();
        $stepCategories = StepCategory::orderBy('id')->get();

        return view('recipes.create', compact('recipe', 'ingredients', 'mealTimes', 'foodTypes', 'diets', 'freeFroms', 'cuisines', 'stepCategories'));
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:1', 'max:1440'],
            'difficulty' => ['required', 'integer', Rule::in(array_keys(Recipe::DIFFICULTIES))],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'max:1000'],
            'steps.*.step_category_id' => ['nullable', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'numeric', 'min:0.1'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:20'],
            'meal_times' => ['required', 'array', 'min:1'],
            'meal_times.*' => ['exists:meal_time,id'],
            'food_types' => ['required', 'array', 'min:1'],
            'food_types.*' => ['exists:food_type,id'],
            'diets' => ['required', 'array', 'min:1'],
            'diets.*' => ['exists:diet,id'],
            'free_from' => ['nullable', 'array'],
            'free_from.*' => ['exists:free_from,id'],
            'cuisines' => ['required', 'array', 'min:1'],
            'cuisines.*' => ['exists:cuisine,id'],
            // kép csak akkor kötelező, ha a receptnek még nincs képe és alapképet sem választott
            'thumbnail_image' => ['nullable', Rule::requiredIf(empty($recipe->thumbnail) && !$request->filled('default_image')), 'image', 'mimes:jpeg', 'dimensions:width=1240,height=800', 'max:2048'],
            'default_image' => ['nullable', 'string'],
        ], [
            'meal_times.required' => 'Válassz legalább egy napszakot!',
            'meal_times.min' => 'Válassz legalább egy napszakot!',
            'food_types.required' => 'Válassz legalább egy ételtípust!',
            'food_types.min' => 'Válassz legalább egy ételtípust!',
            'diets.required' => 'Válassz legalább egy étrendet!',
            'diets.min' => 'Válassz legalább egy étrendet!',
            'cuisines.required' => 'Válassz legalább egy konyhát!',
            'cuisines.min' => 'Válassz legalább egy konyhát!',
            'ingredients.*.quantity.min' => 'A mennyiség legalább 0,1 legyen!',
            'thumbnail_image.required_without' => 'Tölts fel saját képet, vagy válassz egy alapképet!',
            'thumbnail_image.required' => 'Tölts fel saját képet, vagy válassz egy alapképet!',
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
            $filename = time() . '_' . uniqid() . '.jpg';
            $request->file('thumbnail_image')->move(public_path('images/recipes'), $filename);
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
                'position' => $stepNumber,
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
        $recipe->mealTimes()->sync($validated['meal_times']);
        $recipe->foodTypes()->sync($validated['food_types']);
        $recipe->diets()->sync($validated['diets']);
        $recipe->freeFroms()->sync($validated['free_from'] ?? []);
        $recipe->cuisines()->sync($validated['cuisines']);

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

