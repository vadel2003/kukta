<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealTimeSeeder extends Seeder
{
    public function run(): void
    {
        $mealTimes = [
            ['name' => 'Reggeli'],
            ['name' => 'Ebéd'],
            ['name' => 'Vacsora'],
            ['name' => 'Uzsonna'],
            ['name' => 'Tízórai'],
        ];

        DB::table('meal_time')->insert($mealTimes);
    }
}
