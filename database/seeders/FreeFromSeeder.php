<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergenSeeder extends Seeder
{
    public function run(): void
    {
        // A régi "-mentes" nevek átnevezése (id megtartásával, a recept-kapcsolatok nem sérülnek)
        $renames = [
            'Gluténmentes' => 'Glutén',
            'Laktózmentes' => 'Laktóz',
            'Cukormentes' => 'Cukor',
            'Tojásmentes' => 'Tojás',
        ];

        foreach ($renames as $old => $new) {
            DB::table('allergen')->where('name', $old)->update(['name' => $new]);
        }

        // Érzékenységek idempotens biztosítása
        $sensitivities = [
            'Glutén',
            'Laktóz',
            'Cukor',
            'Tojás',
            'Szója',
            'Diófélék',
            'Földimogyoró',
            'Hal',
            'Rákfélék',
            'Zeller',
            'Mustár',
            'Szezámmag',
        ];

        foreach ($sensitivities as $name) {
            DB::table('allergen')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'thumbnail' => null]
            );
        }
    }
}