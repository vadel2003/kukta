<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Each user favorites 5-15 recipes (the same ones on every run, thanks to mt_srand).
     */
    public function run(): void
    {
        $favorites = [];

        for ($userId = 1; $userId <= 10; $userId++) {
            $favCount = 5 + ($userId % 11);

            $allRecipes = range(1, 100);
            mt_srand($userId * 37);
            shuffle($allRecipes);
            $selectedRecipes = array_slice($allRecipes, 0, $favCount);

            foreach ($selectedRecipes as $recipeId) {
                $favorites[] = [
                    'user_id' => $userId,
                    'recipe_id' => $recipeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('favorites')->insert($favorites);
    }
}
