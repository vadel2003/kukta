<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;

class RecipeController extends Controller
{
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('recipes.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'step1' => ['nullable', 'string', 'max:255'],
            'step2' => ['nullable', 'string', 'max:255'],
            'step3' => ['nullable', 'string', 'max:255'],
            'step4' => ['nullable', 'string', 'max:255'],
            'step5' => ['nullable', 'string', 'max:255'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.id' => ['required', 'exists:ingredient,id'],
            'ingredients.*.quantity' => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required', 'string', 'max:50'],
        ]);

        // 1. Recept létrehozása
        $recipe = Recipe::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'creation_date' => now(),
            'user_id' => Auth::id(),
        ]);

        // 2. Lépések feldolgozása (csak a nem üreseket menti)
        $stepNumber = 1;
        for ($i = 1; $i <= 5; $i++) {
            $stepField = 'step' . $i;
            if (!empty($validated[$stepField])) {
                Step::create([
                    'description' => $validated[$stepField],
                    'recipe_id' => $recipe->id,
                    'order' => $stepNumber,
                ]);
                $stepNumber++;
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

        return redirect()->route('recipes.my')->with('success', 'Recept sikeresen feltöltve!');
    }

    public function myRecipes()
    {
        $myRecipes = Recipe::where('user_id', Auth::id())
            ->orderBy('creation_date', 'desc')
            ->get();

        return view('recipes.my', compact('myRecipes'));
    }

    public function favorites()
    {
        return view('recipes.favorites');
    }
}

