<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergenSeeder extends Seeder
{
    public function run(): void
    {
        $allergens = [
            ['name' => 'Gluténmentes',   'thumbnail' => null],
            ['name' => 'Laktózmentes',   'thumbnail' => null],
            ['name' => 'Cukormentes',    'thumbnail' => null],
            ['name' => 'Tojásmentes',    'thumbnail' => null],
        ];

        foreach ($allergens as $allergen) {
            DB::table('allergen')->insert($allergen);
        }
    }
}