<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTypeSeeder extends Seeder
{
    public function run(): void
    {
        $foodTypes = [
            'Leves',
            'Főétel',
            'Desszert',
            'Előétel',
            'Köret',
            'Saláta',
            'Nasi',
        ];

        foreach ($foodTypes as $name) {
            DB::table('food_type')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'thumbnail' => null]
            );
        }
    }
}