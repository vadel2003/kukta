<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';

    protected $primaryKey = 'id';

    public $timestamps = true;

    // Nehézségi szintek: az adatbázisban a szám (0/1/2) van, ez adja hozzá a megnevezést.
    // Az űrlap legördülője, a validáció és a megjelenítés is innen veszi, így egy helyen kell módosítani.
    public const DIFFICULTIES = [
        0 => 'könnyű',
        1 => 'közepes',
        2 => 'nehéz',
    ];

    protected $fillable = [
        'title',
        'description',
        'prep_time',
        'difficulty',
        'servings',
        'thumbnail',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'prep_time' => 'integer',
            'difficulty' => 'integer',
            'servings' => 'integer',
        ];
    }

    /**
     * A nehézség megnevezése ($recipe->difficultyLabel()), pl. 1 -> "közepes"
     */
    public function difficultyLabel(): string
    {
        return self::DIFFICULTIES[$this->difficulty] ?? '';
    }

    /**
     * A borítókép teljes URL-je ($recipe->thumbnail_url). A végére ?v=<módosítás ideje>
     * kerül, így ha a képfájl megváltozik, a böngésző új címnek látja és nem a régi,
     * gyorsítótárazott képet mutatja.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $path = $this->thumbnail ?: 'images/recipes/default/recipe_placeholder.jpg';
        $file = public_path($path);

        return asset($path) . (is_file($file) ? '?v=' . filemtime($file) : '');
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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('score');
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

    public function freeFroms()
    {
        return $this->belongsToMany(FreeFrom::class, 'free_from_recipe', 'recipe_id', 'free_from_id');
    }

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'cuisine_recipe', 'recipe_id', 'cuisine_id');
    }

    /**
     * Kulcsszavas keresés + kategória szűrők (étkezés, ételtípus, diéta, érzékenység, konyha).
     * Egy csoporton belül VAGY (pl. Leves vagy Desszert), csoportok között ÉS a kapcsolat.
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
        // Mentesség: itt csoporton belül is ÉS a kapcsolat - aki a "Glutén"-t és a "Laktóz"-t
        // is bejelöli, annak olyan recept kell, ami MINDKETTŐTŐL mentes. Ezért minden
        // bejelölt mentességre külön whereHas feltétel kerül (ezek között ÉS van)
        if ($request->filled('free_from')) {
            foreach ((array) $request->input('free_from') as $freeFromId) {
                $query->whereHas('freeFroms', fn ($q) => $q->where('free_from.id', $freeFromId));
            }
        }
        if ($request->filled('cuisine')) {
            $query->whereHas('cuisines', fn ($q) => $q->whereIn('cuisine.id', (array) $request->input('cuisine')));
        }

        return $query;
    }
}
