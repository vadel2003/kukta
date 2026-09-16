<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;

class AdminController extends Controller
{
    public function ingredients()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.ingredients', compact('ingredients'));
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

    public function recipes()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $recipes = Recipe::with('user')->orderBy('creation_date', 'desc')->get();

        return view('admin.recipes', compact('recipes'));
    }

    public function users()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $users = User::orderBy('name')->get();

        return view('admin.users', compact('users'));
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
}
