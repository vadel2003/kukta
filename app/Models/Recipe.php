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

    /**
     * The difficulty label, e.g. 1 => "közepes".
     */
    public function difficultyLabel(): string
    {
        return self::DIFFICULTIES[$this->difficulty] ?? '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function steps()
    {
        return $this->hasMany(Step::class, 'recipe_id')->orderBy('position');
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
}
