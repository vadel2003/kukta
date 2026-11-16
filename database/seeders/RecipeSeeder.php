<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            ['title' => 'Gulyásleves',           'description' => 'Hagyományos magyar gulyásleves marhahússal, burgonyával és paprikával.', 'prep_time' => 120, 'difficulty' => 1, 'servings' => 6, 'created_at' => '2026-01-01', 'user_id' => 1],
            ['title' => 'Paradicsomleves',       'description' => 'Könnyed, olaszos paradicsomleves fokhagymával és olajjal.', 'prep_time' => 30, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-02', 'user_id' => 1],
            ['title' => 'Húsleves',              'description' => 'Gazdag húsleves csirkemellel és zellerrel.', 'prep_time' => 90, 'difficulty' => 1, 'servings' => 6, 'created_at' => '2026-01-03', 'user_id' => 1],
            ['title' => 'Zöldségleves',          'description' => 'Egyszerű, friss zöldségleves hagymával és burgonyával.', 'prep_time' => 40, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-04', 'user_id' => 1],
            ['title' => 'Gyümölcsleves',         'description' => 'Hűsítő alma és banán leves tejjel.', 'prep_time' => 20, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-05', 'user_id' => 1],
            ['title' => 'Sajtleves',             'description' => 'Krémes sajtleves vajjal és fokhagymával.', 'prep_time' => 25, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-06', 'user_id' => 1],
            ['title' => 'Pörkölt',               'description' => 'Hagyományos sertéspörkölt galuskával', 'prep_time' => 60, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-01-07', 'user_id' => 1],
            ['title' => 'Rántott csirke',        'description' => 'Ropogós rántott csirkemell sült krumpli körettel.', 'prep_time' => 45, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-01-08', 'user_id' => 1],
            ['title' => 'Bolognai spagetti',     'description' => 'Olasz klasszikus darált sertéshússal és tésztával.', 'prep_time' => 50, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-01-09', 'user_id' => 1],
            ['title' => 'Lasagne',               'description' => 'Rétegezett tészta sajttal és hússal.', 'prep_time' => 80, 'difficulty' => 2, 'servings' => 6, 'created_at' => '2026-01-10', 'user_id' => 1],
            ['title' => 'Caesar saláta',         'description' => 'Friss saláta csirkemellel és sajttal.', 'prep_time' => 20, 'difficulty' => 0, 'servings' => 2, 'created_at' => '2026-01-11', 'user_id' => 1],
            ['title' => 'Görög saláta',          'description' => 'Paradicsom, hagyma és sajt olajjal.', 'prep_time' => 15, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-12', 'user_id' => 1],
            ['title' => 'Sült krumpli',          'description' => 'Ropogós házi sült burgonya köret vagy nasi.', 'prep_time' => 30, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-13', 'user_id' => 1],
            ['title' => 'Párolt rizs',           'description' => 'Egyszerű párolt rizs köret.', 'prep_time' => 25, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-14', 'user_id' => 1],
            ['title' => 'Palacsinta',            'description' => 'Hagyományos édes palacsinta liszttel és tejjel.', 'prep_time' => 30, 'difficulty' => 1, 'servings' => 6, 'created_at' => '2026-01-15', 'user_id' => 1],
            ['title' => 'Almás pite',            'description' => 'Omlós pite almával és fahéjas cukorral.', 'prep_time' => 60, 'difficulty' => 1, 'servings' => 8, 'created_at' => '2026-01-16', 'user_id' => 1],
            ['title' => 'Tiramisu',              'description' => 'Olasz desszert kávéval, tejjel és cukorral.', 'prep_time' => 40, 'difficulty' => 1, 'servings' => 6, 'created_at' => '2026-01-17', 'user_id' => 1],
            ['title' => 'Csokoládés süti',       'description' => 'Ízletes csokis sütemény kakaóporral.', 'prep_time' => 35, 'difficulty' => 0, 'servings' => 6, 'created_at' => '2026-01-18', 'user_id' => 1],
            ['title' => 'Bruschetta',            'description' => 'Pirítós kenyér friss paradicsommal és fokhagymával.', 'prep_time' => 15, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-19', 'user_id' => 1],
            ['title' => 'Guacamole',             'description' => 'Mexikói avokádós mártogatós nassoláshoz.', 'prep_time' => 15, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-20', 'user_id' => 1],
            ['title' => 'Házi kenyér',           'description' => 'Friss pékáru liszttel és sóval.', 'prep_time' => 180, 'difficulty' => 2, 'servings' => 8, 'created_at' => '2026-01-21', 'user_id' => 1],
            ['title' => 'Kakaós csiga',          'description' => 'Puha pékáru kakaóporral és tejjel.', 'prep_time' => 90, 'difficulty' => 1, 'servings' => 8, 'created_at' => '2026-01-22', 'user_id' => 1],
            ['title' => 'Narancsos smoothie',    'description' => 'Frissítő narancs és banán ital.', 'prep_time' => 10, 'difficulty' => 0, 'servings' => 2, 'created_at' => '2026-01-23', 'user_id' => 1],
            ['title' => 'Banános turmix',        'description' => 'Tejes banánturmix.', 'prep_time' => 10, 'difficulty' => 0, 'servings' => 2, 'created_at' => '2026-01-24', 'user_id' => 1],
            ['title' => 'Almatöltelék befőtt',   'description' => 'Tartósított alma üvegben.', 'prep_time' => 40, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-25', 'user_id' => 1],
            ['title' => 'Eperbefőtt',            'description' => 'Hagyományos eperbefőtt.', 'prep_time' => 30, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-26', 'user_id' => 1],
            ['title' => 'Friss alma',            'description' => 'Egészséges gyümölcsnasi.', 'prep_time' => 5, 'difficulty' => 0, 'servings' => 1, 'created_at' => '2026-01-27', 'user_id' => 1],
            ['title' => 'Narancs szeletek',      'description' => 'C-vitamin dús gyümölcstál.', 'prep_time' => 5, 'difficulty' => 0, 'servings' => 2, 'created_at' => '2026-01-28', 'user_id' => 1],
            ['title' => 'Sült hal',              'description' => 'Omlós halfilé rizs körettel.', 'prep_time' => 35, 'difficulty' => 1, 'servings' => 2, 'created_at' => '2026-01-29', 'user_id' => 1],
            ['title' => 'Rák saláta',            'description' => 'Exotikus rák saláta szójaszósszal.', 'prep_time' => 25, 'difficulty' => 1, 'servings' => 2, 'created_at' => '2026-01-30', 'user_id' => 1],
            ['title' => 'Zellerkrémleves',       'description' => 'Selymes zellerkrémleves vajjal.', 'prep_time' => 35, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-01-31', 'user_id' => 1],
            ['title' => 'Mustáros csirke',       'description' => 'Szaftos csirke mustáros mártásban.', 'prep_time' => 40, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-02-01', 'user_id' => 1],
            ['title' => 'Szezámmagos csirke',    'description' => 'Ázsiai stílusú csirke szezámmaggal.', 'prep_time' => 35, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-02-02', 'user_id' => 1],
            ['title' => 'Földimogyorós tészta',  'description' => 'Tészta földimogyoró szósszal.', 'prep_time' => 25, 'difficulty' => 0, 'servings' => 3, 'created_at' => '2026-02-03', 'user_id' => 1],
            ['title' => 'Diós süti',             'description' => 'Hagyományos diós sütemény.', 'prep_time' => 50, 'difficulty' => 1, 'servings' => 6, 'created_at' => '2026-02-04', 'user_id' => 1],
            ['title' => 'Keto saláta',           'description' => 'Alacsony szénhidráttartalmú saláta sajt.', 'prep_time' => 15, 'difficulty' => 0, 'servings' => 2, 'created_at' => '2026-02-05', 'user_id' => 1],
            ['title' => 'Low-carb csirke',       'description' => 'Csirkemell saláta olajjal.', 'prep_time' => 20, 'difficulty' => 0, 'servings' => 2, 'created_at' => '2026-02-06', 'user_id' => 1],
            ['title' => 'Chilis bab',            'description' => 'Mexikói húsos bab étel.', 'prep_time' => 50, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-02-07', 'user_id' => 1],
            ['title' => 'Francia hagymaleves',   'description' => 'Klasszikus hagymaleves sajtos pirítóssal.', 'prep_time' => 45, 'difficulty' => 1, 'servings' => 4, 'created_at' => '2026-02-08', 'user_id' => 1],
            ['title' => 'Zöldséges rizs',        'description' => 'Ázsiai pirított rizs zöldségekkel.', 'prep_time' => 25, 'difficulty' => 0, 'servings' => 4, 'created_at' => '2026-02-09', 'user_id' => 1],
        ];

        $categories = [
            1  => [['Leves'],                 ['Ebéd', 'Vacsora'],       ['Mindenevő', 'Flexitáriánus'],                                        ['Magyar']],   // Gulyásleves
            2  => [['Leves', 'Előétel'],      ['Ebéd', 'Tízórai'],       ['Vegetáriánus', 'Vegán', 'Flexitáriánus', 'Low-carb'],                ['Olasz']],    // Paradicsomleves
            3  => [['Leves'],                 ['Ebéd', 'Vacsora'],       ['Mindenevő', 'Flexitáriánus'],                                        ['Magyar']],   // Húsleves
            4  => [['Leves', 'Előétel'],      ['Ebéd', 'Uzsonna'],       ['Vegetáriánus', 'Vegán', 'Flexitáriánus', 'Low-carb'],                ['Francia']],  // Zöldségleves
            5  => [['Leves', 'Desszert', 'Gyümölcs'], ['Uzsonna'],       ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Magyar']],   // Gyümölcsleves
            6  => [['Leves', 'Előétel'],      ['Vacsora'],               ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto'],             ['Amerikai']], // Sajtleves
            7  => [['Főétel', 'Köret', 'Tészta'], ['Ebéd', 'Vacsora'],   ['Mindenevő', 'Flexitáriánus'],                                        ['Magyar']],   // Pörkölt
            8  => [['Főétel', 'Köret'],       ['Ebéd'],                  ['Mindenevő'],                                                         ['Amerikai']], // Rántott csirke
            9  => [['Főétel', 'Tészta'],      ['Ebéd', 'Vacsora'],       ['Mindenevő'],                                                         ['Olasz']],    // Bolognai spagetti
            10 => [['Főétel', 'Tészta'],      ['Vacsora'],               ['Mindenevő'],                                                         ['Olasz']],    // Lasagne
            11 => [['Saláta', 'Előétel'],     ['Ebéd'],                  ['Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'],                 ['Görög']],    // Caesar saláta
            12 => [['Saláta', 'Előétel'],     ['Ebéd', 'Vacsora'],       ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb', 'Vegán'], ['Görög']], // Görög saláta
            13 => [['Köret', 'Nasi'],         ['Ebéd', 'Uzsonna'],       ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],            ['Amerikai']], // Sült krumpli
            14 => [['Köret'],                 ['Ebéd', 'Vacsora'],       ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Low-carb'], ['Ázsiai']],   // Párolt rizs
            15 => [['Desszert', 'Nasi'],      ['Uzsonna', 'Reggeli'],    ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Magyar']],   // Palacsinta
            16 => [['Desszert', 'Pékáru'],    ['Uzsonna', 'Tízórai'],    ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Magyar']],   // Almás pite
            17 => [['Desszert'],              ['Uzsonna'],               ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Olasz']],    // Tiramisu
            18 => [['Desszert', 'Nasi'],      ['Uzsonna'],               ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Amerikai']], // Csokoládés süti
            19 => [['Előétel', 'Pékáru'],     ['Reggeli', 'Tízórai'],    ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Low-carb'], ['Olasz']],   // Bruschetta
            20 => [['Előétel', 'Nasi', 'Saláta'], ['Uzsonna'],           ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'], ['Mexikói']], // Guacamole
            21 => [['Pékáru'],                ['Reggeli'],               ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],            ['Francia']],  // Házi kenyér
            22 => [['Pékáru', 'Nasi'],        ['Reggeli', 'Tízórai'],    ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Magyar']],   // Kakaós csiga
            23 => [['Ital', 'Gyümölcs'],      ['Reggeli', 'Tízórai'],    ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Low-carb'], ['Amerikai']], // Narancsos smoothie
            24 => [['Ital', 'Gyümölcs'],      ['Reggeli', 'Uzsonna'],    ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Amerikai']], // Banános turmix
            25 => [['Befőtt', 'Gyümölcs'],    ['Uzsonna'],               ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Low-carb'], ['Magyar']],   // Almatöltelék befőtt
            26 => [['Befőtt', 'Gyümölcs'],    ['Uzsonna'],               ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Low-carb'], ['Magyar']],   // Eperbefőtt
            27 => [['Gyümölcs', 'Nasi'],      ['Tízórai', 'Uzsonna'],    ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'], ['Magyar']], // Friss alma
            28 => [['Gyümölcs', 'Nasi'],      ['Tízórai', 'Uzsonna'],    ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'], ['Görög']], // Narancs szeletek
            29 => [['Főétel', 'Köret'],       ['Vacsora'],               ['Pescetáriánus', 'Flexitáriánus', 'Low-carb'],                        ['Görög']],    // Sült hal
            30 => [['Saláta', 'Előétel'],     ['Ebéd'],                  ['Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'],                 ['Ázsiai']],   // Rák saláta
            31 => [['Leves', 'Előétel'],      ['Ebéd', 'Vacsora'],       ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'], ['Francia']],  // Zellerkrémleves
            32 => [['Főétel'],                ['Ebéd', 'Vacsora'],       ['Mindenevő', 'Flexitáriánus'],                                        ['Magyar']],   // Mustáros csirke
            33 => [['Főétel'],                ['Ebéd'],                  ['Mindenevő', 'Flexitáriánus'],                                        ['Ázsiai']],   // Szezámmagos csirke
            34 => [['Tészta', 'Főétel'],      ['Vacsora'],               ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],            ['Ázsiai']],   // Földimogyorós tészta
            35 => [['Desszert', 'Nasi'],      ['Uzsonna'],               ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],                     ['Magyar']],   // Diós süti
            36 => [['Saláta', 'Előétel'],     ['Ebéd'],                  ['Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus', 'Keto', 'Low-carb'], ['Amerikai']], // Keto saláta
            37 => [['Saláta', 'Főétel'],      ['Ebéd', 'Vacsora'],       ['Mindenevő', 'Flexitáriánus', 'Keto', 'Low-carb'],                    ['Amerikai']], // Low-carb csirke
            38 => [['Főétel'],                ['Ebéd', 'Vacsora'],       ['Mindenevő', 'Flexitáriánus'],                                        ['Mexikói']],  // Chilis bab
            39 => [['Leves', 'Előétel'],      ['Vacsora'],               ['Vegetáriánus', 'Flexitáriánus'],                                     ['Francia']],  // Francia hagymaleves
            40 => [['Köret', 'Főétel'],       ['Ebéd'],                  ['Vegán', 'Vegetáriánus', 'Pescetáriánus', 'Flexitáriánus'],            ['Ázsiai']],   // Zöldséges rizs
        ];

        $foodTypeIds = [];
        foreach (DB::table('food_type')->get() as $row) {
            $foodTypeIds[$row->name] = $row->id;
        }
        $mealTimeIds = [];
        foreach (DB::table('meal_time')->get() as $row) {
            $mealTimeIds[$row->name] = $row->id;
        }
        $dietIds = [];
        foreach (DB::table('diet')->get() as $row) {
            $dietIds[$row->name] = $row->id;
        }
        $cuisineIds = [];
        foreach (DB::table('cuisine')->get() as $row) {
            $cuisineIds[$row->name] = $row->id;
        }

        $thumbnailMap = [
            'Leves'    => 'images/recipes/default/soup_thumbnail.svg',
            'Főétel'   => 'images/recipes/default/main_course_thumbnail.svg',
            'Desszert' => 'images/recipes/default/dessert_thumbnail.svg',
            'Előétel'  => 'images/recipes/default/starter_thumbnail.svg',
            'Köret'    => 'images/recipes/default/side_dish_thumbnail.svg',
            'Saláta'   => 'images/recipes/default/salad_thumbnail.svg',
            'Nasi'     => 'images/recipes/default/starter_thumbnail.svg',
            'Tészta'   => 'images/recipes/default/pasta_thumbnail.svg',
            'Pékáru'   => 'images/recipes/default/bakery_thumbnail.svg',
            'Ital'     => 'images/recipes/default/drink_thumbnail.svg',
            'Befőtt'   => 'images/recipes/default/preserve_thumbnail.svg',
            'Gyümölcs' => 'images/recipes/default/fruit_thumbnail.svg',
        ];

        foreach ($recipes as $index => $recipe) {
            $recipeId = $index + 1;
            $foodTypes = $categories[$recipeId][0];
            $firstFoodType = $foodTypes[0];

            $recipe['thumbnail'] = $thumbnailMap[$firstFoodType];
            $recipe['updated_at'] = $recipe['created_at'];
            DB::table('recipe')->insert($recipe);
        }

        foreach ($categories as $recipeId => $category) {
            $foodTypes = $category[0];
            $mealTimes = $category[1];
            $diets = $category[2];
            $cuisines = $category[3];

            foreach ($foodTypes as $name) {
                DB::table('food_type_recipe')->insert(['food_type_id' => $foodTypeIds[$name], 'recipe_id' => $recipeId]);
            }
            foreach ($mealTimes as $name) {
                DB::table('meal_time_recipe')->insert(['meal_time_id' => $mealTimeIds[$name], 'recipe_id' => $recipeId]);
            }
            foreach ($diets as $name) {
                DB::table('diet_recipe')->insert(['diet_id' => $dietIds[$name], 'recipe_id' => $recipeId]);
            }
            foreach ($cuisines as $name) {
                DB::table('cuisine_recipe')->insert(['cuisine_id' => $cuisineIds[$name], 'recipe_id' => $recipeId]);
            }
        }
    }
}