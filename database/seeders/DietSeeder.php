<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        // A "Normál" átnevezése "Mindenevő"-re (id megtartásával, a recept-kapcsolatok nem sérülnek)
        DB::table('diet')->where('name', 'Normál')->update(['name' => 'Mindenevő']);

        $diets = [
            'Mindenevő',
            'Vegetáriánus',
            'Vegán',
            'Pescetáriánus',
            'Flexitáriánus',
            'Keto',
            'Low-carb',
        ];

        foreach ($diets as $name) {
            DB::table('diet')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'thumbnail' => null]
            );
        }
    }
}