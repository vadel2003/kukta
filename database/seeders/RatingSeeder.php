<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rating')->insert([
            ['user_id' => 2, 'recipe_id' => 9, 'score' => 2],
            ['user_id' => 2, 'recipe_id' => 22, 'score' => 5],
            ['user_id' => 2, 'recipe_id' => 33, 'score' => 1],
            ['user_id' => 2, 'recipe_id' => 38, 'score' => 4],

            ['user_id' => 3, 'recipe_id' => 1, 'score' => 4],
            ['user_id' => 3, 'recipe_id' => 7, 'score' => 4],
            ['user_id' => 3, 'recipe_id' => 8, 'score' => 3],
            ['user_id' => 3, 'recipe_id' => 15, 'score' => 4],
            ['user_id' => 3, 'recipe_id' => 40, 'score' => 4],

            ['user_id' => 4, 'recipe_id' => 4, 'score' => 4],
            ['user_id' => 4, 'recipe_id' => 19, 'score' => 2],
            ['user_id' => 4, 'recipe_id' => 28, 'score' => 2],
            ['user_id' => 4, 'recipe_id' => 30, 'score' => 5],

            ['user_id' => 5, 'recipe_id' => 5, 'score' => 2],
            ['user_id' => 5, 'recipe_id' => 16, 'score' => 4],
            ['user_id' => 5, 'recipe_id' => 35, 'score' => 5],
            ['user_id' => 5, 'recipe_id' => 36, 'score' => 3],
            ['user_id' => 5, 'recipe_id' => 39, 'score' => 5],
        ]);
    }
}
