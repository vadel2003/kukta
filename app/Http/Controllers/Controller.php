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
     * Recipe category lists for the filters and the recipe form,
     * plus the number of filters checked in the request (shown on the Filters button).
     */
    protected function filterCategories(): array
    {
        return [
            'mealTimes' => MealTime::orderBy('id')->get(),
            'foodTypes' => FoodType::orderBy('id')->get(),
            'diets' => Diet::orderBy('id')->get(),
            'freeFroms' => FreeFrom::orderBy('id')->get(),
            'cuisines' => Cuisine::orderBy('id')->get(),
            'activeFilterCount' => count((array) request('meal_time')) + count((array) request('food_type'))
                + count((array) request('diet')) + count((array) request('free_from')) + count((array) request('cuisine')),
        ];
    }

    /**
     * Keyword search (title, description, ingredient, step) and category filters from the request.
     * Values within a category are combined with OR, categories with AND. Exception: "free from"
     * values are combined with AND too (the recipe must be free from all of them).
     */
    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('ingredients', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('steps', function ($query) use ($search) {
                        $query->where('description', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('meal_time')) {
            $query->whereHas('mealTimes', function ($query) use ($request) {
                $query->whereIn('meal_time.id', (array) $request->input('meal_time'));
            });
        }
        if ($request->filled('food_type')) {
            $query->whereHas('foodTypes', function ($query) use ($request) {
                $query->whereIn('food_type.id', (array) $request->input('food_type'));
            });
        }
        if ($request->filled('diet')) {
            $query->whereHas('diets', function ($query) use ($request) {
                $query->whereIn('diet.id', (array) $request->input('diet'));
            });
        }
        if ($request->filled('free_from')) {
            foreach ((array) $request->input('free_from') as $freeFromId) {
                $query->whereHas('freeFroms', function ($query) use ($freeFromId) {
                    $query->where('free_from.id', $freeFromId);
                });
            }
        }
        if ($request->filled('cuisine')) {
            $query->whereHas('cuisines', function ($query) use ($request) {
                $query->whereIn('cuisine.id', (array) $request->input('cuisine'));
            });
        }
    }

    /**
     * Sorting by the request's "sort" parameter: popularity = number of favorites
     * (requires withCount('favorites')), otherwise the newest recipe first.
     */
    protected function applySort($query, Request $request): void
    {
        if ($request->input('sort') === 'popularity') {
            $query->orderBy('favorites_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
    }
}
