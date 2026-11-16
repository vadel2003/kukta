<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $ratings = [
            2 => [9 => 2, 22 => 5, 33 => 1, 38 => 4],
            3 => [40 => 4, 8 => 3, 7 => 4, 15 => 4, 1 => 4],
            4 => [4 => 4, 30 => 5, 28 => 2, 19 => 2],
            5 => [39 => 5, 16 => 4, 35 => 5, 36 => 3, 5 => 2],
        ];

        $records = [];
        foreach ($ratings as $userId => $scores) {
            foreach ($scores as $recipeId => $score) {
                $records[] = [
                    'user_id' => $userId,
                    'recipe_id' => $recipeId,
                    'score' => $score,
                ];
            }
        }

        DB::table('rating')->insert($records);
    }
}