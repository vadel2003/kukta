<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTypeSeeder extends Seeder
{
    public function run(): void
    {
        $foodTypes = [
            ['name' => 'Leves'],
            ['name' => 'Főétel'],
            ['name' => 'Desszert'],
            ['name' => 'Előétel'],
            ['name' => 'Köret'],
            ['name' => 'Saláta'],
            ['name' => 'Nasi'],
            ['name' => 'Tészta'],
            ['name' => 'Pékáru'],
            ['name' => 'Ital'],
            ['name' => 'Befőtt'],
            ['name' => 'Gyümölcs'],
        ];

        DB::table('food_type')->insert($foodTypes);
    }
}
