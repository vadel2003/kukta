<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $favorites = [
            1 => [1, 5, 9, 12, 15, 30],
            2 => [3, 7, 14, 21, 38, 2, 40],
            3 => [6, 11, 18, 26, 33, 35],
            4 => [4, 10, 16, 22, 28, 17, 8],
            5 => [23, 24, 27, 29, 31, 36, 39, 2],
        ];

        $records = [];
        foreach ($favorites as $userId => $recipeIds) {
            foreach ($recipeIds as $recipeId) {
                $records[] = [
                    'user_id' => $userId,
                    'recipe_id' => $recipeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('favorite')->insert($records);
    }
}