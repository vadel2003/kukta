<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Each user rates 3-10 recipes of other users with a random score.
     */
    public function run(): void
    {
        $ratings = [];

        // user ID => IDs of the user's own recipes
        $userRecipes = [
            1 => range(1, 10),    // kukta
            2 => range(11, 20),   // nagyanna
            3 => range(21, 30),   // kovacsbela
            4 => range(31, 40),   // szabocsilla
            5 => range(41, 50),   // tothdaniel
            6 => range(51, 60),   // molnarera
            7 => range(61, 70),   // kisstamas
            8 => range(71, 80),   // feherjudit
            9 => range(81, 90),   // baloghpetter
            10 => range(91, 100), // vargazsofia
        ];

        for ($userId = 1; $userId <= 10; $userId++) {
            $ratingCount = 3 + ($userId % 8);

            $allRecipes = range(1, 100);
            $ownRecipes = $userRecipes[$userId];
            $otherRecipes = array_values(array_diff($allRecipes, $ownRecipes));

            mt_srand($userId * 41);
            shuffle($otherRecipes);
            $selectedRecipes = array_slice($otherRecipes, 0, $ratingCount);

            foreach ($selectedRecipes as $recipeId) {
                $ratings[] = [
                    'user_id' => $userId,
                    'recipe_id' => $recipeId,
                    'score' => rand(1, 5),
                ];
            }
        }

        DB::table('rating')->insert($ratings);
    }
}
