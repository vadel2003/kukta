<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuisineSeeder extends Seeder
{
    public function run(): void
    {
        $cuisines = [
            ['name' => 'Magyar',   'thumbnail' => null],
            ['name' => 'Olasz',    'thumbnail' => null],
            ['name' => 'Francia',  'thumbnail' => null],
            ['name' => 'Ázsiai',   'thumbnail' => null],
            ['name' => 'Amerikai', 'thumbnail' => null],
            ['name' => 'Mexikói',  'thumbnail' => null],
        ];

        foreach ($cuisines as $cuisine) {
            DB::table('cuisine')->insert($cuisine);
        }
    }
}