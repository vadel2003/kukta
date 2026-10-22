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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RecipeController extends Controller
{
    public function create()
    {
        return view('recipes.create', $this->formData());
    }

    public function store(Request $request)
    {
        [$validated, $steps, $ingredients] = $this->validateRecipe($request);

        $recipe = new Recipe(['user_id' => Auth::id()]);
        $this->saveRecipe($recipe, $request, $validated, $steps, $ingredients);

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen feltöltve!');
    }

    public function myRecipes(Request $request)
    {
        $recipes = Recipe::where('user_id', Auth::id())
            ->withCount(['favorites', 'ratings'])
            ->withAvg('ratings', 'score')
            ->searchAndFilter($request)
            ->applySort($request)
            ->paginate(21);

        return $this->recipeListResponse($request, 'recipes.my', [
            'recipes' => $recipes,
            'favoriteIds' => Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray(),
            'showOwnerActions' => true,
            'hasAnyRecipes' => Recipe::where('user_id', Auth::id())->exists(),
        ]);
    }

    /**
     * The logged-in user's favorite recipes, sorted by the time they were favorited by default.
     */
    public function favorites(Request $request)
    {
        $recipes = Recipe::query()
            ->join('favorites', function ($join) {
                $join->on('favorites.recipe_id', '=', 'recipe.id')
                    ->where('favorites.user_id', Auth::id());
            })
            ->select('recipe.*', 'favorites.created_at as favorited_at')
            ->with('user')
            ->withCount(['favorites', 'ratings'])
            ->withAvg('ratings', 'score')
            ->searchAndFilter($request)
            ->applySort($request, 'favorited_at')
            ->paginate(21);

        return $this->recipeListResponse($request, 'recipes.favorites', [
            'recipes' => $recipes,
            'favoriteIds' => $recipes->pluck('id')->toArray(),
            'removeOnUnfavorite' => true,
            'hasAnyFavorites' => Favorite::where('user_id', Auth::id())->exists(),
        ]);
    }

    public function toggleFavorite(Request $request, $id)
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

        if ($request->ajax()) {
            return response()->json([
                'isFavorited' => !$existing,
                'favoriteCount' => $recipe->favorites()->count(),
            ]);
        }

        return back();
    }

    public function show($id)
    {
        $recipe = Recipe::with([
            'user',
            'steps' => fn ($query) => $query->orderBy('position'),
            'ingredients',
            'ratings.user',
        ])->findOrFail($id);

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
        $recipe = Recipe::with([
            'steps' => fn ($query) => $query->orderBy('position')->with('stepCategory'),
            'ingredients',
        ])->findOrFail($id);

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

        if ($request->ajax()) {
            return response()->json([
                'averageRating' => round($recipe->averageRating(), 1),
                'ratingCount' => $recipe->ratings()->count(),
                'distribution' => $this->ratingDistribution($recipe),
            ]);
        }

        return redirect()->route('recipes.show', $id)->with('success', 'Értékelés mentve!');
    }

    /**
     * Rating from a link (GET ?score=1..5), used when a guest clicks a star.
     * Guests are sent to the login page and redirected back here after login to save the rating.
     */
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

        return view('recipes.create', ['recipe' => $recipe] + $this->formData());
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('user_id', Auth::id())->findOrFail($id);

        [$validated, $steps, $ingredients] = $this->validateRecipe($request, $recipe);

        $this->saveRecipe($recipe, $request, $validated, $steps, $ingredients);

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
     * @param  Recipe|null  $recipe  the recipe being edited (if it has an image, uploading a new one is optional)
     * @return array [validated data, filled steps, filled ingredients]
     *
     * @throws ValidationException
     */
    private function validateRecipe(Request $request, ?Recipe $recipe = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['required', 'string', 'min:5', 'max:1000'],
            'prep_time' => ['required', 'integer', 'min:3', 'max:1440'],
            'difficulty' => ['required', 'integer', Rule::in(array_keys(Recipe::DIFFICULTIES))],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string', 'min:5', 'max:1000'],
            'steps.*.step_category_id' => ['nullable', 'integer', 'exists:step_category,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'min:2', 'max:50'],
            'ingredients.*.quantity' => ['nullable', 'numeric', 'decimal:0,2', 'min:0.1', 'max:10000'],
            'ingredients.*.unit' => ['nullable', 'integer', Rule::in(array_keys(IngredientRecipe::UNITS))],
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
            'thumbnail_image' => ['nullable', Rule::requiredIf(empty($recipe?->thumbnail) && !$request->filled('default_image')), 'image', 'mimes:jpeg,jpg,png,webp', 'dimensions:width=1240,height=800', 'max:2048'],
            'default_image' => ['nullable', 'string', Rule::in(array_keys(Recipe::DEFAULT_IMAGES))],
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
            'ingredients.*.quantity.decimal' => 'A mennyiség legfeljebb két tizedesjegyű lehet!',
            'thumbnail_image.required' => 'Tölts fel saját képet, vagy válassz egy alapképet!',
        ]);

        $steps = [];
        foreach ($validated['steps'] ?? [] as $step) {
            if (empty($step['description'])) {
                continue;
            }
            if (empty($step['step_category_id'])) {
                throw ValidationException::withMessages(['steps' => 'Minden lépéshez válassz kategóriát!']);
            }
            $steps[] = $step;
        }

        $ingredients = [];
        foreach ($validated['ingredients'] ?? [] as $ingredient) {
            if (empty($ingredient['name'])) {
                continue;
            }
            if (!isset($ingredient['quantity'])) {
                throw ValidationException::withMessages(['ingredients' => 'Minden alapanyaghoz adj meg mennyiséget!']);
            }
            if (!isset($ingredient['unit'])) {
                throw ValidationException::withMessages(['ingredients' => 'Minden alapanyaghoz válassz mértékegységet!']);
            }
            $ingredients[] = $ingredient;
        }

        if (count($steps) < 3) {
            throw ValidationException::withMessages(['steps' => 'Adj meg legalább 3 lépést!']);
        }
        if (count($steps) > 50) {
            throw ValidationException::withMessages(['steps' => 'Legfeljebb 50 lépést adhatsz meg!']);
        }
        if (count($ingredients) < 3) {
            throw ValidationException::withMessages(['ingredients' => 'Adj meg legalább 3 alapanyagot!']);
        }

        return [$validated, $steps, $ingredients];
    }

    /**
     * Saves the recipe with its image, steps, ingredients and categories.
     * Used for both create and update: the old steps and relations are replaced.
     * New ingredients are created with zero nutrition values, to be filled in by the super admin.
     */
    private function saveRecipe(Recipe $recipe, Request $request, array $validated, array $steps, array $ingredients): void
    {
        if ($request->hasFile('thumbnail_image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('thumbnail_image')->extension();
            $request->file('thumbnail_image')->move(public_path('images/recipes'), $filename);
            $recipe->thumbnail = 'images/recipes/' . $filename;
        } elseif (!empty($validated['default_image'])) {
            $recipe->thumbnail = $validated['default_image'];
        }

        $recipe->fill(Arr::only($validated, ['title', 'description', 'prep_time', 'difficulty', 'servings']));
        $recipe->save();

        $recipe->steps()->delete();
        foreach ($steps as $index => $step) {
            $recipe->steps()->create([
                'description' => $step['description'],
                'step_category_id' => $step['step_category_id'],
                'position' => $index + 1,
            ]);
        }

        $ingredientData = [];
        foreach ($ingredients as $ingredient) {
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
     *
     * @return array<int, array{count: int, percentage: float}>
     */
    private function ratingDistribution(Recipe $recipe): array
    {
        $counts = $recipe->ratings()
            ->selectRaw('score, COUNT(*) as count')
            ->groupBy('score')
            ->pluck('count', 'score');
        $total = $counts->sum();

        $distribution = [];
        for ($score = 5; $score >= 1; $score--) {
            $count = $counts[$score] ?? 0;
            $distribution[$score] = [
                'count' => $count,
                'percentage' => $total > 0 ? round($count / $total * 100) : 0,
            ];
        }

        return $distribution;
    }
}
