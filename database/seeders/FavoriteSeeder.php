<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $favorites = [];

        for ($userId = 1; $userId <= 10; $userId++) {
            // Minden user 5-15 receptet kedvencel
            $favCount = 5 + ($userId % 11); // 5-15

            // Recept ID-k listája, shuffle-ozva determinisztikus seed-del
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