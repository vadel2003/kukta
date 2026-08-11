<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use App\Models\MealTime;
use App\Models\FoodType;
use App\Models\Diet;
use App\Models\Allergen;
use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Recept-lekérdezés építése
        $query = Recipe::with('user');

        // 2. Keresés: címben vagy leírásban keres
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 3. Kategória szűrők (csak akkor szűr, ha ki van választva)
        if ($request->filled('meal_time')) {
            $query->whereHas('mealTimes', fn ($q) => $q->where('meal_time.id', $request->input('meal_time')));
        }
        if ($request->filled('food_type')) {
            $query->whereHas('foodTypes', fn ($q) => $q->where('food_type.id', $request->input('food_type')));
        }
        if ($request->filled('diet')) {
            $query->whereHas('diets', fn ($q) => $q->where('diet.id', $request->input('diet')));
        }
        if ($request->filled('allergen')) {
            $query->whereHas('allergens', fn ($q) => $q->where('allergen.id', $request->input('allergen')));
        }
        if ($request->filled('cuisine')) {
            $query->whereHas('cuisines', fn ($q) => $q->where('cuisine.id', $request->input('cuisine')));
        }

        // 4. Rendezés és lapozás nélkül mindet lekérjük
        $recipes = $query->orderBy('creation_date', 'desc')->get();

        // 5. A bejelentkezett felhasználó kedvenc recept ID-i
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('recipe_id')
                ->toArray();
        }

        // 6. Kategóriák a szűrő legördülőkhöz
        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $allergens = Allergen::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        return view('home', compact('recipes', 'favoriteIds', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines'));
    }
}