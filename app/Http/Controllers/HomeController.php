<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $latestRecipes = Recipe::with('user')
            ->orderBy('creation_date', 'desc')
            ->take(6)
            ->get();

        // A bejelentkezett felhasználó kedvenc recept ID-i
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('recipe_id')
                ->toArray();
        }

        return view('home', compact('latestRecipes', 'favoriteIds'));
    }
}