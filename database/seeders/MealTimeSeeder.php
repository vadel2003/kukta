<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealTimeSeeder extends Seeder
{
    public function run(): void
    {
        $mealTimes = [
            'Reggeli',
            'Ebéd',
            'Vacsora',
            'Uzsonna',
            'Tízórai',
        ];

        foreach ($mealTimes as $name) {
            DB::table('meal_time')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'thumbnail' => null]
            );
        }
    }
}