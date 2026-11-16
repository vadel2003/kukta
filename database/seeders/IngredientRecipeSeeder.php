<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientRecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipeIngredients = [
            1  => [ // Gulyásleves
                ['Marhahús', 800, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Só', 2, 'teáskanál'],
            ],
            2  => [ // Paradicsomleves
                ['Paradicsom', 500, 'g'], ['Fokhagyma', 2, 'gerezd'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            3  => [ // Húsleves
                ['Csirkemell', 600, 'g'], ['Zeller', 1, 'db'], ['Hagyma', 1, 'db'], ['Só', 2, 'teáskanál'],
            ],
            4  => [ // Zöldségleves
                ['Burgonya', 300, 'g'], ['Zeller', 1, 'db'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            5  => [ // Gyümölcsleves
                ['Alma', 3, 'db'], ['Banán', 2, 'db'], ['Tej', 500, 'ml'], ['Cukor', 2, 'evőkanál'],
            ],
            6  => [ // Sajtleves
                ['Sajt', 200, 'g'], ['Vaj', 50, 'g'], ['Fokhagyma', 2, 'gerezd'], ['Liszt', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            7  => [ // Pörkölt
                ['Sertéshús', 600, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Tészta', 300, 'g'], ['Só', 2, 'teáskanál'],
            ],
            8  => [ // Rántott csirke
                ['Csirkemell', 600, 'g'], ['Liszt', 100, 'g'], ['Tojás', 2, 'db'], ['Olaj', 2, 'l'], ['Burgonya', 500, 'g'],
            ],
            9  => [ // Bolognai spagetti
                ['Sertéshús', 400, 'g'], ['Tészta', 400, 'g'], ['Paradicsom', 400, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'],
            ],
            10 => [ // Lasagne
                ['Tészta', 500, 'g'], ['Sertéshús', 600, 'g'], ['Sajt', 200, 'g'], ['Tej', 300, 'ml'], ['Liszt', 3, 'evőkanál'],
            ],
            11 => [ // Caesar saláta
                ['Csirkemell', 300, 'g'], ['Sajt', 50, 'g'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'csipet'],
            ],
            12 => [ // Görög saláta
                ['Paradicsom', 400, 'g'], ['Hagyma', 1, 'db'], ['Sajt', 150, 'g'], ['Olaj', 3, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            13 => [ // Sült krumpli
                ['Burgonya', 800, 'g'], ['Olaj', 3, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            14 => [ // Párolt rizs
                ['Rizs', 300, 'g'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            15 => [ // Palacsinta
                ['Liszt', 250, 'g'], ['Tej', 400, 'ml'], ['Tojás', 2, 'db'], ['Cukor', 2, 'evőkanál'], ['Olaj', 2, 'evőkanál'],
            ],
            16 => [ // Almás pite
                ['Liszt', 400, 'g'], ['Vaj', 200, 'g'], ['Alma', 6, 'db'], ['Cukor', 4, 'evőkanál'], ['Tojás', 1, 'db'],
            ],
            17 => [ // Tiramisu
                ['Kenyér', 200, 'g'], ['Tej', 200, 'ml'], ['Cukor', 3, 'evőkanál'], ['Kakaópor', 2, 'evőkanál'], ['Tojás', 2, 'db'],
            ],
            18 => [ // Csokoládés süti
                ['Liszt', 200, 'g'], ['Csokoládé', 150, 'g'], ['Vaj', 100, 'g'], ['Cukor', 3, 'evőkanál'], ['Tojás', 2, 'db'],
            ],
            19 => [ // Bruschetta
                ['Kenyér', 4, 'szelet'], ['Paradicsom', 3, 'db'], ['Fokhagyma', 2, 'gerezd'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'csipet'],
            ],
            20 => [ // Guacamole
                ['Paradicsom', 2, 'db'], ['Hagyma', 1, 'db'], ['Fokhagyma', 1, 'gerezd'], ['Só', 1, 'teáskanál'],
            ],
            21 => [ // Házi kenyér
                ['Liszt', 500, 'g'], ['Só', 2, 'teáskanál'], ['Olaj', 1, 'evőkanál'],
            ],
            22 => [ // Kakaós csiga
                ['Liszt', 400, 'g'], ['Tej', 250, 'ml'], ['Vaj', 80, 'g'], ['Kakaópor', 3, 'evőkanál'], ['Cukor', 3, 'evőkanál'],
            ],
            23 => [ // Narancsos smoothie
                ['Narancs', 3, 'db'], ['Banán', 1, 'db'],
            ],
            24 => [ // Banános turmix
                ['Banán', 2, 'db'], ['Tej', 300, 'ml'], ['Cukor', 1, 'evőkanál'],
            ],
            25 => [ // Almatöltelék befőtt
                ['Alma', 1, 'kg'], ['Cukor', 100, 'g'],
            ],
            26 => [ // Eperbefőtt
                ['Cukor', 150, 'g'],
            ],
            27 => [ // Friss alma
                ['Alma', 1, 'db'],
            ],
            28 => [ // Narancs szeletek
                ['Narancs', 2, 'db'],
            ],
            29 => [ // Sült hal
                ['Hal', 400, 'g'], ['Rizs', 200, 'g'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            30 => [ // Rák saláta
                ['Rák', 300, 'g'], ['Szójaszósz', 2, 'evőkanál'], ['Olaj', 1, 'evőkanál'], ['Zeller', 1, 'db'],
            ],
            31 => [ // Zellerkrémleves
                ['Zeller', 2, 'db'], ['Vaj', 40, 'g'], ['Tej', 200, 'ml'], ['Só', 1, 'teáskanál'],
            ],
            32 => [ // Mustáros csirke
                ['Csirkemell', 600, 'g'], ['Mustár', 3, 'evőkanál'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            33 => [ // Szezámmagos csirke
                ['Csirkemell', 500, 'g'], ['Szezámmag', 3, 'evőkanál'], ['Szójaszósz', 2, 'evőkanál'], ['Olaj', 2, 'evőkanál'],
            ],
            34 => [ // Földimogyorós tészta
                ['Tészta', 300, 'g'], ['Földimogyoró', 100, 'g'], ['Szójaszósz', 2, 'evőkanál'], ['Olaj', 1, 'evőkanál'],
            ],
            35 => [ // Diós süti
                ['Liszt', 250, 'g'], ['Dió', 150, 'g'], ['Vaj', 100, 'g'], ['Cukor', 3, 'evőkanál'], ['Tojás', 2, 'db'],
            ],
            36 => [ // Keto saláta
                ['Sajt', 200, 'g'], ['Paradicsom', 2, 'db'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'csipet'],
            ],
            37 => [ // Low-carb csirke
                ['Csirkemell', 400, 'g'], ['Paradicsom', 2, 'db'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'csipet'],
            ],
            38 => [ // Chilis bab
                ['Sertéshús', 500, 'g'], ['Bab', 400, 'g'], ['Hagyma', 2, 'db'], ['Paradicsom', 300, 'g'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
            39 => [ // Francia hagymaleves
                ['Hagyma', 4, 'db'], ['Vaj', 50, 'g'], ['Kenyér', 4, 'szelet'], ['Sajt', 100, 'g'], ['Só', 1, 'teáskanál'],
            ],
            40 => [ // Zöldséges rizs
                ['Rizs', 300, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Só', 1, 'teáskanál'],
            ],
        ];

        $containsMap = [
            'Glutén'       => ['Liszt', 'Tészta', 'Kenyér'],
            'Laktóz'       => ['Tej', 'Vaj', 'Sajt', 'Tejföl', 'Csokoládé'],
            'Cukor'        => ['Cukor', 'Csokoládé'],
            'Tojás'        => ['Tojás'],
            'Szója'        => ['Szójaszósz', 'Csokoládé'],
            'Diófélék'     => ['Dió'],
            'Földimogyoró' => ['Földimogyoró'],
            'Hal'          => ['Hal'],
            'Rákfélék'     => ['Rák'],
            'Zeller'       => ['Zeller'],
            'Mustár'       => ['Mustár'],
            'Szezámmag'    => ['Szezámmag'],
        ];

        $unitNumbers = [
            'g' => 0,
            'kg' => 1,
            'ml' => 2,
            'l' => 3,
            'db' => 4,
            'gerezd' => 5,
            'fej' => 6,
            'szelet' => 7,
            'csokor' => 8,
            'csomag' => 9,
            'csésze' => 10,
            'evőkanál' => 11,
            'teáskanál' => 12,
            'csipet' => 13,
        ];

        $ingredientIds = [];
        foreach (DB::table('ingredient')->get() as $row) {
            $ingredientIds[$row->name] = $row->id;
        }

        $freeFromIds = [];
        foreach (DB::table('free_from')->get() as $row) {
            $freeFromIds[$row->name] = $row->id;
        }

        $records = [];
        $freeFromRecords = [];

        foreach ($recipeIngredients as $recipeId => $ingredients) {
            $recipeContains = [];

            foreach ($ingredients as $ingredient) {
                $name = $ingredient[0];
                $quantity = $ingredient[1];
                $unit = $ingredient[2];

                $records[] = [
                    'ingredient_id' => $ingredientIds[$name],
                    'recipe_id' => $recipeId,
                    'quantity' => $quantity,
                    'unit' => $unitNumbers[$unit],
                ];

                foreach ($containsMap as $freeFrom => $names) {
                    if (in_array($name, $names)) {
                        $recipeContains[$freeFrom] = true;
                    }
                }
            }

            foreach ($freeFromIds as $freeFrom => $freeFromId) {
                if (!isset($recipeContains[$freeFrom])) {
                    $freeFromRecords[] = ['free_from_id' => $freeFromId, 'recipe_id' => $recipeId];
                }
            }
        }

        DB::table('ingredient_recipe')->insert($records);
        DB::table('free_from_recipe')->insert($freeFromRecords);
    }
}