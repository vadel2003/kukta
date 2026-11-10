<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'step';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'recipe_id',
        'position',
        'step_category_id',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function stepCategory()
    {
        return $this->belongsTo(StepCategory::class, 'step_category_id');
    }
}
