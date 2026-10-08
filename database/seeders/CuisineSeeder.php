<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuisineSeeder extends Seeder
{
    public function run(): void
    {
        $cuisines = [
            ['name' => 'Magyar'],
            ['name' => 'Olasz'],
            ['name' => 'Francia'],
            ['name' => 'Ázsiai'],
            ['name' => 'Amerikai'],
            ['name' => 'Mexikói'],
            ['name' => 'Görög'],
        ];

        foreach ($cuisines as $cuisine) {
            DB::table('cuisine')->insert($cuisine);
        }
    }
}