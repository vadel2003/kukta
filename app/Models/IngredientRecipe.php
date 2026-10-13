<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    protected $table = 'ingredient_recipe';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // Mértékegységek: az adatbázisban a szám van, ez adja hozzá a megnevezést (mint a Recipe::DIFFICULTIES).
    // Az űrlap legördülője, a validáció, a seeder és a megjelenítés is innen veszi.
    // Új egységet csak a végére vegyél fel, mert a meglévő számok a már mentett receptekben szerepelnek!
    public const UNITS = [
        0 => 'g',
        1 => 'kg',
        2 => 'ml',
        3 => 'l',
        4 => 'db',
        5 => 'gerezd',
        6 => 'fej',
        7 => 'szelet',
        8 => 'csokor',
        9 => 'csomag',
        10 => 'csésze',
        11 => 'evőkanál',
        12 => 'teáskanál',
        13 => 'csipet',
    ];

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
            'quantity' => 'float',
            'unit' => 'integer',
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
