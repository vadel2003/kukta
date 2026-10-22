<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';

    /**
     * Difficulty levels: number stored in the database => label.
     */
    public const DIFFICULTIES = [
        0 => 'könnyű',
        1 => 'közepes',
        2 => 'nehéz',
    ];

    /**
     * Selectable default images: path => label, in picker order.
     */
    public const DEFAULT_IMAGES = [
        'images/recipes/default/soup_thumbnail.svg'        => 'Leves',
        'images/recipes/default/main_course_thumbnail.svg' => 'Főétel',
        'images/recipes/default/dessert_thumbnail.svg'     => 'Desszert',
        'images/recipes/default/starter_thumbnail.svg'     => 'Előétel / Nasi',
        'images/recipes/default/side_dish_thumbnail.svg'   => 'Köret',
        'images/recipes/default/salad_thumbnail.svg'       => 'Saláta',
        'images/recipes/default/pasta_thumbnail.svg'       => 'Tészta',
        'images/recipes/default/breakfast_thumbnail.svg'   => 'Reggeli',
        'images/recipes/default/bakery_thumbnail.svg'      => 'Pékáru',
        'images/recipes/default/fruit_thumbnail.svg'       => 'Gyümölcs',
        'images/recipes/default/drink_thumbnail.svg'       => 'Ital',
        'images/recipes/default/preserve_thumbnail.svg'    => 'Befőtt',
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
     * The difficulty label, e.g. 1 => "közepes".
     */
    public function difficultyLabel(): string
    {
        return self::DIFFICULTIES[$this->difficulty] ?? '';
    }

    /**
     * The thumbnail URL ($recipe->thumbnail_url) with the file modification time (?v=...),
     * so the browser downloads the image again when it changes.
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
     * Keyword search (title, description, ingredient, step) and category filters from the request.
     * Values within a category are combined with OR, categories with AND. Exception: "free from"
     * values are combined with AND too (the recipe must be free from all of them).
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

    /**
     * Sorting by the request's "sort" parameter:
     * date = newest first, popularity = number of favorites (requires withCount('favorites')),
     * otherwise relevance: title matches first, then description matches, then $defaultColumn descending.
     */
    public function scopeApplySort($query, $request, string $defaultColumn = 'recipe.created_at')
    {
        $sort = $request->input('sort');

        if ($sort === 'date') {
            return $query->orderBy('recipe.created_at', 'desc');
        }
        if ($sort === 'popularity') {
            return $query->orderBy('favorites_count', 'desc');
        }

        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->orderByRaw('CASE WHEN recipe.title LIKE ? THEN 1 WHEN recipe.description LIKE ? THEN 2 ELSE 3 END', [$search, $search]);
        }

        return $query->orderBy($defaultColumn, 'desc');
    }
}
