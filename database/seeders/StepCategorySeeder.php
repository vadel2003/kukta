<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Előkészítés', 'gif_filename' => null],
            ['name' => 'Elkészítés', 'gif_filename' => null],
            ['name' => 'Főzés', 'gif_filename' => null],
            ['name' => 'Sütés', 'gif_filename' => null],
            ['name' => 'Tálalás', 'gif_filename' => null],
        ];

        foreach ($categories as $category) {
            DB::table('step_category')->insert($category);
        }
    }
}