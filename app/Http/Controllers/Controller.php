<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use App\Models\Diet;
use App\Models\FoodType;
use App\Models\FreeFrom;
use App\Models\MealTime;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Recipe category lists for the filters and the recipe form.
     */
    protected function filterCategories(): array
    {
        return [
            'mealTimes' => MealTime::orderBy('id')->get(),
            'foodTypes' => FoodType::orderBy('id')->get(),
            'diets' => Diet::orderBy('id')->get(),
            'freeFroms' => FreeFrom::orderBy('id')->get(),
            'cuisines' => Cuisine::orderBy('id')->get(),
        ];
    }

    /**
     * Response of a recipe list page. For AJAX requests (search, filtering, "load more")
     * it returns only the gallery HTML as JSON, otherwise the full page.
     *
     * @param  array  $data  view data, including the paginated 'recipes' list
     */
    protected function recipeListResponse(Request $request, string $view, array $data)
    {
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.recipe-gallery', $data)->render(),
                'hasMore' => $data['recipes']->hasMorePages(),
            ]);
        }

        return view($view, $data + $this->filterCategories());
    }
}
