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

        DB::table('cuisine')->insert($cuisines);
    }
}
