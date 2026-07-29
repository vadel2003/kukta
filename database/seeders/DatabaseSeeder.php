<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Teszt felhasználó létrehozása (factory helyett közvetlen insert)
        $this->call(UserSeeder::class);

        // IngredientSeeder meghívása
        $this->call(IngredientSeeder::class);
    }
}
