<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    protected $table = 'allergen';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'thumbnail',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'allergen_recipe', 'allergen_id', 'recipe_id');
    }
}