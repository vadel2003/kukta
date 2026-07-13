<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
     protected $table = 'step';

     protected $primaryKey = 'id';

     protected $fillable = [
        'description',
        'recipe_id',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'recipe_id' => 'integer',
            'order' => 'integer',
        ];
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
