<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with('user')
            ->withCount(['favorites', 'ratings'])
            ->withAvg('ratings', 'score');
        $this->applyFilters($query, $request);
        $this->applySort($query, $request);
        $recipes = $query->paginate(21)->withQueryString();

        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray();
        }

        $data = $this->filterCategories();
        $data['recipes'] = $recipes;
        $data['favoriteIds'] = $favoriteIds;

        return view('home', $data);
    }
}
