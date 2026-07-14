<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredient';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'calories',
        'carbohydrate',
        'protein',
        'fat',
    ];

    protected function casts(): array
    {
        return [
            'calories' => 'float',
            'carbohydrate' => 'float',
            'protein' => 'float',
            'fat' => 'float',
        ];
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingreedient_recipe', 'ingredient_id', 'recipe_id')
            ->withPivot('quantity', 'unit');
    }
}
