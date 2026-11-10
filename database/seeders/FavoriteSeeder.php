<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        // user ID => IDs of the user's favorite recipes
        $favorites = [
            1 => [85, 28, 73, 67, 53, 17],
            2 => [40, 15, 60, 85, 83, 9, 87],
            3 => [27, 52, 98, 96, 53, 93, 35, 68],
            4 => [26, 62, 7, 74, 3, 77, 10, 70, 49],
            5 => [4, 30, 18, 44, 34, 57, 33, 94, 67, 2],
            6 => [82, 24, 54, 16, 34, 96, 64, 39, 52, 86, 63],
            7 => [28, 14, 12, 96, 68, 94, 64, 67, 91, 70, 26, 25],
            8 => [41, 50, 65, 29, 82, 72, 92, 32, 77, 48, 34, 20, 80],
            9 => [61, 89, 35, 73, 59, 70, 38, 66, 48, 4, 51, 5, 58, 8],
            10 => [52, 23, 97, 40, 50, 100, 89, 35, 2, 45, 25, 73, 43, 58, 82],
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
