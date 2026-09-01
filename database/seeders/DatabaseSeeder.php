<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            IngredientSeeder::class,
            MealTimeSeeder::class,
            FoodTypeSeeder::class,
            DietSeeder::class,
            AllergenSeeder::class,
            CuisineSeeder::class,
            RecipeSeeder::class,
            StepSeeder::class,
            IngredientRecipeSeeder::class,
            FavoriteSeeder::class,
            ScoreSeeder::class,
        ]);
    }
}