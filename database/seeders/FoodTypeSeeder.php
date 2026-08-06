<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTypeSeeder extends Seeder
{
    public function run(): void
    {
        $foodTypes = [
            ['name' => 'Leves',      'thumbnail' => null],
            ['name' => 'Főétel',     'thumbnail' => null],
            ['name' => 'Desszert',   'thumbnail' => null],
            ['name' => 'Előétel',    'thumbnail' => null],
            ['name' => 'Köret',      'thumbnail' => null],
            ['name' => 'Saláta',     'thumbnail' => null],
        ];

        foreach ($foodTypes as $foodType) {
            DB::table('food_type')->insert($foodType);
        }
    }
}