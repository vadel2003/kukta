<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function create()
    {
        return view('recipes.create');
    }

    public function myRecipes()
    {
        return view('recipes.my');
    }

    public function favorites()
    {
        return view('recipes.favorites');
    }
}
