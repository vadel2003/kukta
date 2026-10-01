<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Előkészítés', 'slug' => 'elokeszites', 'gif_filename' => null],
            ['name' => 'Elkészítés', 'slug' => 'elkeszites', 'gif_filename' => null],
            ['name' => 'Főzés', 'slug' => 'fozes', 'gif_filename' => null],
            ['name' => 'Sütés', 'slug' => 'sutes', 'gif_filename' => null],
            ['name' => 'Tálalás', 'slug' => 'talalas', 'gif_filename' => null],
        ];

        foreach ($categories as $category) {
            DB::table('step_category')->insert($category);
        }
    }
}