<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    protected $table = 'ingreedient_recipe';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ingredient_id',
        'recipe_id',
        'quantity',
        'unit',
    ];

    protected function casts(): array
    {
        return [
            'ingredient_id' => 'integer',
            'recipe_id' => 'integer',
            'quantity' => 'integer',
        ];
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
