<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        // Tápértékek 100g-ra vonatkoztatva
        $ingredients = [
            ['name' => 'Liszt',           'calories' => 364, 'carbohydrate' => 76.0, 'protein' => 10.0, 'fat' => 1.0],
            ['name' => 'Cukor',           'calories' => 387, 'carbohydrate' => 100.0,'protein' => 0.0,  'fat' => 0.0],
            ['name' => 'Só',              'calories' => 0,   'carbohydrate' => 0.0,  'protein' => 0.0,  'fat' => 0.0],
            ['name' => 'Tojás',           'calories' => 155, 'carbohydrate' => 1.1,  'protein' => 13.0, 'fat' => 11.0],
            ['name' => 'Tej',             'calories' => 42,  'carbohydrate' => 5.0,  'protein' => 3.4,  'fat' => 1.0],
            ['name' => 'Vaj',             'calories' => 717, 'carbohydrate' => 0.1,  'protein' => 0.9,  'fat' => 81.0],
            ['name' => 'Olaj',            'calories' => 884, 'carbohydrate' => 0.0,  'protein' => 0.0,  'fat' => 100.0],
            ['name' => 'Víz',             'calories' => 0,   'carbohydrate' => 0.0,  'protein' => 0.0,  'fat' => 0.0],
            ['name' => 'Élesztő',         'calories' => 105, 'carbohydrate' => 13.0, 'protein' => 8.0,  'fat' => 1.5],
            ['name' => 'Sütőpor',         'calories' => 53,  'carbohydrate' => 28.0, 'protein' => 0.0,  'fat' => 0.0],
            ['name' => 'Vaníliás cukor',  'calories' => 387, 'carbohydrate' => 97.0, 'protein' => 0.0,  'fat' => 0.0],
            ['name' => 'Csokoládé',       'calories' => 546, 'carbohydrate' => 60.0, 'protein' => 5.0,  'fat' => 31.0],
            ['name' => 'Tejföl',          'calories' => 193, 'carbohydrate' => 3.5,  'protein' => 2.5,  'fat' => 20.0],
            ['name' => 'Tejszín',         'calories' => 340, 'carbohydrate' => 2.8,  'protein' => 2.0,  'fat' => 36.0],
            ['name' => 'Hagyma',          'calories' => 40,  'carbohydrate' => 9.3,  'protein' => 1.1,  'fat' => 0.1],
            ['name' => 'Fokhagyma',       'calories' => 149, 'carbohydrate' => 33.0, 'protein' => 6.4,  'fat' => 0.5],
            ['name' => 'Paprika',         'calories' => 20,  'carbohydrate' => 4.6,  'protein' => 0.9,  'fat' => 0.2],
            ['name' => 'Paradicsom',      'calories' => 18,  'carbohydrate' => 3.9,  'protein' => 0.9,  'fat' => 0.2],
            ['name' => 'Csirkemell',      'calories' => 165, 'carbohydrate' => 0.0,  'protein' => 31.0, 'fat' => 3.6],
            ['name' => 'Darált hús',      'calories' => 250, 'carbohydrate' => 0.0,  'protein' => 17.0, 'fat' => 20.0],
            ['name' => 'Sárgarépa',       'calories' => 41,  'carbohydrate' => 10.0, 'protein' => 0.9,  'fat' => 0.2],
            ['name' => 'Burgonya',        'calories' => 77,  'carbohydrate' => 17.0, 'protein' => 2.0,  'fat' => 0.1],
            ['name' => 'Rizs',            'calories' => 130, 'carbohydrate' => 28.0, 'protein' => 2.7,  'fat' => 0.3],
            ['name' => 'Tészta',          'calories' => 131, 'carbohydrate' => 25.0, 'protein' => 5.0,  'fat' => 1.1],
            ['name' => 'Kenyér',          'calories' => 265, 'carbohydrate' => 49.0, 'protein' => 9.0,  'fat' => 3.2],
            ['name' => 'Sajt',            'calories' => 402, 'carbohydrate' => 1.3,  'protein' => 25.0, 'fat' => 33.0],
            ['name' => 'Sonka',           'calories' => 145, 'carbohydrate' => 1.5,  'protein' => 21.0, 'fat' => 6.0],
            ['name' => 'Bors',            'calories' => 251, 'carbohydrate' => 64.0, 'protein' => 10.0, 'fat' => 3.3],
            ['name' => 'Babérlevél',      'calories' => 313, 'carbohydrate' => 75.0, 'protein' => 7.6,  'fat' => 8.4],
            ['name' => 'Petrezselyem',    'calories' => 36,  'carbohydrate' => 6.3,  'protein' => 3.0,  'fat' => 0.8],
            ['name' => 'Citrom',          'calories' => 29,  'carbohydrate' => 9.3,  'protein' => 1.1,  'fat' => 0.3],
            ['name' => 'Alma',            'calories' => 52,  'carbohydrate' => 14.0, 'protein' => 0.3,  'fat' => 0.2],
            ['name' => 'Banán',           'calories' => 89,  'carbohydrate' => 23.0, 'protein' => 1.1,  'fat' => 0.3],
            ['name' => 'Eper',            'calories' => 32,  'carbohydrate' => 7.7,  'protein' => 0.7,  'fat' => 0.3],
            ['name' => 'Méz',             'calories' => 304, 'carbohydrate' => 82.0, 'protein' => 0.3,  'fat' => 0.0],
            ['name' => 'Cukkini',         'calories' => 17,  'carbohydrate' => 3.1,  'protein' => 1.2,  'fat' => 0.3],
            ['name' => 'Gomba',           'calories' => 22,  'carbohydrate' => 3.3,  'protein' => 3.1,  'fat' => 0.3],
            ['name' => 'Ketchup',         'calories' => 112, 'carbohydrate' => 26.0, 'protein' => 1.2,  'fat' => 0.2],
            ['name' => 'Mustár',          'calories' => 66,  'carbohydrate' => 6.0,  'protein' => 4.0,  'fat' => 3.3],
            ['name' => 'Zsemlemorzsa',    'calories' => 395, 'carbohydrate' => 72.0, 'protein' => 13.0, 'fat' => 5.0],
        ];

        DB::table('ingredient')->insert($ingredients);
    }
}