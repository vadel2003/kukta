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

        $favoriteIds = Auth::check()
            ? Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray()
            : [];

        return view('home', compact('recipes', 'favoriteIds') + $this->filterCategories());
    }
}
