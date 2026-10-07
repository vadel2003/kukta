<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        $scores = [];

        // User receptjeinek mappingje
        $userRecipes = [
            1 => range(1, 10),    // admin: 1-10
            2 => range(11, 20),   // nagyanna: 11-20
            3 => range(21, 30),   // kovacsbela: 21-30
            4 => range(31, 40),   // szabocsilla: 31-40
            5 => range(41, 50),   // tothdaniel: 41-50
            6 => range(51, 60),   // molnarera: 51-60
            7 => range(61, 70),   // kisstamas: 61-70
            8 => range(71, 80),   // feherjudit: 71-80
            9 => range(81, 90),   // baloghpetter: 81-90
            10 => range(91, 100), // vargazsofia: 91-100
        ];

        for ($userId = 1; $userId <= 10; $userId++) {
            // Minden user 3-10 receptet értékel
            $scoreCount = 3 + ($userId % 8); // 3-10

            // Az összes recept, kivéve a sajátját
            $allRecipes = range(1, 100);
            $ownRecipes = $userRecipes[$userId];
            $otherRecipes = array_values(array_diff($allRecipes, $ownRecipes));

            // Determinisztikus shuffle
            mt_srand($userId * 41);
            shuffle($otherRecipes);
            $selectedRecipes = array_slice($otherRecipes, 0, $scoreCount);

            foreach ($selectedRecipes as $recipeId) {
                $scores[] = [
                    'user_id' => $userId,
                    'recipe_id' => $recipeId,
                    'score' => rand(1, 5),
                ];
            }
        }

        DB::table('score')->insert($scores);
    }
}