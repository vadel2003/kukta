<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealTimeSeeder extends Seeder
{
    public function run(): void
    {
        $mealTimes = [
            ['name' => 'Reggeli',  'thumbnail' => null],
            ['name' => 'Ebéd',     'thumbnail' => null],
            ['name' => 'Vacsora',  'thumbnail' => null],
            ['name' => 'Uzsonna',  'thumbnail' => null],
        ];

        foreach ($mealTimes as $mealTime) {
            DB::table('meal_time')->insert($mealTime);
        }
    }
}