<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreeFromSeeder extends Seeder
{
    public function run(): void
    {
        $sensitivities = [
            'Glutén'       => 'images/free_from/gluten.svg',
            'Laktóz'       => 'images/free_from/lactose.svg',
            'Cukor'        => 'images/free_from/sugar.svg',
            'Tojás'        => 'images/free_from/egg.svg',
            'Szója'        => 'images/free_from/soy.svg',
            'Diófélék'     => 'images/free_from/tree-nuts.svg',
            'Földimogyoró' => 'images/free_from/peanut.svg',
            'Hal'          => 'images/free_from/fish.svg',
            'Rákfélék'     => 'images/free_from/crustaceans.svg',
            'Zeller'       => 'images/free_from/celery.svg',
            'Mustár'       => 'images/free_from/mustard.svg',
            'Szezámmag'    => 'images/free_from/sesame.svg',
        ];

        foreach ($sensitivities as $name => $thumbnail) {
            DB::table('free_from')->insert(['name' => $name, 'thumbnail' => $thumbnail]);
        }
    }
}
