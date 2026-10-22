<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Előkészítés', 'gif_filename' => 'preparation.json'],
            ['name' => 'Elkészítés', 'gif_filename' => 'making.json'],
            ['name' => 'Főzés', 'gif_filename' => 'cooking.json'],
            ['name' => 'Sütés', 'gif_filename' => 'baking.json'],
            ['name' => 'Tálalás', 'gif_filename' => 'serving.json'],
        ];

        DB::table('step_category')->insert($categories);
    }
}
