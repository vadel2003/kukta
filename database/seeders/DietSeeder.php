<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        $diets = [
            ['name' => 'Normál',         'thumbnail' => null],
            ['name' => 'Vegetáriánus',   'thumbnail' => null],
            ['name' => 'Vegán',          'thumbnail' => null],
        ];

        foreach ($diets as $diet) {
            DB::table('diet')->insert($diet);
        }
    }
}