<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $table = 'diet';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'diet_recipe', 'diet_id', 'recipe_id');
    }
}
