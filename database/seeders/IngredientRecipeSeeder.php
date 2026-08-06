<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientRecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Recept -> hozzávaló ID-k mapping (recept-specifikus, a leírás és lépések alapján)
        $recipeIngredients = [
            1  => [54, 22, 21, 15, 17, 7, 3, 28, 29, 89],          // Gulyásleves
            2  => [19, 15, 17, 18, 7, 3, 28, 89, 13, 65],           // Csirkepörkölt
            3  => [24, 41, 13, 2, 6, 58, 3],                        // Túrós csusza
            4  => [22, 4, 55, 13, 3, 6],                            // Rakott krumpli (+vaj)
            5  => [60, 61, 62, 15, 7, 3, 28, 89, 24],               // Halászlé
            6  => [1, 9, 5, 7, 13, 26, 3, 2],                       // Lángos (+cukor)
            7  => [1, 4, 5, 2, 6, 7, 3],                            // Palacsinta (+só)
            8  => [53, 47, 15, 7, 3, 28, 29, 89, 13],               // Székelykáposzta
            9  => [19, 15, 17, 7, 3, 28, 89, 13, 65],               // Paprikás csirke
            10 => [1, 2, 6, 4, 48, 90],                             // Meggyes pite
            11 => [20, 15, 16, 18, 21, 79, 82, 7, 3, 28, 64, 94],   // Bolognai spagetti (+bazsalikom)
            12 => [19, 81, 18, 7, 3, 28, 31],                       // Csirkemell saláta
            13 => [17, 20, 23, 18, 15, 7, 3, 82, 28],               // Töltött paprika (+bors)
            14 => [45, 15, 6, 5, 14, 3, 28, 25],                    // Borsóleves
            15 => [26, 1, 4, 40, 7, 3],                             // Rántott sajt
            16 => [1, 2, 6, 4, 49, 84, 12],                         // Zserbó
            17 => [16, 6, 5, 14, 25, 26, 3, 28],                    // Fokhagymakrémleves
            18 => [54, 15, 7, 3, 28, 29, 89, 66, 103],              // Marhapörkölt (+zsír)
            19 => [1, 2, 6, 4, 12],                                 // Dobos torta
            20 => [46, 24, 103, 3, 28],                             // Káposztás tészta
            21 => [53, 1, 4, 40, 7, 3, 31, 28],                     // Sertésborda rántva (+bors)
            22 => [18, 15, 13, 5, 3, 28, 94, 2, 25],                // Paradicsomleves (+cukor, +kenyér)
            23 => [47, 20, 23, 15, 7, 3, 28, 55, 57],               // Töltött káposzta
            24 => [74, 5, 2, 42, 92, 4],                            // Mákos guba (+tojás)
            25 => [45, 15, 7, 3, 13, 59, 1],                        // Zöldborsófőzelék (+liszt)
            26 => [19, 15, 17, 7, 3, 28, 89, 13, 65, 103],          // Csirkepaprikás (+zsír)
            27 => [1, 6, 2, 32, 49, 90, 7, 3],                      // Almás rétes (-tojás, +olaj, +só)
            28 => [50, 15, 16, 5, 14, 13, 4, 3, 1, 7],              // Spenótfőzelék (+liszt, +olaj)
            29 => [53, 37, 15, 7, 3, 28, 13, 14],                   // Bakonyi sertésborda
            30 => [22, 15, 7, 3, 30, 1],                            // Krumplifőzelék (+liszt)
            31 => [37, 15, 17, 7, 3, 28, 89, 13, 65],               // Gombapörkölt
            32 => [41, 1, 4, 40, 2, 13, 3],                         // Túrógombóc (+só)
            33 => [54, 22, 21, 15, 3, 28, 29, 70],                  // Húsleves
            34 => [1, 4, 5, 2, 20, 15, 13, 26, 3, 28, 7],           // Rakott palacsinta (+só, +bors, +olaj)
            35 => [20, 4, 15, 40, 7, 3, 28, 22, 6, 5],              // Fasírt (+vaj, +tej)
            36 => [75, 5, 14, 26, 3],                               // Karfiolleves
            37 => [4, 39, 98, 3, 28, 30],                           // Töltött tojás (+petrezselyem)
            38 => [44, 57, 15, 7, 3, 28, 29, 4, 25],                // Sólet (+tojás, +kenyér)
            39 => [2, 14, 5, 3, 90],                                // Gyümölcsleves
            40 => [43, 26, 13, 3],                                  // Puliszka
            41 => [53, 18, 26, 7, 3, 28],                           // Sertésszelet paradicsommal
            42 => [44, 56, 15, 16, 7, 3, 28, 89],                   // Babgulyás
            43 => [1, 2, 6, 4, 9, 91, 5],                           // Kakaós csiga (+tej)
            44 => [22, 15, 7, 3, 28, 55, 57, 97],                   // Savanyú krumplileves
            45 => [19, 1, 4, 40, 7, 3, 31, 28],                     // Rántott csirkemell (+bors)
            46 => [76, 5, 14, 26, 3],                               // Brokkoli krémleves
            47 => [67, 53, 15, 17, 7, 3, 28, 89],                   // Tarhonyás hús
            48 => [4, 2, 5, 11, 92, 3],                             // Madártej (+só)
            49 => [44, 56, 55, 15, 21, 7, 3, 28],                   // Csülkös bableves
            50 => [17, 18, 15, 7, 3, 4, 55, 89],                    // Lecsó
            51 => [22, 15, 7, 3, 30, 1],                            // Burgonyafőzelék (+liszt)
            52 => [19, 26, 27, 7, 3, 28],                           // Csirkemell rolád (+bors)
            53 => [19, 18, 26, 7, 3, 82, 28],                       // Paradicsomos csirkemell (+bors)
            54 => [78, 5, 14, 3, 28, 102],                          // Sütőtök krémleves
            55 => [53, 23, 15, 17, 7, 3, 45, 89, 28],               // Rizses hús (+bors)
            56 => [1, 2, 4, 6, 10, 52],                             // Málnás muffin
            57 => [51, 15, 7, 3, 55],                               // Sárgaborsó főzelék
            58 => [12, 2, 6, 4, 1, 49],                             // Csokis brownie
            59 => [24, 17, 18, 15, 7, 3, 55, 28, 89],               // Kolbászos lecsós tészta (+bors, +pirospaprika)
            60 => [100, 5, 35, 49],                                 // Zabkása
            61 => [53, 15, 21, 22, 7, 3, 28, 29],                   // Sertésragu leves
            62 => [19, 81, 85, 25, 7, 3, 28, 98],                   // Csirkés Caesar saláta
            63 => [36, 20, 26, 15, 7, 3, 28],                       // Rakott cukkini (+bors)
            64 => [19, 15, 21, 5, 13, 3, 93, 28, 7],                // Tárkonyos csirkeraguleves (+bors, +olaj)
            65 => [18, 17, 80, 15, 83, 86, 7, 3, 28],               // Görög saláta
            66 => [22, 1, 26, 9, 6, 3, 4],                          // Burgonyás pogácsa (+tojás)
            67 => [71, 50, 16, 14, 13, 3, 7, 28, 26],               // Spenótos-tejfölös tészta (+olaj, +bors, +sajt)
            68 => [77, 5, 14, 13, 3],                               // Céklaleves
            69 => [19, 37, 15, 14, 7, 3, 28],                       // Mártásos csirkemell
            70 => [1, 2, 6, 4, 9, 49, 5],                           // Diós kalács (+tej)
            71 => [19, 17, 18, 7, 3, 28],                           // Zöldséges csirke stir fry
            72 => [44, 18, 15, 16, 82, 7, 3, 28, 55],               // Paradicsomos bab
            73 => [25, 13, 26, 3, 28],                              // Sajtos-tejfölös melegszendvics
            74 => [21, 22, 79, 5, 14, 25, 3],                       // Zöldségkrémleves
            75 => [19, 72, 81, 17, 18, 7, 3, 28],                   // Csirkés wrap (+bors)
            76 => [22, 24, 15, 7, 3, 89, 28],                       // Krumplis tészta (vaj→olaj, +bors)
            77 => [12, 2, 6, 4, 1, 91],                             // Csokoládé torta
            78 => [69, 87, 26, 18, 82, 7, 3, 28, 15, 17],           // Zöldséges lasagne (+hagyma, +paprika)
            79 => [44, 20, 15, 18, 16, 82, 7, 3, 28, 95],           // Chilis bab
            80 => [1, 4, 5, 2, 41, 13, 11],                         // Túrós palacsinta (+vaníliás cukor)
            81 => [53, 15, 14, 7, 3, 28],                           // Borsos tokány
            82 => [63, 7, 3, 28, 31],                               // Sütőben sült csirkecomb
            83 => [75, 5, 14, 26, 3],                               // Karfiol gratin
            84 => [22, 15, 5, 14, 3, 28, 58, 7],                    // Burgonyaleves (+olaj)
            85 => [36, 20, 26, 15, 7, 3, 28],                       // Töltött cukkini (+bors)
            86 => [19, 15, 17, 7, 3, 28, 73, 81, 16],               // Gyros tál (+fokhagyma)
            87 => [5, 2, 11, 14, 92, 99],                           // Vanília puding
            88 => [19, 26, 72, 7, 3, 28],                           // Csirkés quesadilla (+bors)
            89 => [24, 18, 16, 7, 3, 28, 82, 94, 26],               // Paradicsomos tészta (+sajt)
            90 => [1, 2, 6, 4, 49],                                 // Diós sütemény
            91 => [53, 7, 3, 28],                                   // Sertésszűz pecsenye
            92 => [23, 15, 7, 3, 45, 30],                           // Zöldborsós rizs (+petrezselyem)
            93 => [65, 4, 13, 7, 3],                                // Tojásos nokedli
            94 => [1, 26, 9, 6, 3, 5, 2, 13, 4],                    // Sajtos pogácsa (+tej, +cukor, +tejföl, +tojás)
            95 => [19, 15, 14, 23, 7, 3, 96],                       // Csirke curry
            96 => [48, 2, 14, 5, 90],                               // Meggyleves
            97 => [68, 26, 5, 14, 13, 3],                           // Sajtos makaróni
            98 => [53, 15, 7, 3, 28],                               // Hagymás rostélyos
            99 => [34, 2, 5, 88, 101, 91, 4, 1],                    // Epres tiramisu (+tojás, +liszt)
            100=> [4, 17, 18, 26, 7, 3, 28],                        // Zöldséges omlett (+bors)
            101=> [1, 4, 5, 2, 3, 19, 15, 7, 89, 28, 17, 18, 13],  // Hortobágyi palacsinta
            102=> [19, 21, 15, 79, 37, 3, 28, 29, 70, 7],           // Újházy-tyúkhúsleves
            103=> [53, 22, 16, 7, 89, 3, 28],                        // Brassói aprópecsenye
            104=> [1, 4, 2, 6, 91, 49, 5, 92, 12, 14],               // Somlói galuska
            105=> [15, 7, 89, 8, 22, 3, 28, 55, 17, 18],             // Debreceni gulyás
        ];

        // Hozzávaló metainfo: [min, max, unit]
        $meta = [
            1  => [100, 500, 'g'],         // Liszt
            2  => [50,  200, 'g'],         // Cukor
            3  => [1,   2,   'teáskanál'], // Só
            4  => [2,   6,   'db'],        // Tojás
            5  => [100, 500, 'ml'],        // Tej
            6  => [30,  100, 'g'],         // Vaj
            7  => [2,   5,   'evőkanál'],  // Olaj
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
            35 => [2,   5,   'evőkanál'],  // Méz
            36 => [200, 500, 'g'],         // Cukkini
            37 => [200, 500, 'g'],         // Gomba
            38 => [2,   4,   'evőkanál'],  // Ketchup
            39 => [1,   2,   'evőkanál'],  // Mustár
            40 => [100, 200, 'g'],         // Zsemlemorzsa
            41 => [200, 500, 'g'],         // Túró
            42 => [50,  150, 'g'],         // Mák
            43 => [150, 300, 'g'],         // Kukoricadara
            44 => [200, 500, 'g'],         // Szárazbab
            45 => [150, 400, 'g'],         // Zöldborsó
            46 => [300, 800, 'g'],         // Káposzta
            47 => [300, 800, 'g'],         // Savanyú káposzta
            48 => [200, 500, 'g'],         // Meggy
            49 => [50,  150, 'g'],         // Dió
            50 => [200, 500, 'g'],         // Spenót
            51 => [200, 400, 'g'],         // Sárgaborsó
            52 => [150, 300, 'g'],         // Málna
            53 => [300, 800, 'g'],         // Sertéshús
            54 => [300, 800, 'g'],         // Marhahús
            55 => [100, 300, 'g'],         // Kolbász
            56 => [200, 500, 'g'],         // Füstölt csülök
            57 => [150, 300, 'g'],         // Füstölt tarja
            58 => [50,  150, 'g'],         // Szalonna
            59 => [2,   4,   'db'],        // Virsli
            60 => [300, 800, 'g'],         // Ponty
            61 => [200, 500, 'g'],         // Harcsa
            62 => [150, 300, 'g'],         // Keszeg
            63 => [300, 800, 'g'],         // Csirkecomb
            64 => [200, 500, 'g'],         // Spagetti
            65 => [200, 500, 'g'],         // Nokedli
            66 => [100, 300, 'g'],         // Csipetke
            67 => [150, 400, 'g'],         // Tarhonya
            68 => [200, 500, 'g'],         // Makaróni
            69 => [200, 500, 'g'],         // Lasagne tészta
            70 => [100, 200, 'g'],         // Csigatészta
            71 => [200, 500, 'g'],         // Penne
            72 => [2,   4,   'db'],        // Tortilla
            73 => [2,   4,   'db'],        // Pita
            74 => [2,   4,   'db'],        // Kifli
            75 => [300, 800, 'g'],         // Karfiol
            76 => [300, 500, 'g'],         // Brokkoli
            77 => [300, 500, 'g'],         // Cékla
            78 => [300, 800, 'g'],         // Sütőtök
            79 => [1,   2,   'db'],        // Zeller
            80 => [1,   2,   'db'],        // Uborka
            81 => [1,   2,   'fej'],       // Saláta
            82 => [200, 500, 'ml'],        // Paradicsomszósz
            83 => [50,  100, 'g'],         // Olívabogyó
            84 => [50,  150, 'g'],         // Baracklekvár
            85 => [30,  100, 'g'],         // Parmezán
            86 => [100, 200, 'g'],         // Feta sajt
            87 => [100, 250, 'g'],         // Ricotta
            88 => [200, 500, 'g'],         // Mascarpone
            89 => [1,   3,   'evőkanál'],  // Pirospaprika őrlemény
            90 => [1,   2,   'teáskanál'], // Fahéj
            91 => [20,  50,  'g'],         // Kakaópor
            92 => [1,   2,   'teáskanál'], // Vanília
            93 => [1,   2,   'teáskanál'], // Tárkony
            94 => [1,   2,   'teáskanál'], // Bazsalikom
            95 => [1,   2,   'teáskanál'], // Chili
            96 => [1,   3,   'evőkanál'],  // Curry por
            97 => [1,   3,   'evőkanál'],  // Ecet
            98 => [2,   4,   'evőkanál'],  // Majonéz
            99 => [1,   3,   'evőkanál'],  // Keményítő
            100=> [50,  150, 'g'],         // Zabpehely
            101=> [100, 200, 'ml'],        // Kávé
            102=> [20,  50,  'g'],         // Tökmag
            103=> [30,  100, 'g'],         // Zsír
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
                // Kivételek: db, teáskanál, evőkanál, csomag, csokor, gerezd, szelet, fej ne legyen kerekítve 5-re
                if (in_array($m[2], ['db', 'teáskanál', 'evőkanál', 'csomag', 'csokor', 'gerezd', 'szelet', 'fej'])) {
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