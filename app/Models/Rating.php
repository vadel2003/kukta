<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'recipe_id',
        'score',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'recipe_id' => 'integer',
            'score' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}