<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Super admin pages. Access is checked by the IsAdmin middleware of the routes.
 */
class AdminController extends Controller
{
    public function ingredients(Request $request)
    {
        $search = $request->query('search');

        // only these columns can be used for sorting
        $sort = $request->query('sort', 'name');
        if (!in_array($sort, ['name', 'calories', 'carbohydrate', 'protein', 'fat'])) {
            $sort = 'name';
        }
        $direction = $request->query('direction', 'asc');
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'asc';
        }

        $query = Ingredient::withCount('recipes');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $ingredients = $query->orderBy($sort, $direction)->get();

        return view('admin.ingredients', [
            'ingredients' => $ingredients,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function storeIngredient(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50', 'unique:ingredient,name'],
            'calories' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:900'],
            'carbohydrate' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
            'protein' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
            'fat' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
        ]);

        Ingredient::create($validated);

        return redirect()->route('admin.ingredients')->with('success', 'Alapanyag sikeresen létrehozva!');
    }

    public function updateIngredient(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        // the ingredient's own name does not count as a duplicate
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50', 'unique:ingredient,name,' . $ingredient->id],
            'calories' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:900'],
            'carbohydrate' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
            'protein' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
            'fat' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:100'],
        ]);

        $ingredient->update($validated);

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

    public function recipes(Request $request)
    {
        $search = $request->query('search');

        $sort = $request->query('sort', 'created_at');
        if (!in_array($sort, ['title', 'user', 'created_at'])) {
            $sort = 'created_at';
        }
        $direction = $request->query('direction', 'desc');
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'desc';
        }

        $query = Recipe::with('user');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($sort == 'user') {
            // select('recipe.*') is needed, otherwise the id of the user would overwrite the id of the recipe
            $query->leftJoin('user', 'user.id', '=', 'recipe.user_id')
                ->orderBy('user.name', $direction)
                ->select('recipe.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $recipes = $query->get();

        return view('admin.recipes', [
            'recipes' => $recipes,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function users(Request $request)
    {
        $search = $request->query('search');

        $sort = $request->query('sort', 'name');
        if (!in_array($sort, ['id', 'name', 'email', 'is_admin'])) {
            $sort = 'name';
        }
        $direction = $request->query('direction', 'asc');
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'asc';
        }

        $query = User::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }
        $users = $query->orderBy($sort, $direction)->get();

        return view('admin.users', [
            'users' => $users,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * The super admin and the current user's own account cannot be deleted.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin() || $user->id == Auth::id()) {
            abort(403);
        }

        $user->deleteAvatarFile();
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Felhasználó sikeresen törölve!');
    }
}
