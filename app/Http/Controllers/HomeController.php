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

        // 2. Keresés: név, leírás, hozzávalók, elkészítés
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('ingredients', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('steps', function ($q2) use ($search) {
                        $q2->where('description', 'like', "%{$search}%");
                    });
            });
        }

        // 3. Kategória szűrők (tömbök - checkboxok miatt)
        if ($request->filled('meal_time')) {
            $query->whereHas('mealTimes', fn ($q) => $q->whereIn('meal_time.id', (array)$request->input('meal_time')));
        }
        if ($request->filled('food_type')) {
            $query->whereHas('foodTypes', fn ($q) => $q->whereIn('food_type.id', (array)$request->input('food_type')));
        }
        if ($request->filled('diet')) {
            $query->whereHas('diets', fn ($q) => $q->whereIn('diet.id', (array)$request->input('diet')));
        }
        if ($request->filled('allergen')) {
            $query->whereHas('allergens', fn ($q) => $q->whereIn('allergen.id', (array)$request->input('allergen')));
        }
        if ($request->filled('cuisine')) {
            $query->whereHas('cuisines', fn ($q) => $q->whereIn('cuisine.id', (array)$request->input('cuisine')));
        }

        // 4. Rendezés
        $sort = $request->input('sort', 'relevance');
        $search = $request->input('search');

        switch ($sort) {
            case 'date':
                // Feltöltés ideje: legújabb elöl
                $query->orderBy('creation_date', 'desc');
                break;

            case 'popularity':
                // Népszerűség: kedvelések száma szerint (review-k később)
                $query->withCount('favorites')
                    ->orderBy('favorites_count', 'desc');
                break;

            default: // relevance
                // Relevancia: ha van kereső szó, a név-egyezés előre kerül
                if ($search) {
                    $query->orderByRaw('CASE WHEN title LIKE ? THEN 1 WHEN description LIKE ? THEN 2 ELSE 3 END', ["%{$search}%", "%{$search}%"]);
                }
                // Ha nincs kereső szó: egyszerűen legújabb elöl
                $query->orderBy('creation_date', 'desc');
        }

        $recipes = $query->get();

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

        // Ha AJAX kérés, csak a galéria HTML-jét küldjük vissza
        if ($request->ajax()) {
            $html = view('partials.recipe-gallery', compact('recipes', 'favoriteIds'))->render();
            return response()->json(['html' => $html]);
        }

        return view('home', compact('recipes', 'favoriteIds', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines'));
    }
}