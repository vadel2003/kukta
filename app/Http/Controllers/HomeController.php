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
        // 1. Recept-lekérdezés építése + keresés/szűrés (megosztott scope a Recipe modellben)
        $query = Recipe::with('user')
            ->withCount('favorites')
            ->withCount('scores')
            ->withAvg('scores', 'score')
            ->searchAndFilter($request);

        // 2. Rendezés
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

        $recipes = $query->paginate(21);

        // 3. A bejelentkezett felhasználó kedvenc recept ID-i
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('recipe_id')
                ->toArray();
        }

        // 4. Kategóriák a szűrő legördülőkhöz
        $mealTimes = MealTime::orderBy('id')->get();
        $foodTypes = FoodType::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $allergens = Allergen::orderBy('id')->get();
        $cuisines = Cuisine::orderBy('id')->get();

        // Ha AJAX kérés, csak a galéria HTML-jét küldjük vissza
        if ($request->ajax()) {
            $html = view('partials.recipe-gallery', compact('recipes', 'favoriteIds'))->render();
            return response()->json([
                'html' => $html,
                'hasMore' => $recipes->hasMorePages(),
            ]);
        }

        return view('home', compact('recipes', 'favoriteIds', 'mealTimes', 'foodTypes', 'diets', 'allergens', 'cuisines'));
    }
}