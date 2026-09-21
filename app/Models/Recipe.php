<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'prep_time',
        'difficulty',
        'servings',
        'thumbnail',
        'creation_date',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'creation_date' => 'date',
            'user_id' => 'integer',
            'prep_time' => 'integer',
            'servings' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function steps()
    {
        return $this->hasMany(Step::class, 'recipe_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe', 'recipe_id', 'ingredient_id')
            ->withPivot('quantity', 'unit');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function averageScore()
    {
        return $this->scores()->avg('score');
    }

    public function mealTimes()
    {
        return $this->belongsToMany(MealTime::class, 'meal_time_recipe', 'recipe_id', 'meal_time_id');
    }

    public function foodTypes()
    {
        return $this->belongsToMany(FoodType::class, 'food_type_recipe', 'recipe_id', 'food_type_id');
    }

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'diet_recipe', 'recipe_id', 'diet_id');
    }

    public function allergens()
    {
        return $this->belongsToMany(Allergen::class, 'allergen_recipe', 'recipe_id', 'allergen_id');
    }

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'cuisine_recipe', 'recipe_id', 'cuisine_id');
    }

    /**
     * Kulcsszavas keresés + kategória szűrők (étkezés, ételtípus, diéta, érzékenység, konyha).
     * Ezt a főoldal, a Saját receptek és a Kedvenc receptek oldal is használja,
     * hogy ne kelljen 3x ugyanazt a kódot írni. A rendezést szándékosan NEM ez csinálja,
     * mert az oldalanként eltérhet (l. Kedvenc receptek: alapból a kedvencnek jelölés
     * ideje szerint rendez, nem a recept létrehozási dátuma szerint).
     */
    public function scopeSearchAndFilter($query, $request)
    {
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('ingredients', fn ($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('steps', fn ($q2) => $q2->where('description', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('meal_time')) {
            $query->whereHas('mealTimes', fn ($q) => $q->whereIn('meal_time.id', (array) $request->input('meal_time')));
        }
        if ($request->filled('food_type')) {
            $query->whereHas('foodTypes', fn ($q) => $q->whereIn('food_type.id', (array) $request->input('food_type')));
        }
        if ($request->filled('diet')) {
            $query->whereHas('diets', fn ($q) => $q->whereIn('diet.id', (array) $request->input('diet')));
        }
        if ($request->filled('allergen')) {
            $query->whereHas('allergens', fn ($q) => $q->whereIn('allergen.id', (array) $request->input('allergen')));
        }
        if ($request->filled('cuisine')) {
            $query->whereHas('cuisines', fn ($q) => $q->whereIn('cuisine.id', (array) $request->input('cuisine')));
        }

        return $query;
    }
}
