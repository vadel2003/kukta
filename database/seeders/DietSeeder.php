<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        $diets = [
            ['name' => 'Mindenevő'],
            ['name' => 'Vegetáriánus'],
            ['name' => 'Vegán'],
            ['name' => 'Pescetáriánus'],
            ['name' => 'Flexitáriánus'],
            ['name' => 'Keto'],
            ['name' => 'Low-carb'],
        ];

        DB::table('diet')->insert($diets);
    }
}
