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
        'thumbnail',
        'creation_date',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'creation_date' => 'date',
            'user_id' => 'integer',
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
}
