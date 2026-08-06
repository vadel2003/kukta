<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealTime extends Model
{
    protected $table = 'meal_time';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'thumbnail',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'meal_time_recipe', 'meal_time_id', 'recipe_id');
    }
}