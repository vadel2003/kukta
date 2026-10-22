<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Super admin pages. Access is checked by the route group (middleware('can:admin')).
 */
class AdminController extends Controller
{
    public function ingredients(Request $request)
    {
        $search = $request->query('search');
        [$sort, $direction] = $this->sortParams($request, ['name', 'calories', 'carbohydrate', 'protein', 'fat'], 'name', 'asc');

        $ingredients = Ingredient::withCount('recipes')
            ->when($search, fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->orderBy($sort, $direction)
            ->get();

        return view('admin.ingredients', compact('ingredients', 'search', 'sort', 'direction'));
    }

    public function storeIngredient(Request $request)
    {
        Ingredient::create($request->validate($this->ingredientRules()));

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen létrehozva!');
    }

    public function updateIngredient(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        $ingredient->update($request->validate($this->ingredientRules($ingredient)));

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen módosítva!');
    }

    /**
     * An ingredient used in a recipe cannot be deleted.
     */
    public function destroyIngredient($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        if ($ingredient->recipes()->exists()) {
            return redirect()->route('admin.ingredients')
                ->withErrors('A(z) „' . $ingredient->name . '” alapanyag nem törölhető, mert receptekben használatban van.');
        }

        $ingredient->delete();

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen törölve!');
    }

    /**
     * Deletes only those selected ingredients that are not used in any recipe.
     */
    public function bulkDestroyIngredients(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:ingredient,id'],
        ]);

        Ingredient::whereIn('id', $validated['ids'])->doesntHave('recipes')->delete();

        return redirect()->route('admin.ingredients')->with('success', 'A kijelölt alapanyagok sikeresen törölve!');
    }

    public function recipes(Request $request)
    {
        $search = $request->query('search');
        [$sort, $direction] = $this->sortParams($request, ['title', 'user', 'created_at'], 'created_at', 'desc');

        $recipesQuery = Recipe::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', '%' . $search . '%'));
            });

        if ($sort === 'user') {
            $recipesQuery->leftJoin('user', 'user.id', '=', 'recipe.user_id')
                ->orderBy('user.name', $direction)
                ->select('recipe.*');
        } else {
            $recipesQuery->orderBy($sort, $direction);
        }

        $recipes = $recipesQuery->get();

        return view('admin.recipes', compact('recipes', 'search', 'sort', 'direction'));
    }

    public function bulkDestroyRecipes(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:recipe,id'],
        ]);

        Recipe::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.recipes')->with('success', 'A kijelölt receptek sikeresen törölve!');
    }

    public function users(Request $request)
    {
        $search = $request->query('search');
        [$sort, $direction] = $this->sortParams($request, ['id', 'name', 'email', 'is_admin'], 'name', 'asc');

        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->orderBy($sort, $direction)
            ->get();

        return view('admin.users', compact('users', 'search', 'sort', 'direction'));
    }

    /**
     * The super admin and the current user's own account cannot be deleted.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin() || $user->id === Auth::id()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Felhasználó sikeresen törölve!');
    }

    /**
     * The super admin and the current user's own account cannot be deleted. Users are deleted
     * one by one, so the User model's deleting event (avatar file removal) runs for each of them.
     */
    public function bulkDestroyUsers(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:user,id'],
        ]);

        User::whereIn('id', $validated['ids'])
            ->where('is_admin', false)
            ->where('id', '!=', Auth::id())
            ->get()
            ->each
            ->delete();

        return redirect()->route('admin.users')->with('success', 'A kijelölt felhasználók sikeresen törölve!');
    }

    /**
     * Validation rules of the ingredient form.
     *
     * @param  Ingredient|null  $ingredient  the ingredient being updated (its own name is not a duplicate)
     */
    private function ingredientRules(?Ingredient $ingredient = null): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50', Rule::unique('ingredient', 'name')->ignore($ingredient?->id)],
            'calories' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:900'],
            'carbohydrate' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
            'protein' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
            'fat' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
        ];
    }

    /**
     * Table sorting from the "sort" and "direction" query parameters.
     * Only whitelisted column names can reach orderBy() (prevents SQL injection).
     *
     * @return array [column, direction]
     */
    private function sortParams(Request $request, array $allowedSorts, string $defaultSort, string $defaultDirection): array
    {
        $sort = $request->query('sort', $defaultSort);
        if (!in_array($sort, $allowedSorts)) {
            $sort = $defaultSort;
        }

        $direction = $request->query('direction', $defaultDirection);
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = $defaultDirection;
        }

        return [$sort, $direction];
    }
}
