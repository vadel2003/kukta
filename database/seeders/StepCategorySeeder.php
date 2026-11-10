<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Előkészítés', 'thumbnail' => 'images/steps/preparation.svg'],
            ['name' => 'Elkészítés', 'thumbnail' => 'images/steps/making.svg'],
            ['name' => 'Főzés', 'thumbnail' => 'images/steps/cooking.svg'],
            ['name' => 'Sütés', 'thumbnail' => 'images/steps/baking.svg'],
            ['name' => 'Tálalás', 'thumbnail' => 'images/steps/serving.svg'],
        ];

        DB::table('step_category')->insert($categories);
    }
}
