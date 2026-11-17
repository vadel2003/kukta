<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            IngredientSeeder::class,
            MealTimeSeeder::class,
            FoodTypeSeeder::class,
            DietSeeder::class,
            FreeFromSeeder::class,
            CuisineSeeder::class,
            StepCategorySeeder::class,
            RecipeSeeder::class,
            FavoriteSeeder::class,
            RatingSeeder::class,
        ]);
    }
}
