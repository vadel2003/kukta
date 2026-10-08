<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeFrom extends Model
{
    protected $table = 'free_from';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'thumbnail',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'free_from_recipe', 'free_from_id', 'recipe_id');
    }
}