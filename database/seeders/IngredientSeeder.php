<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        // Először kiürítjük a táblát
        DB::table('ingredient')->truncate();

        $ingredients = [
            'Liszt', 'Cukor', 'Só', 'Tojás', 'Tej', 'Vaj', 'Olaj', 'Víz',
            'Élesztő', 'Sütőpor', 'Vaníliás cukor', 'Csokoládé', 'Tejföl',
            'Tejszín', 'Hagyma', 'Fokhagyma', 'Paprika', 'Paradicsom',
            'Csirkemell', 'Darált hús', 'Sárgarépa', 'Burgonya', 'Rizs',
            'Tészta', 'Kenyér', 'Sajt', 'Sonka', 'Bors', 'Babérlevél',
            'Petrezselyem', 'Citrom', 'Alma', 'Banán', 'Eper', 'Méz',
            'Cukkini', 'Gomba', 'Ketchup', 'Mustár', 'Zsemlemorzsa',
        ];

        $i = 1;
        foreach ($ingredients as $name) {
            DB::table('ingredient')->insert([
                'id' => $i++,
                'name' => $name,
                'calories' => 0,
                'carbohydrate' => 0,
                'protein' => 0,
                'fat' => 0,
            ]);
        }
    }
}


