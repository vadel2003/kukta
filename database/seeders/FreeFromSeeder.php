<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreeFromSeeder extends Seeder
{
    public function run(): void
    {
        $sensitivities = [
            ['name' => 'Glutén',       'label' => 'Gluténmentes',        'thumbnail' => 'images/free_from/gluten.svg'],
            ['name' => 'Laktóz',       'label' => 'Laktózmentes',        'thumbnail' => 'images/free_from/lactose.svg'],
            ['name' => 'Cukor',        'label' => 'Cukormentes',         'thumbnail' => 'images/free_from/sugar.svg'],
            ['name' => 'Tojás',        'label' => 'Tojásmentes',         'thumbnail' => 'images/free_from/egg.svg'],
            ['name' => 'Szója',        'label' => 'Szójamentes',         'thumbnail' => 'images/free_from/soy.svg'],
            ['name' => 'Diófélék',     'label' => 'Dióféléktől mentes',  'thumbnail' => 'images/free_from/tree-nuts.svg'],
            ['name' => 'Földimogyoró', 'label' => 'Földimogyoró-mentes', 'thumbnail' => 'images/free_from/peanut.svg'],
            ['name' => 'Hal',          'label' => 'Halmentes',           'thumbnail' => 'images/free_from/fish.svg'],
            ['name' => 'Rákfélék',     'label' => 'Rákféléktől mentes',  'thumbnail' => 'images/free_from/crustaceans.svg'],
            ['name' => 'Zeller',       'label' => 'Zellermentes',        'thumbnail' => 'images/free_from/celery.svg'],
            ['name' => 'Mustár',       'label' => 'Mustármentes',        'thumbnail' => 'images/free_from/mustard.svg'],
            ['name' => 'Szezámmag',    'label' => 'Szezámmagmentes',     'thumbnail' => 'images/free_from/sesame.svg'],
        ];

        DB::table('free_from')->insert($sensitivities);
    }
}
