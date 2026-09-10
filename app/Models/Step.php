<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
     protected $table = 'step';

     protected $primaryKey = 'id';

     public $timestamps = false;

     protected $fillable = [
        'description',
        'recipe_id',
        'order',
        'step_category_id',
    ];

    protected function casts(): array
    {
        return [
            'recipe_id' => 'integer',
            'order' => 'integer',
            'step_category_id' => 'integer',
        ];
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function stepCategory()
    {
        return $this->belongsTo(StepCategory::class, 'step_category_id');
    }
}
