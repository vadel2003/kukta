<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeFrom extends Model
{
    protected $table = 'free_from';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'thumbnail',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'free_from_recipe', 'free_from_id', 'recipe_id');
    }

    /**
     * The "free from" label ($freeFrom->free_label), e.g. "Glutén" => "Gluténmentes",
     * "Földimogyoró" => "Földimogyoró-mentes" (hyphenated above 6 syllables),
     * "Diófélék" => "Dióféléktől mentes".
     */
    public function getFreeLabelAttribute(): string
    {
        if (str_ends_with($this->name, 'félék')) {
            return $this->name . 'től mentes';
        }

        $syllables = preg_match_all('/[aáeéiíoóöőuúüű]/iu', $this->name) + 2;

        return $this->name . ($syllables > 6 ? '-mentes' : 'mentes');
    }
}
