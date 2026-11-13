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
     * Category lists for the filters and the recipe form, and the number of checked filters.
     */
    protected function filterCategories()
    {
        $activeFilterCount = 0;
        $filterNames = ['meal_time', 'food_type', 'diet', 'free_from', 'cuisine'];
        foreach ($filterNames as $name) {
            if (is_array(request($name))) {
                $activeFilterCount = $activeFilterCount + count(request($name));
            }
        }

        return [
            'mealTimes' => MealTime::orderBy('id')->get(),
            'foodTypes' => FoodType::orderBy('id')->get(),
            'diets' => Diet::orderBy('id')->get(),
            'freeFroms' => FreeFrom::orderBy('id')->get(),
            'cuisines' => Cuisine::orderBy('id')->get(),
            'activeFilterCount' => $activeFilterCount,
        ];
    }

    /**
     * Keyword search and category filters. Values of one category are combined with OR,
     * except "free from", where the recipe must be free from all checked values.
     */
    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('ingredients', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('steps', function ($q2) use ($search) {
                        $q2->where('description', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('meal_time')) {
            $query->whereHas('mealTimes', function ($q) use ($request) {
                $q->whereIn('meal_time.id', (array) $request->input('meal_time'));
            });
        }
        if ($request->filled('food_type')) {
            $query->whereHas('foodTypes', function ($q) use ($request) {
                $q->whereIn('food_type.id', (array) $request->input('food_type'));
            });
        }
        if ($request->filled('diet')) {
            $query->whereHas('diets', function ($q) use ($request) {
                $q->whereIn('diet.id', (array) $request->input('diet'));
            });
        }
        if ($request->filled('free_from')) {
            foreach ((array) $request->input('free_from') as $freeFromId) {
                $query->whereHas('freeFroms', function ($q) use ($freeFromId) {
                    $q->where('free_from.id', $freeFromId);
                });
            }
        }
        if ($request->filled('cuisine')) {
            $query->whereHas('cuisines', function ($q) use ($request) {
                $q->whereIn('cuisine.id', (array) $request->input('cuisine'));
            });
        }
    }

    /**
     * Sorting: by number of favorites (popularity) or by date (newest first).
     */
    protected function applySort($query, Request $request)
    {
        if ($request->input('sort') == 'popularity') {
            $query->orderBy('favorites_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
    }
}
