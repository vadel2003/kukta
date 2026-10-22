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
        $recipes = Recipe::with('user')
            ->withCount(['favorites', 'ratings'])
            ->withAvg('ratings', 'score')
            ->searchAndFilter($request)
            ->applySort($request)
            ->paginate(21);

        $favoriteIds = Auth::check()
            ? Favorite::where('user_id', Auth::id())->pluck('recipe_id')->toArray()
            : [];

        return $this->recipeListResponse($request, 'home', compact('recipes', 'favoriteIds'));
    }
}
