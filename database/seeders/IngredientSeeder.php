<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Liszt', 'calories' => 364, 'carbohydrate' => 76.0, 'protein' => 10.0, 'fat' => 1.0],
            ['name' => 'Tészta', 'calories' => 370, 'carbohydrate' => 74.0, 'protein' => 12.0, 'fat' => 1.5],
            ['name' => 'Kenyér', 'calories' => 265, 'carbohydrate' => 49.0, 'protein' => 9.0, 'fat' => 3.2],
            ['name' => 'Tej', 'calories' => 42, 'carbohydrate' => 5.0, 'protein' => 3.4, 'fat' => 3.6],
            ['name' => 'Vaj', 'calories' => 717, 'carbohydrate' => 0.1, 'protein' => 0.85, 'fat' => 81.1],
            ['name' => 'Sajt', 'calories' => 402, 'carbohydrate' => 1.3, 'protein' => 25.0, 'fat' => 33.0],
            ['name' => 'Tejföl', 'calories' => 206, 'carbohydrate' => 4.0, 'protein' => 2.5, 'fat' => 20.0],
            ['name' => 'Cukor', 'calories' => 387, 'carbohydrate' => 100.0, 'protein' => 0.0, 'fat' => 0.0],
            ['name' => 'Tojás', 'calories' => 155, 'carbohydrate' => 1.1, 'protein' => 13.0, 'fat' => 11.0],
            ['name' => 'Szójaszósz', 'calories' => 53, 'carbohydrate' => 4.9, 'protein' => 8.1, 'fat' => 0.6],
            ['name' => 'Dió', 'calories' => 654, 'carbohydrate' => 14.0, 'protein' => 15.0, 'fat' => 65.0],
            ['name' => 'Földimogyoró', 'calories' => 567, 'carbohydrate' => 16.0, 'protein' => 25.0, 'fat' => 49.0],
            ['name' => 'Hal', 'calories' => 206, 'carbohydrate' => 0.0, 'protein' => 22.0, 'fat' => 12.0],
            ['name' => 'Rák', 'calories' => 99, 'carbohydrate' => 0.2, 'protein' => 20.0, 'fat' => 1.5],
            ['name' => 'Zeller', 'calories' => 16, 'carbohydrate' => 3.0, 'protein' => 0.7, 'fat' => 0.2],
            ['name' => 'Mustár', 'calories' => 66, 'carbohydrate' => 5.5, 'protein' => 4.4, 'fat' => 3.3],
            ['name' => 'Szezámmag', 'calories' => 573, 'carbohydrate' => 23.0, 'protein' => 18.0, 'fat' => 50.0],
            ['name' => 'Olaj', 'calories' => 884, 'carbohydrate' => 0.0, 'protein' => 0.0, 'fat' => 100.0],
            ['name' => 'Só', 'calories' => 0, 'carbohydrate' => 0.0, 'protein' => 0.0, 'fat' => 0.0],
            ['name' => 'Bors', 'calories' => 251, 'carbohydrate' => 64.0, 'protein' => 10.0, 'fat' => 3.3],
            ['name' => 'Hagyma', 'calories' => 40, 'carbohydrate' => 9.3, 'protein' => 1.1, 'fat' => 0.1],
            ['name' => 'Fokhagyma', 'calories' => 149, 'carbohydrate' => 33.0, 'protein' => 6.4, 'fat' => 0.5],
            ['name' => 'Paradicsom', 'calories' => 18, 'carbohydrate' => 3.9, 'protein' => 0.9, 'fat' => 0.2],
            ['name' => 'Burgonya', 'calories' => 77, 'carbohydrate' => 17.5, 'protein' => 2.0, 'fat' => 0.1],
            ['name' => 'Rizs', 'calories' => 130, 'carbohydrate' => 28.0, 'protein' => 2.7, 'fat' => 0.3],
            ['name' => 'Csirkemell', 'calories' => 165, 'carbohydrate' => 0.0, 'protein' => 31.0, 'fat' => 3.6],
            ['name' => 'Sertéshús', 'calories' => 242, 'carbohydrate' => 0.0, 'protein' => 27.0, 'fat' => 14.0],
            ['name' => 'Marhahús', 'calories' => 250, 'carbohydrate' => 0.0, 'protein' => 26.0, 'fat' => 15.0],
            ['name' => 'Alma', 'calories' => 52, 'carbohydrate' => 14.0, 'protein' => 0.3, 'fat' => 0.2],
            ['name' => 'Banán', 'calories' => 89, 'carbohydrate' => 23.0, 'protein' => 1.1, 'fat' => 0.3],
            ['name' => 'Narancs', 'calories' => 47, 'carbohydrate' => 12.0, 'protein' => 0.9, 'fat' => 0.1],
            ['name' => 'Csokoládé', 'calories' => 546, 'carbohydrate' => 61.0, 'protein' => 4.9, 'fat' => 31.0],
            ['name' => 'Kakaópor', 'calories' => 228, 'carbohydrate' => 58.0, 'protein' => 20.0, 'fat' => 14.0],
            ['name' => 'Bab', 'calories' => 127, 'carbohydrate' => 22.8, 'protein' => 8.7, 'fat' => 0.5],
            ['name' => 'Pirospaprika', 'calories' => 282, 'carbohydrate' => 54.0, 'protein' => 14.0, 'fat' => 13.0],
            ['name' => 'Sárgarépa', 'calories' => 41, 'carbohydrate' => 9.6, 'protein' => 0.9, 'fat' => 0.2],
            ['name' => 'Babapiskóta', 'calories' => 386, 'carbohydrate' => 77.0, 'protein' => 8.0, 'fat' => 4.0],
            ['name' => 'Mascarpone', 'calories' => 429, 'carbohydrate' => 4.8, 'protein' => 4.6, 'fat' => 44.0],
            ['name' => 'Kávé', 'calories' => 2, 'carbohydrate' => 0.0, 'protein' => 0.3, 'fat' => 0.0],
            ['name' => 'Zsemlemorzsa', 'calories' => 395, 'carbohydrate' => 72.0, 'protein' => 13.0, 'fat' => 5.3],
            ['name' => 'Római saláta', 'calories' => 17, 'carbohydrate' => 3.3, 'protein' => 1.2, 'fat' => 0.3],
            ['name' => 'Feta sajt', 'calories' => 264, 'carbohydrate' => 4.1, 'protein' => 14.0, 'fat' => 21.0],
            ['name' => 'Uborka', 'calories' => 15, 'carbohydrate' => 3.6, 'protein' => 0.7, 'fat' => 0.1],
            ['name' => 'Olívabogyó', 'calories' => 115, 'carbohydrate' => 6.0, 'protein' => 0.8, 'fat' => 11.0],
            ['name' => 'Avokádó', 'calories' => 160, 'carbohydrate' => 8.5, 'protein' => 2.0, 'fat' => 15.0],
            ['name' => 'Lime', 'calories' => 30, 'carbohydrate' => 10.5, 'protein' => 0.7, 'fat' => 0.2],
            ['name' => 'Élesztő', 'calories' => 105, 'carbohydrate' => 18.0, 'protein' => 8.4, 'fat' => 1.9],
            ['name' => 'Eper', 'calories' => 32, 'carbohydrate' => 7.7, 'protein' => 0.7, 'fat' => 0.3],
            ['name' => 'Fahéj', 'calories' => 247, 'carbohydrate' => 81.0, 'protein' => 4.0, 'fat' => 1.2],
            ['name' => 'Méz', 'calories' => 304, 'carbohydrate' => 82.0, 'protein' => 0.3, 'fat' => 0.0],
            ['name' => 'Citrom', 'calories' => 29, 'carbohydrate' => 9.3, 'protein' => 1.1, 'fat' => 0.3],
            ['name' => 'Chili', 'calories' => 40, 'carbohydrate' => 8.8, 'protein' => 1.9, 'fat' => 0.4],
            ['name' => 'Zöldborsó', 'calories' => 81, 'carbohydrate' => 14.0, 'protein' => 5.4, 'fat' => 0.4],
            ['name' => 'Meggy', 'calories' => 50, 'carbohydrate' => 12.0, 'protein' => 1.0, 'fat' => 0.3],
        ];

        DB::table('ingredient')->insert($ingredients);
    }
}
