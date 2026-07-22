<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            'Liszt', 'Cukor', 'Só', 'Tojás', 'Tej', 'Vaj', 'Olaj', 'Víz',
            'Élesztő', 'Sütőpor', 'Vaníliás cukor', 'Csokoládé', 'Tejföl',
            'Tejszín', 'Hagyma', 'Fokhagyma', 'Paprika', 'Paradicsom',
            'Csirkemell', 'Darált hús', 'Sárgarépa', 'Burgonya', 'Rizs',
            'Tészta', 'Kenyér', 'Sajt', 'Sonka', 'Bors', 'Babérlevél',
            'Petrezselyem', 'Citrom', 'Alma', 'Banán', 'Eper', 'Méz',
            'Cukkinik', 'Gomba', 'Tejföl', 'Ketchup', 'Mustár',
        ];

        foreach ($ingredients as $name) {
            DB::table('ingredient')->insert([
                'name' => $name,
                'calories' => 0,
                'carbohydrate' => 0,
                'protein' => 0,
                'fat' => 0,
            ]);
        }
    }
}

