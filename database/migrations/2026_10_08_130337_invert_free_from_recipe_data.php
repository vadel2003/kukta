<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Eddig a free_from_recipe azt tárolta, mit TARTALMAZ a recept, mostantól azt,
     * mitől MENTES. Minden recepthez a "minden mentesség MÍNUSZ a mostaniak" kerül.
     */
    public function up(): void
    {
        $this->invert();
    }

    /**
     * Ugyanaz a megfordítás visszaállítja az eredetit (kétszer megfordítva = eredeti)
     */
    public function down(): void
    {
        $this->invert();
    }

    private function invert(): void
    {
        $allIds = DB::table('free_from')->pluck('id');
        $records = [];

        foreach (DB::table('recipe')->pluck('id') as $recipeId) {
            $currentIds = DB::table('free_from_recipe')->where('recipe_id', $recipeId)->pluck('free_from_id');

            foreach ($allIds->diff($currentIds) as $freeFromId) {
                $records[] = ['free_from_id' => $freeFromId, 'recipe_id' => $recipeId];
            }
        }

        // A régi sorok törlése és az újak beírása egy tranzakcióban: ha közben hiba van,
        // semmi sem változik (nem marad félig átírt tábla)
        DB::transaction(function () use ($records) {
            DB::table('free_from_recipe')->delete();

            foreach (array_chunk($records, 200) as $chunk) {
                DB::table('free_from_recipe')->insert($chunk);
            }
        });
    }
};
