<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class HomeController extends Controller
{
    public function index()
    {
        $latestRecipes = Recipe::with('user')
            ->orderBy('creation_date', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('latestRecipes'));
    }
}

