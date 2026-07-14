<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'creation_date',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'creation_date' => 'date',
            'user_id' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function steps()
    {
        return $this->hasMany(Step::class, 'recipe_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingreedient_recipe', 'recipe_id', 'ingredient_id')
            ->withPivot('quantity', 'unit');
    }
}
