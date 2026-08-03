<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientRecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Recept -> hozzávaló ID-k mapping (recept-specifikus)
        $recipeIngredients = [
            1  => [19, 22, 21, 15, 17, 18, 7, 3, 28],          // Gulyásleves
            2  => [19, 15, 17, 18, 7, 3, 28, 13],              // Csirkepörkölt
            3  => [24, 13, 2, 6],                               // Túrós csusza
            4  => [22, 4, 13, 3],                               // Rakott krumpli
            5  => [15, 17, 7, 3, 28, 29, 24],                  // Halászlé
            6  => [1, 9, 5, 7, 13, 26],                         // Lángos
            7  => [1, 4, 5, 2, 6, 7],                           // Palacsinta
            8  => [15, 7, 3, 28, 29, 13],                       // Székelykáposzta
            9  => [19, 15, 17, 13, 7, 3],                       // Paprikás csirke
            10 => [1, 2, 6, 4],                                 // Meggyes pite
            11 => [20, 15, 18, 21, 24, 7, 3, 28],              // Bolognai spagetti
            12 => [19, 17, 18, 31, 7, 3],                       // Csirkemell saláta
            13 => [17, 20, 23, 18, 15, 7, 3],                   // Töltött paprika
            14 => [5, 13, 25, 3, 28],                           // Borsóleves
            15 => [26, 1, 4, 40, 7, 3],                         // Rántott sajt
            16 => [1, 2, 6, 4, 12],                             // Zserbó
            17 => [16, 5, 13, 25, 26, 3],                       // Fokhagymakrémleves
            18 => [15, 17, 7, 3, 28, 29],                       // Marhapörkölt
            19 => [1, 2, 6, 4, 12],                             // Dobos torta
            20 => [24, 6, 3],                                   // Káposztás tészta
            21 => [1, 4, 40, 7, 3, 31],                         // Sertésborda rántva
            22 => [18, 15, 13, 5, 3, 28],                       // Paradicsomleves
            23 => [20, 23, 15, 7, 3, 28],                       // Töltött káposzta
            24 => [25, 5, 2],                                   // Mákos guba
            25 => [15, 7, 3, 13],                               // Zöldborsófőzelék
            26 => [19, 15, 17, 13, 7, 3],                       // Csirkepaprikás
            27 => [1, 6, 2, 4, 32],                             // Almás rétes
            28 => [15, 16, 5, 13, 4, 3],                        // Spenótfőzelék
            29 => [37, 13, 15, 7, 3, 28],                       // Bakonyi sertésborda
            30 => [22, 15, 7, 3],                               // Krumplifőzelék
            31 => [37, 15, 17, 13, 7, 3, 28],                   // Gombapörkölt
            32 => [2, 40, 13, 2],                               // Túrógombóc
            33 => [22, 21, 15, 3, 28, 29, 24],                  // Húsleves
            34 => [1, 4, 5, 2, 20, 13, 26],                     // Rakott palacsinta
            35 => [20, 4, 15, 40, 7, 3, 28],                    // Fasírt
            36 => [5, 26, 13, 3],                               // Karfiolleves
            37 => [4, 39],                                      // Töltött tojás
            38 => [15, 7, 3, 28, 29],                           // Sólet
            39 => [2, 14, 5, 3],                                // Gyümölcsleves
            40 => [26, 13, 3],                                  // Puliszka
            41 => [18, 26, 7, 3, 28],                           // Sertésszelet paradicsommal
            42 => [15, 17, 7, 3, 28, 29],                       // Babgulyás
            43 => [1, 2, 6, 4, 9, 12],                          // Kakaós csiga
            44 => [22, 15, 7, 3, 28, 29],                       // Savanyú krumplileves
            45 => [19, 1, 4, 40, 7, 3, 31],                     // Rántott csirkemell
            46 => [5, 26, 13, 3],                               // Brokkoli krémleves
            47 => [20, 15, 17, 7, 3, 28],                       // Tarhonyás hús
            48 => [4, 2, 5, 11],                                // Madártej
            49 => [15, 17, 7, 3, 28, 29],                       // Csülkös bableves
            50 => [17, 18, 15, 7, 3, 4],                        // Lecsó
            51 => [22, 15, 7, 3, 30],                           // Burgonyafőzelék
            52 => [19, 26, 27, 7, 3],                           // Csirkemell rolád
            53 => [19, 18, 26, 7, 3],                           // Paradicsomos csirkemell
            54 => [5, 13, 3],                                   // Sütőtök krémleves
            55 => [20, 23, 15, 17, 7, 3],                       // Rizses hús
            56 => [1, 2, 4, 6, 10],                             // Málnás muffin
            57 => [15, 7, 3],                                   // Sárgaborsó főzelék
            58 => [12, 2, 6, 4, 1],                             // Csokis brownie
            59 => [24, 17, 18, 15, 7, 3],                       // Kolbászos lecsós tészta
            60 => [5, 2, 35],                                   // Zabkása
            61 => [15, 21, 22, 7, 3, 28, 29],                   // Sertésragu leves
            62 => [19, 26, 25, 31, 7, 3],                       // Csirkés Caesar saláta
            63 => [36, 20, 26, 15, 7, 3],                       // Rakott cukkini
            64 => [19, 15, 21, 5, 13, 3],                       // Tárkonyos csirkeraguleves
            65 => [18, 17, 26, 3, 7],                           // Görög saláta
            66 => [22, 1, 26, 9, 6, 3],                         // Burgonyás pogácsa
            67 => [24, 13, 14, 3],                              // Spenótos-tejfölös tészta
            68 => [5, 13, 3],                                   // Céklaleves
            69 => [19, 37, 14, 7, 3],                           // Mártásos csirkemell
            70 => [1, 2, 6, 4, 9],                              // Diós kalács
            71 => [19, 17, 18, 7, 3, 28],                       // Zöldséges csirke stir fry
            72 => [18, 15, 16, 7, 3, 28],                       // Paradicsomos bab
            73 => [25, 13, 26],                                 // Sajtos-tejfölös melegszendvics
            74 => [21, 22, 5, 13, 3],                           // Zöldségkrémleves
            75 => [19, 17, 18, 3, 7],                           // Csirkés wrap
            76 => [22, 24, 15, 6, 3],                           // Krumplis tészta
            77 => [12, 2, 6, 4, 1],                             // Csokoládé torta
            78 => [24, 26, 13, 18, 7, 3],                       // Zöldséges lasagne
            79 => [20, 15, 18, 16, 7, 3, 28],                   // Chilis bab
            80 => [1, 4, 5, 2, 13],                             // Túrós palacsinta
            81 => [15, 14, 7, 3, 28],                           // Borsos tokány
            82 => [19, 7, 3, 28, 31],                           // Sütőben sült csirkecomb
            83 => [5, 26, 13, 3],                               // Karfiol gratin
            84 => [22, 15, 5, 13, 3],                           // Burgonyaleves
            85 => [36, 20, 26, 15, 7, 3],                       // Töltött cukkini
            86 => [19, 15, 17, 7, 3, 28],                       // Gyros tál
            87 => [5, 2, 11, 14],                               // Vanília puding
            88 => [19, 26, 7, 3],                               // Csirkés quesadilla
            89 => [24, 18, 16, 7, 3, 28],                       // Paradicsomos tészta
            90 => [1, 2, 6, 4],                                 // Diós sütemény
            91 => [7, 3, 28],                                   // Sertésszűz pecsenye
            92 => [23, 15, 7, 3],                               // Zöldborsós rizs
            93 => [4, 13, 3],                                   // Tojásos nokedli
            94 => [1, 26, 9, 6, 3],                             // Sajtos pogácsa
            95 => [19, 14, 23, 15, 7, 3],                       // Csirke curry
            96 => [2, 14, 5, 3],                                // Meggyleves
            97 => [24, 26, 5, 13, 3],                           // Sajtos makaróni
            98 => [15, 7, 3, 28],                               // Hagymás rostélyos
            99 => [34, 2, 5, 12],                               // Epres tiramisu
            100=> [4, 17, 18, 26, 7, 3],                        // Zöldséges omlett
        ];

        // Hozzávaló metainfo: [min, max, unit]
        $meta = [
            1  => [100, 500, 'g'],         // Liszt
            2  => [50,  200, 'g'],         // Cukor
            3  => [1,   2,   'teáskanál'], // Só
            4  => [2,   6,   'db'],        // Tojás
            5  => [100, 500, 'ml'],        // Tej
            6  => [30,  100, 'g'],         // Vaj
            7  => [2,   5,   'evőkanál'], // Olaj
            8  => [100, 500, 'ml'],        // Víz
            9  => [20,  50,  'g'],         // Élesztő
            10 => [1,   2,   'teáskanál'], // Sütőpor
            11 => [1,   2,   'csomag'],    // Vaníliás cukor
            12 => [50,  200, 'g'],         // Csokoládé
            13 => [100, 300, 'g'],         // Tejföl
            14 => [100, 200, 'ml'],        // Tejszín
            15 => [1,   3,   'db'],        // Hagyma
            16 => [2,   5,   'gerezd'],    // Fokhagyma
            17 => [1,   3,   'db'],        // Paprika
            18 => [2,   5,   'db'],        // Paradicsom
            19 => [300, 800, 'g'],         // Csirkemell
            20 => [300, 500, 'g'],         // Darált hús
            21 => [2,   4,   'db'],        // Sárgarépa
            22 => [300, 800, 'g'],         // Burgonya
            23 => [150, 400, 'g'],         // Rizs
            24 => [200, 500, 'g'],         // Tészta
            25 => [4,   8,   'szelet'],    // Kenyér
            26 => [100, 200, 'g'],         // Sajt
            27 => [100, 200, 'g'],         // Sonka
            28 => [1,   2,   'teáskanál'], // Bors
            29 => [2,   3,   'db'],        // Babérlevél
            30 => [1,   1,   'csokor'],    // Petrezselyem
            31 => [1,   2,   'db'],        // Citrom
            32 => [2,   4,   'db'],        // Alma
            33 => [1,   3,   'db'],        // Banán
            34 => [200, 500, 'g'],         // Eper
            35 => [2,   5,   'evőkanál'], // Méz
            36 => [200, 500, 'g'],         // Cukkini
            37 => [200, 500, 'g'],         // Gomba
            38 => [2,   4,   'evőkanál'], // Ketchup
            39 => [1,   2,   'evőkanál'], // Mustár
            40 => [100, 200, 'g'],         // Zsemlemorzsa
        ];

        $records = [];

        foreach ($recipeIngredients as $recipeId => $ingredientIds) {
            foreach ($ingredientIds as $ingId) {
                $m = $meta[$ingId];
                $range = $m[1] - $m[0];
                // Determinisztikus mennyiség
                $quantity = $m[0] + (($recipeId * $ingId * 17) % ($range + 1));
                // Kerekítés 5-re hogy szép legyen
                $quantity = max(1, (int)(round($quantity / 5) * 5));
                // Kivételek: db, teáskanál, evőkanál, csomag, csokor, gerezd, szelet ne legyen kerekítve 5-re
                if (in_array($m[2], ['db', 'teáskanál', 'evőkanál', 'csomag', 'csokor', 'gerezd', 'szelet'])) {
                    $quantity = max(1, $m[0] + (($recipeId * $ingId * 17) % ($range + 1)));
                }

                $records[] = [
                    'ingredient_id' => $ingId,
                    'recipe_id' => $recipeId,
                    'quantity' => $quantity,
                    'unit' => $m[2],
                ];
            }
        }

        foreach (array_chunk($records, 200) as $chunk) {
            DB::table('ingredient_recipe')->insert($chunk);
        }
    }
}