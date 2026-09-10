<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepCategory extends Model
{
    protected $table = 'step_category';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'gif_filename',
    ];

    public function steps()
    {
        return $this->hasMany(Step::class, 'step_category_id');
    }
}