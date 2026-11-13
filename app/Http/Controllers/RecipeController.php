<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\StepCategory;
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

        $recipe = new Recipe();
        $recipe->user_id = Auth::id();
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

        $data = $this->filterCategories();
        $data['recipes'] = $recipes;
        $data['favoriteIds'] = Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray();
        $data['showOwnerActions'] = true;
        $data['hasAnyRecipes'] = Recipe::where('user_id', Auth::id())->exists();

        return view('recipes.my', $data);
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

        $data = $this->filterCategories();
        $data['recipes'] = $recipes;
        $data['favoriteIds'] = $favoriteIds;
        $data['hasAnyFavorites'] = count($favoriteIds) > 0;

        return view('recipes.favorites', $data);
    }

    /**
     * Favorites or unfavorites the recipe, then goes back to the same recipe card.
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
            $favorite = new Favorite();
            $favorite->user_id = Auth::id();
            $favorite->recipe_id = $recipe->id;
            $favorite->save();
        }

        return redirect(url()->previous() . '#recipe-' . $recipe->id);
    }

    public function show($id)
    {
        $recipe = Recipe::with(['user', 'steps', 'ingredients', 'ratings'])->findOrFail($id);

        $isFavorited = false;
        $userRating = null;
        if (Auth::check()) {
            $isFavorited = Favorite::where('user_id', Auth::id())->where('recipe_id', $recipe->id)->exists();
            $userRating = Rating::where('user_id', Auth::id())->where('recipe_id', $recipe->id)->first();
        }

        $averageRating = $recipe->averageRating();
        if ($averageRating == null) {
            $averageRating = 0;
        }

        return view('recipes.show', [
            'recipe' => $recipe,
            'isFavorited' => $isFavorited,
            'favoriteCount' => $recipe->favorites()->count(),
            'freeFroms' => $recipe->freeFroms()->orderBy('free_from.id')->get(),
            'averageRating' => round($averageRating, 1),
            'ratingCount' => $recipe->ratings()->count(),
            'userRating' => $userRating,
            'distributionPercentages' => $this->ratingDistribution($recipe),
            'units' => IngredientRecipe::UNITS,
        ]);
    }

    public function assistant($id)
    {
        $recipe = Recipe::with(['steps.stepCategory', 'ingredients'])->findOrFail($id);

        $userRating = null;
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())->where('recipe_id', $recipe->id)->first();
        }

        return view('recipes.assistant', [
            'recipe' => $recipe,
            'userRating' => $userRating,
            'units' => IngredientRecipe::UNITS,
        ]);
    }

    public function storeRating(Request $request, $id)
    {
        $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $recipe = Recipe::findOrFail($id);

        $rating = Rating::where('user_id', Auth::id())->where('recipe_id', $recipe->id)->first();
        if (!$rating) {
            $rating = new Rating();
            $rating->user_id = Auth::id();
            $rating->recipe_id = $recipe->id;
        }
        $rating->score = $request->score;
        $rating->save();

        return redirect(route('recipes.show', $recipe->id) . '#reviews')->with('success', 'Értékelés mentve!');
    }

    /**
     * The "log in to rate" link of guests: after logging in, opens the recipe page at the ratings.
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

        $data = $this->formData();
        $data['recipe'] = $recipe;

        return view('recipes.create', $data);
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
        $user = Auth::user();

        if ($recipe->user_id != $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $recipe->delete();

        return redirect()->back()->with('success', 'Recept sikeresen törölve!');
    }

    /**
     * Lists for the recipe form (create and edit).
     */
    private function formData()
    {
        $data = $this->filterCategories();
        $data['ingredients'] = Ingredient::orderBy('name')->get();
        $data['stepCategories'] = StepCategory::orderBy('id')->get();
        $data['difficulties'] = Recipe::DIFFICULTIES;
        $data['defaultImages'] = Recipe::DEFAULT_IMAGES;
        $data['units'] = IngredientRecipe::UNITS;

        return $data;
    }

    /**
     * Validates the recipe form and keeps only the filled step and ingredient rows.
     */
    private function validateRecipe(Request $request, $recipe = null)
    {
        // when editing, the recipe already has an image
        $imageRule = 'required_without:default_image';
        if ($recipe != null) {
            $imageRule = 'nullable';
        }

        $defaultImages = '';
        foreach (Recipe::DEFAULT_IMAGES as $path => $label) {
            if ($defaultImages != '') {
                $defaultImages = $defaultImages . ',';
            }
            $defaultImages = $defaultImages . $path;
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['required', 'string', 'min:5', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:3', 'max:1440'],
            'difficulty' => ['required', 'integer', 'min:0', 'max:2'],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'min:5', 'max:200'],
            'steps.*.step_category_id' => ['nullable', 'required_with:steps.*.description', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'min:2', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'required_with:ingredients.*.name', 'numeric', 'decimal:0,2', 'min:0.1', 'max:10000'],
            'ingredients.*.unit' => ['nullable', 'required_with:ingredients.*.name', 'integer', 'min:0', 'max:13'],
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
            'thumbnail_image' => [$imageRule, 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'default_image' => ['nullable', 'string', 'in:' . $defaultImages],
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
        if (isset($validated['steps'])) {
            foreach ($validated['steps'] as $step) {
                if (!empty($step['description'])) {
                    $steps[] = $step;
                }
            }
        }

        $ingredients = [];
        if (isset($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ingredient) {
                if (!empty($ingredient['name'])) {
                    $ingredients[] = $ingredient;
                }
            }
        }

        $validated['steps'] = $steps;
        $validated['ingredients'] = $ingredients;

        return $validated;
    }

    /**
     * Checks the number of filled step and ingredient rows.
     */
    private function rowErrors($validated)
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
     * Saves the recipe with its image, steps, ingredients and categories (used by store and update).
     */
    private function saveRecipe($recipe, $request, $validated)
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

        // new ingredients get 0 nutrition values, the super admin fills them in later
        $ingredientData = [];
        foreach ($validated['ingredients'] as $ingredient) {
            $ingredientModel = Ingredient::where('name', $ingredient['name'])->first();
            if (!$ingredientModel) {
                $ingredientModel = new Ingredient();
                $ingredientModel->name = $ingredient['name'];
                $ingredientModel->calories = 0;
                $ingredientModel->carbohydrate = 0;
                $ingredientModel->protein = 0;
                $ingredientModel->fat = 0;
                $ingredientModel->save();
            }
            $ingredientData[$ingredientModel->id] = [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ];
        }

        $recipe->ingredients()->detach();
        foreach ($ingredientData as $ingredientId => $pivot) {
            $recipe->ingredients()->attach($ingredientId, $pivot);
        }

        $freeFroms = [];
        if (isset($validated['free_from'])) {
            $freeFroms = $validated['free_from'];
        }

        $recipe->mealTimes()->sync($validated['meal_times']);
        $recipe->foodTypes()->sync($validated['food_types']);
        $recipe->diets()->sync($validated['diets']);
        $recipe->freeFroms()->sync($freeFroms);
        $recipe->cuisines()->sync($validated['cuisines']);
    }

    /**
     * Number and percentage of ratings per star (5 to 1).
     */
    private function ratingDistribution($recipe)
    {
        $total = $recipe->ratings->count();

        $distribution = [];
        for ($score = 5; $score >= 1; $score--) {
            $count = $recipe->ratings->where('score', $score)->count();

            $percentage = 0;
            if ($total > 0) {
                $percentage = round($count / $total * 100);
            }

            $distribution[$score] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        return $distribution;
    }
}
