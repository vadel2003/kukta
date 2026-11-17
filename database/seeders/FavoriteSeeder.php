<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('favorite')->insert([
            ['user_id' => 1, 'recipe_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'recipe_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'recipe_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'recipe_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'recipe_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'recipe_id' => 30, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => 2, 'recipe_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'recipe_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'recipe_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'recipe_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'recipe_id' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'recipe_id' => 38, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'recipe_id' => 40, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => 3, 'recipe_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'recipe_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'recipe_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'recipe_id' => 26, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'recipe_id' => 33, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'recipe_id' => 35, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => 4, 'recipe_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'recipe_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'recipe_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'recipe_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'recipe_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'recipe_id' => 22, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'recipe_id' => 28, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => 5, 'recipe_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 23, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 29, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 31, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'recipe_id' => 39, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
