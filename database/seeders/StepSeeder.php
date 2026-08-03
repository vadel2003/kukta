<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepSeeder extends Seeder
{
    public function run(): void
    {
        // Előkészítés lépései
        $prep = [
            'A hozzávalókat előkészítjük, megmossuk és felszeleteljük.',
            'A hagymát apró kockákra vágjuk.',
            'A zöldségeket megpucoljuk és felkockázzuk.',
            'A húst megmossuk és a recept szerint feldaraboljuk.',
            'A fűszereket előkészítjük és kimérjük.',
        ];
        // Főzés lépései
        $cook = [
            'Az olajat felforrósítjuk egy nagyobb serpenyőben.',
            'A hagymát üvegesre pirítjuk az olajon.',
            'Hozzáadjuk a húst és minden oldalról megpirítjuk.',
            'A paprikával megszórjuk és alaposan elkeverjük.',
            'Felöntjük vízzel vagy alaplével és felforraljuk.',
            'Sóval, borssal és egyéb fűszerekkel ízesítjük.',
            'Lassú tűzön főzzük, amíg az alapanyagok megpuhulnak.',
            'Időnként megkeverjük, hogy ne égjen le.',
            'A habot leszedjük a tetejéről.',
            'Az ételt lefedve pároljuk kb. 30-40 percig.',
        ];
        // Befejezés lépései
        $finish = [
            'Tejföllel vagy tejszínnel dúsítjuk az ételt.',
            'Friss petrezselyemmel megszórva tálaljuk.',
            'Forrón tálaljuk kedvenc köretünkkel.',
            'Ízlés szerint tovább fűszerezzük és tálaljuk.',
            'Tálalás előtt pihentetjük néhány percig.',
        ];

        $steps = [];
        for ($recipeId = 1; $recipeId <= 100; $recipeId++) {
            // Véletlenszerűen 3, 4 vagy 5 lépés
            $seed = $recipeId; // determinisztikus
            $stepCount = 3 + ($seed % 3); // 3, 4 vagy 5

            $stepsForRecipe = [];
            $order = 1;

            // Mindig van előkészítés
            $stepsForRecipe[] = [
                'description' => $prep[($seed - 1) % count($prep)],
                'recipe_id' => $recipeId,
                'order' => $order++,
            ];

            // Főzés lépései (1-3 db)
            $cookCount = max(1, $stepCount - 2);
            for ($i = 0; $i < $cookCount; $i++) {
                $stepsForRecipe[] = [
                    'description' => $cook[($seed + $i) % count($cook)],
                    'recipe_id' => $recipeId,
                    'order' => $order++,
                ];
            }

            // Befejezés
            $stepsForRecipe[] = [
                'description' => $finish[($seed - 1) % count($finish)],
                'recipe_id' => $recipeId,
                'order' => $order,
            ];

            $steps = array_merge($steps, $stepsForRecipe);
        }

        // Chunk-os beszúrás a hatékonyságért
        foreach (array_chunk($steps, 100) as $chunk) {
            DB::table('step')->insert($chunk);
        }
    }
}