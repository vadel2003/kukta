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

    /**
     * A mentesség kiírva ($freeFrom->free_label), pl. "Glutén" -> "Gluténmentes".
     * A gyűjtőnevek ("Diófélék", "Rákfélék") külön szóval: "Dióféléktől mentes" -
     * a "Diófélékmentes" nyelvtanilag helyes, de furcsán hangzik.
     * A helyesírás szerint a 6 szótagnál hosszabb összetett szó kötőjelet kap
     * (pl. "Földimogyoró-mentes"). Magyarban ahány magánhangzó, annyi szótag,
     * ezért a szótagokat a magánhangzók megszámolásával kapjuk meg (a "mentes" +2 szótag).
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