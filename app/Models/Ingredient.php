<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredient';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'calories',
        'carbohydrate',
        'protein',
        'fat',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipe', 'ingredient_id', 'recipe_id')
            ->withPivot('quantity', 'unit');
    }
}
