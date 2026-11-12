<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\StepCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function create()
    {
        return view('recipes.create', $this->formData());
    }

    public function store(Request $request)
    {
        $validated = $this->validateRecipe($request);

        $errors = $this->rowErrors($validated);
        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        $recipe = new Recipe(['user_id' => Auth::id()]);
        $this->saveRecipe($recipe, $request, $validated);

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen feltöltve!');
    }

    public function myRecipes(Request $request)
    {
        $query = Recipe::where('user_id', Auth::id())
            ->withCount(['favorites', 'ratings'])
            ->withAvg('ratings', 'score');
        $this->applyFilters($query, $request);
        $this->applySort($query, $request);
        $recipes = $query->paginate(21)->withQueryString();

        return view('recipes.my', [
            'recipes' => $recipes,
            'favoriteIds' => Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray(),
            'showOwnerActions' => true,
            'hasAnyRecipes' => Recipe::where('user_id', Auth::id())->exists(),
        ] + $this->filterCategories());
    }

    public function favorites(Request $request)
    {
        $favoriteIds = Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray();

        $query = Recipe::whereIn('id', $favoriteIds)
            ->with('user')
            ->withCount(['favorites', 'ratings'])
            ->withAvg('ratings', 'score');
        $this->applyFilters($query, $request);
        $this->applySort($query, $request);
        $recipes = $query->paginate(21)->withQueryString();

        return view('recipes.favorites', [
            'recipes' => $recipes,
            'favoriteIds' => $favoriteIds,
            'hasAnyFavorites' => count($favoriteIds) > 0,
        ] + $this->filterCategories());
    }

    /**
     * Favorites or unfavorites the recipe, then goes back to the same recipe card on the previous page.
     */
    public function toggleFavorite($id)
    {
        $recipe = Recipe::findOrFail($id);

        $existing = Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'recipe_id' => $recipe->id,
            ]);
        }

        return redirect(url()->previous() . '#recipe-' . $recipe->id);
    }

    public function show($id)
    {
        $recipe = Recipe::with(['user', 'steps', 'ingredients', 'ratings'])->findOrFail($id);

        $isFavorited = Auth::check() && Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->exists();

        $favoriteCount = $recipe->favorites()->count();
        $freeFroms = $recipe->freeFroms()->orderBy('free_from.id')->get();
        $averageRating = round($recipe->averageRating() ?? 0, 1);
        $ratingCount = $recipe->ratings()->count();
        $userRating = Auth::check() ? $recipe->ratings()->where('user_id', Auth::id())->first() : null;
        $distributionPercentages = $this->ratingDistribution($recipe);

        return view('recipes.show', compact('recipe', 'isFavorited', 'favoriteCount', 'freeFroms', 'averageRating', 'ratingCount', 'userRating', 'distributionPercentages'));
    }

    public function assistant($id)
    {
        $recipe = Recipe::with(['steps.stepCategory', 'ingredients'])->findOrFail($id);

        $averageRating = round($recipe->averageRating() ?? 0, 1);
        $userRating = Auth::check() ? $recipe->ratings()->where('user_id', Auth::id())->first() : null;

        return view('recipes.assistant', compact('recipe', 'averageRating', 'userRating'));
    }

    public function storeRating(Request $request, $id)
    {
        $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $recipe = Recipe::findOrFail($id);

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'recipe_id' => $recipe->id],
            ['score' => $request->score]
        );

        return redirect(route('recipes.show', $recipe->id) . '#reviews')->with('success', 'Értékelés mentve!');
    }

    /**
     * The "log in to rate" link of guests. The auth middleware sends the guest to the login page,
     * then back here, and the recipe page opens at its ratings. The rating itself is saved by storeRating() (POST).
     */
    public function loginToRate($id)
    {
        return redirect(route('recipes.show', $id) . '#reviews');
    }

    public function edit($id)
    {
        $recipe = Recipe::with(['steps', 'ingredients', 'mealTimes', 'foodTypes', 'diets', 'freeFroms', 'cuisines'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('recipes.create', ['recipe' => $recipe] + $this->formData());
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('user_id', Auth::id())->findOrFail($id);

        $validated = $this->validateRecipe($request, $recipe);

        $errors = $this->rowErrors($validated);
        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        $this->saveRecipe($recipe, $request, $validated);

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen módosítva!');
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);

        /** @var User $user */
        $user = Auth::user();

        if ($recipe->user_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $recipe->delete();

        return redirect()->back()->with('success', 'Recept sikeresen törölve!');
    }

    /**
     * Lists for the recipe form (create and edit).
     */
    private function formData(): array
    {
        return [
            'ingredients' => Ingredient::orderBy('name')->get(),
            'stepCategories' => StepCategory::orderBy('id')->get(),
        ] + $this->filterCategories();
    }

    /**
     * Validates the recipe form. Empty step and ingredient rows are skipped.
     *
     * @param  Recipe|null  $recipe  the recipe being edited (it already has an image, so uploading a new one is optional)
     * @return array the validated data, with only the filled step and ingredient rows
     */
    private function validateRecipe(Request $request, ?Recipe $recipe = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['required', 'string', 'min:5', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:3', 'max:1440'],
            'difficulty' => ['required', 'integer', 'in:' . implode(',', array_keys(Recipe::DIFFICULTIES))],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'min:5', 'max:1000'],
            'steps.*.step_category_id' => ['nullable', 'required_with:steps.*.description', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'min:2', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'required_with:ingredients.*.name', 'numeric', 'decimal:0,2', 'min:0.1', 'max:10000'],
            'ingredients.*.unit' => ['nullable', 'required_with:ingredients.*.name', 'integer', 'in:' . implode(',', array_keys(IngredientRecipe::UNITS))],
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
            'thumbnail_image' => [$recipe ? 'nullable' : 'required_without:default_image', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'default_image' => ['nullable', 'string', 'in:' . implode(',', array_keys(Recipe::DEFAULT_IMAGES))],
        ], [
            'meal_times.required' => 'Válassz legalább egy napszakot!',
            'meal_times.min' => 'Válassz legalább egy napszakot!',
            'food_types.required' => 'Válassz legalább egy ételtípust!',
            'food_types.min' => 'Válassz legalább egy ételtípust!',
            'diets.required' => 'Válassz legalább egy étrendet!',
            'diets.min' => 'Válassz legalább egy étrendet!',
            'cuisines.required' => 'Válassz legalább egy konyhát!',
            'cuisines.min' => 'Válassz legalább egy konyhát!',
            'steps.*.step_category_id.required_with' => 'Minden lépéshez válassz kategóriát!',
            'ingredients.*.quantity.required_with' => 'Minden alapanyaghoz adj meg mennyiséget!',
            'ingredients.*.quantity.min' => 'A mennyiség legalább 0,1 legyen!',
            'ingredients.*.quantity.decimal' => 'A mennyiség legfeljebb két tizedesjegyű lehet!',
            'ingredients.*.unit.required_with' => 'Minden alapanyaghoz válassz mértékegységet!',
            'thumbnail_image.required_without' => 'Tölts fel saját képet, vagy válassz egy alapképet!',
            'thumbnail_image.image' => 'Csak JPG, PNG vagy WebP képet tölthetsz fel!',
            'thumbnail_image.mimes' => 'Csak JPG, PNG vagy WebP képet tölthetsz fel!',
            'thumbnail_image.max' => 'A kép legfeljebb 2 MB lehet!',
            'thumbnail_image.uploaded' => 'A kép legfeljebb 2 MB lehet!',
        ]);

        $steps = [];
        foreach ($validated['steps'] ?? [] as $step) {
            if (!empty($step['description'])) {
                $steps[] = $step;
            }
        }

        $ingredients = [];
        foreach ($validated['ingredients'] ?? [] as $ingredient) {
            if (!empty($ingredient['name'])) {
                $ingredients[] = $ingredient;
            }
        }

        $validated['steps'] = $steps;
        $validated['ingredients'] = $ingredients;

        return $validated;
    }

    /**
     * Checks the number of filled step and ingredient rows.
     *
     * @return array error messages (empty if everything is correct)
     */
    private function rowErrors(array $validated): array
    {
        $errors = [];

        if (count($validated['steps']) < 3) {
            $errors['steps'] = 'Adj meg legalább 3 lépést!';
        }
        if (count($validated['steps']) > 50) {
            $errors['steps'] = 'Legfeljebb 50 lépést adhatsz meg!';
        }
        if (count($validated['ingredients']) < 3) {
            $errors['ingredients'] = 'Adj meg legalább 3 alapanyagot!';
        }

        return $errors;
    }

    /**
     * Saves the recipe with its image, steps, ingredients and categories.
     * Used for both create and update: the old steps and relations are replaced.
     * New ingredients are created with zero nutrition values, to be filled in by the super admin.
     */
    private function saveRecipe(Recipe $recipe, Request $request, array $validated): void
    {
        if ($request->hasFile('thumbnail_image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('thumbnail_image')->extension();
            $request->file('thumbnail_image')->move(public_path('images/recipes'), $filename);
            $recipe->thumbnail = 'images/recipes/' . $filename;
        } elseif (!empty($validated['default_image'])) {
            $recipe->thumbnail = $validated['default_image'];
        }

        $recipe->title = $validated['title'];
        $recipe->description = $validated['description'];
        $recipe->prep_time = $validated['prep_time'];
        $recipe->difficulty = $validated['difficulty'];
        $recipe->servings = $validated['servings'];
        $recipe->save();

        $recipe->steps()->delete();
        foreach ($validated['steps'] as $index => $step) {
            $recipe->steps()->create([
                'description' => $step['description'],
                'step_category_id' => $step['step_category_id'],
                'position' => $index + 1,
            ]);
        }

        $ingredientData = [];
        foreach ($validated['ingredients'] as $ingredient) {
            $ingredientModel = Ingredient::firstOrCreate(
                ['name' => $ingredient['name']],
                ['calories' => 0, 'carbohydrate' => 0, 'protein' => 0, 'fat' => 0]
            );
            $ingredientData[$ingredientModel->id] = [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ];
        }
        $recipe->ingredients()->sync($ingredientData);

        $recipe->mealTimes()->sync($validated['meal_times']);
        $recipe->foodTypes()->sync($validated['food_types']);
        $recipe->diets()->sync($validated['diets']);
        $recipe->freeFroms()->sync($validated['free_from'] ?? []);
        $recipe->cuisines()->sync($validated['cuisines']);
    }

    /**
     * Rating distribution per star (5 to 1): count and percentage.
     */
    private function ratingDistribution(Recipe $recipe): array
    {
        $total = $recipe->ratings->count();

        $distribution = [];
        for ($score = 5; $score >= 1; $score--) {
            $count = $recipe->ratings->where('score', $score)->count();
            $distribution[$score] = [
                'count' => $count,
                'percentage' => $total > 0 ? round($count / $total * 100) : 0,
            ];
        }

        return $distribution;
    }
}
