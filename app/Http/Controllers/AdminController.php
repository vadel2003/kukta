<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;

class AdminController extends Controller
{
    public function ingredients(Request $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $search = $request->query('search');

        // Csak ezek az oszlopok rendezhetők - enélkül a query paraméterből
        // közvetlenül kerülne oszlopnév az orderBy()-ba, ami SQL injection kockázat lenne.
        $allowedSorts = ['name', 'calories', 'carbohydrate', 'protein', 'fat'];
        $sort = $request->query('sort', 'name');
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        $direction = $request->query('direction', 'asc');
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $ingredients = Ingredient::when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sort, $direction)
            ->get();

        return view('admin.ingredients', compact('ingredients', 'search', 'sort', 'direction'));
    }

    public function storeIngredient(Request $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:ingredient,name'],
            'calories' => ['required', 'numeric', 'min:0'],
            'carbohydrate' => ['required', 'numeric', 'min:0'],
            'protein' => ['required', 'numeric', 'min:0'],
            'fat' => ['required', 'numeric', 'min:0'],
        ]);

        Ingredient::create($validated);

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen létrehozva!');
    }

    public function updateIngredient(Request $request, $id)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('ingredient', 'name')->ignore($ingredient->id)],
            'calories' => ['required', 'numeric', 'min:0'],
            'carbohydrate' => ['required', 'numeric', 'min:0'],
            'protein' => ['required', 'numeric', 'min:0'],
            'fat' => ['required', 'numeric', 'min:0'],
        ]);

        $ingredient->update($validated);

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen módosítva!');
    }

    public function destroyIngredient($id)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen törölve!');
    }

    public function bulkDestroyIngredients(Request $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:ingredient,id'],
        ]);

        Ingredient::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.ingredients')->with('success', 'A kijelölt alapanyagok sikeresen törölve!');
    }

    public function recipes(Request $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $search = $request->query('search');

        $allowedSorts = ['title', 'user', 'creation_date'];
        $sort = $request->query('sort', 'creation_date');
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'creation_date';
        }

        $direction = $request->query('direction', 'desc');
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $recipesQuery = Recipe::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });

        if ($sort === 'user') {
            // A feltöltő neve a user táblában van, nem a recipe-ben - LEFT JOIN kell,
            // hogy a törölt felhasználós receptek (user_id = null) se essenek ki a listából.
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
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:recipe,id'],
        ]);

        Recipe::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.recipes')->with('success', 'A kijelölt receptek sikeresen törölve!');
    }

    public function users(Request $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $search = $request->query('search');

        $allowedSorts = ['id', 'name', 'email', 'role'];
        $sort = $request->query('sort', 'name');
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        $direction = $request->query('direction', 'asc');
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy($sort, $direction)
            ->get();

        return view('admin.users', compact('users', 'search', 'sort', 'direction'));
    }

    public function destroyUser($id)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->isAdmin() || $user->id === Auth::id()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Felhasználó sikeresen törölve!');
    }

    public function bulkDestroyUsers(Request $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:user,id'],
        ]);

        // Az admin és a saját fiók sosem törölhető így sem - ugyanaz a védelem,
        // mint az egyedi destroyUser-nél.
        User::whereIn('id', $validated['ids'])
            ->where('role', '!=', 1)
            ->where('id', '!=', Auth::id())
            ->delete();

        return redirect()->route('admin.users')->with('success', 'A kijelölt felhasználók sikeresen törölve!');
    }
}
