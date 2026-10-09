<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Előkészítés', 'gif_filename' => 'elokeszites.json'],
            ['name' => 'Elkészítés', 'gif_filename' => 'elkeszites.json'],
            ['name' => 'Főzés', 'gif_filename' => 'fozes.json'],
            ['name' => 'Sütés', 'gif_filename' => 'sutes.json'],
            ['name' => 'Tálalás', 'gif_filename' => 'talalas.json'],
        ];

        foreach ($categories as $category) {
            DB::table('step_category')->insert($category);
        }
    }
}