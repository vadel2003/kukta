<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    protected $table = 'cuisine';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'cuisine_recipe', 'cuisine_id', 'recipe_id');
    }
}
