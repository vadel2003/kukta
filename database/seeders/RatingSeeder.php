<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Users rate recipes of other users.
     */
    public function run(): void
    {
        // user ID => [recipe ID => score]
        $ratings = [
            1 => [20 => 4, 81 => 1, 82 => 3, 64 => 4],
            2 => [49 => 2, 82 => 2, 94 => 5, 83 => 1, 42 => 4],
            3 => [90 => 4, 48 => 3, 7 => 4, 8 => 4, 15 => 4, 87 => 1],
            4 => [4 => 4, 30 => 5, 88 => 2, 59 => 2, 65 => 1, 87 => 4, 67 => 1],
            5 => [39 => 5, 56 => 4, 86 => 5, 5 => 2, 8 => 3, 76 => 3, 67 => 3, 52 => 5],
            6 => [22 => 4, 85 => 3, 93 => 5, 76 => 4, 82 => 3, 74 => 2, 63 => 3, 20 => 5, 1 => 4],
            7 => [86 => 1, 24 => 1, 32 => 4, 8 => 2, 27 => 3, 41 => 1, 16 => 2, 7 => 2, 89 => 4, 45 => 5],
            8 => [41 => 5, 27 => 2, 34 => 1],
            9 => [63 => 1, 46 => 5, 51 => 5, 16 => 1],
            10 => [67 => 4, 58 => 4, 70 => 4, 77 => 5, 72 => 4],
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
