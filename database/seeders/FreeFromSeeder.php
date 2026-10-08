<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreeFromSeeder extends Seeder
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
            DB::table('free_from')->where('name', $old)->update(['name' => $new]);
        }

        // Érzékenységek idempotens biztosítása, mindegyikhez egy áthúzott ikonnal
        // (public/images/free_from/ - az asset() függvénnyel lehet rájuk hivatkozni)
        $sensitivities = [
            'Glutén'       => 'images/free_from/gluten.svg',
            'Laktóz'       => 'images/free_from/laktoz.svg',
            'Cukor'        => 'images/free_from/cukor.svg',
            'Tojás'        => 'images/free_from/tojas.svg',
            'Szója'        => 'images/free_from/szoja.svg',
            'Diófélék'     => 'images/free_from/diofelek.svg',
            'Földimogyoró' => 'images/free_from/foldimogyoro.svg',
            'Hal'          => 'images/free_from/hal.svg',
            'Rákfélék'     => 'images/free_from/rakfelek.svg',
            'Zeller'       => 'images/free_from/zeller.svg',
            'Mustár'       => 'images/free_from/mustar.svg',
            'Szezámmag'    => 'images/free_from/szezammag.svg',
        ];

        foreach ($sensitivities as $name => $thumbnail) {
            DB::table('free_from')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'thumbnail' => $thumbnail]
            );
        }
    }
}