<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Gulyásleves
        DB::table('recipe')->insert([
            'id' => 1,
            'title' => 'Gulyásleves',
            'description' => 'Hagyományos magyar gulyásleves marhahússal, burgonyával és pirospaprikával.',
            'prep_time' => 120, 'difficulty' => 1, 'servings' => 6,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-02-14', 'updated_at' => '2026-02-14',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 1, 'food_type_id' => 1]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 1, 'meal_time_id' => 2], ['recipe_id' => 1, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 1, 'diet_id' => 1], ['recipe_id' => 1, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 1, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 1, 'free_from_id' => 1], ['recipe_id' => 1, 'free_from_id' => 2],
            ['recipe_id' => 1, 'free_from_id' => 3], ['recipe_id' => 1, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 1, 'ingredient_id' => 28, 'quantity' => 800, 'unit' => 0],
            ['recipe_id' => 1, 'ingredient_id' => 21, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 1, 'ingredient_id' => 24, 'quantity' => 600, 'unit' => 0],
            ['recipe_id' => 1, 'ingredient_id' => 36, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 1, 'ingredient_id' => 35, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 1, 'ingredient_id' => 18, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 1, 'ingredient_id' => 19, 'quantity' => 2, 'unit' => 12],
            ['recipe_id' => 1, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 1, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A marhahúst megmossuk, majd kb. 2 cm-es kockákra vágjuk.'],
            ['recipe_id' => 1, 'position' => 2, 'step_category_id' => 1,
                'description' => 'A hagymát apróra vágjuk, a burgonyát és a répát meghámozzuk, felkockázzuk.'],
            ['recipe_id' => 1, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Az olajon megdinszteljük a hagymát, rádobjuk a húst, és fehéredésig pirítjuk.'],
            ['recipe_id' => 1, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Lehúzzuk a tűzről, elkeverjük benne a pirospaprikát, majd felöntjük vízzel.'],
            ['recipe_id' => 1, 'position' => 5, 'step_category_id' => 3,
                'description' => 'Sózzuk, borsozzuk, és fedő alatt kb. másfél órán át főzzük, amíg a hús megpuhul.'],
            ['recipe_id' => 1, 'position' => 6, 'step_category_id' => 3,
                'description' => 'Hozzáadjuk a burgonyát és a répát, és további 20 percig főzzük.'],
            ['recipe_id' => 1, 'position' => 7, 'step_category_id' => 5,
                'description' => 'Forrón tálaljuk, friss kenyérrel az igazi.'],
        ]);

        // Paradicsomleves

        DB::table('recipe')->insert([
            'id' => 2,
            'title' => 'Paradicsomleves',
            'description' => 'Könnyű, olaszos paradicsomleves fokhagymával és egy csipet cukorral.',
            'prep_time' => 30, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-03-02', 'updated_at' => '2026-03-02',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 2, 'food_type_id' => 1], ['recipe_id' => 2, 'food_type_id' => 4],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 2, 'meal_time_id' => 2], ['recipe_id' => 2, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 2, 'diet_id' => 2], ['recipe_id' => 2, 'diet_id' => 3],
            ['recipe_id' => 2, 'diet_id' => 4], ['recipe_id' => 2, 'diet_id' => 5],
            ['recipe_id' => 2, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 2, 'cuisine_id' => 2]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 2, 'free_from_id' => 1], ['recipe_id' => 2, 'free_from_id' => 2],
            ['recipe_id' => 2, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 2, 'ingredient_id' => 23, 'quantity' => 800, 'unit' => 0],
            ['recipe_id' => 2, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 2, 'ingredient_id' => 22, 'quantity' => 2, 'unit' => 5],
            ['recipe_id' => 2, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 2, 'ingredient_id' => 8, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 2, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 2, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 2, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A paradicsomot megmossuk és felkockázzuk, a hagymát és a fokhagymát felaprítjuk.'],
            ['recipe_id' => 2, 'position' => 2, 'step_category_id' => 3,
                'description' => 'Az olajon megdinszteljük a hagymát és a fokhagymát.'],
            ['recipe_id' => 2, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Hozzáadjuk a paradicsomot, és 10 percig pároljuk, amíg szétesik.'],
            ['recipe_id' => 2, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Felöntjük 5 dl vízzel, sózzuk, borsozzuk, cukrozzuk, és 15 percig főzzük.'],
            ['recipe_id' => 2, 'position' => 5, 'step_category_id' => 2,
                'description' => 'Botmixerrel simára turmixoljuk.'],
            ['recipe_id' => 2, 'position' => 6, 'step_category_id' => 5,
                'description' => 'Melegen, tálkákba szedve tálaljuk.'],
        ]);

        // Húsleves
        DB::table('recipe')->insert([
            'id' => 3,
            'title' => 'Húsleves',
            'description' => 'Gazdag csirkehúsleves sok zöldséggel és cérnametélttel, ahogy a nagymama főzte.',
            'prep_time' => 90, 'difficulty' => 1, 'servings' => 6,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-01-18', 'updated_at' => '2026-02-03',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 3, 'food_type_id' => 1]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 3, 'meal_time_id' => 2], ['recipe_id' => 3, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 3, 'diet_id' => 1], ['recipe_id' => 3, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 3, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 3, 'free_from_id' => 2], ['recipe_id' => 3, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 3, 'ingredient_id' => 26, 'quantity' => 600, 'unit' => 0],
            ['recipe_id' => 3, 'ingredient_id' => 36, 'quantity' => 3, 'unit' => 4],
            ['recipe_id' => 3, 'ingredient_id' => 15, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 3, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 3, 'ingredient_id' => 2, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 3, 'ingredient_id' => 19, 'quantity' => 2, 'unit' => 12],
            ['recipe_id' => 3, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 3, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A csirkét megmossuk, a répát és a zellert meghámozzuk, nagyobb darabokra vágjuk.'],
            ['recipe_id' => 3, 'position' => 2, 'step_category_id' => 3,
                'description' => 'A húst 2 liter hideg vízben feltesszük főni, és a habját leszedjük.'],
            ['recipe_id' => 3, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Hozzáadjuk a zöldségeket, az egész hagymát, a sót és a borsot.'],
            ['recipe_id' => 3, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Gyöngyöző forrásban, lassan főzzük kb. 1 órán át.'],
            ['recipe_id' => 3, 'position' => 5, 'step_category_id' => 3,
                'description' => 'A tésztát külön, sós vízben kifőzzük.'],
            ['recipe_id' => 3, 'position' => 6, 'step_category_id' => 5,
                'description' => 'A tésztát tányérba tesszük, ráöntjük a levest, mellé húst és zöldséget szedünk.'],
        ]);

        // Zöldségleves
        DB::table('recipe')->insert([
            'id' => 4,
            'title' => 'Zöldségleves',
            'description' => 'Egyszerű, gyors zöldségleves burgonyával, répával és zöldborsóval.',
            'prep_time' => 40,
            'difficulty' => 0,
            'servings' => 4,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-05-21', 'updated_at' => '2026-05-21',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 4, 'food_type_id' => 1]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 4, 'meal_time_id' => 2], ['recipe_id' => 4, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 4, 'diet_id' => 2], ['recipe_id' => 4, 'diet_id' => 3],
            ['recipe_id' => 4, 'diet_id' => 4], ['recipe_id' => 4, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 4, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 4, 'free_from_id' => 1], ['recipe_id' => 4, 'free_from_id' => 2],
            ['recipe_id' => 4, 'free_from_id' => 3], ['recipe_id' => 4, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 4, 'ingredient_id' => 24, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 4, 'ingredient_id' => 36, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 4, 'ingredient_id' => 53, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 4, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 4, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 4, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 4, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 4, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A zöldségeket megpucoljuk és felkockázzuk.'],
            ['recipe_id' => 4, 'position' => 2, 'step_category_id' => 3,
                'description' => 'Olajon megpirítjuk a hagymát és a répát, mehet rá a krumpli, a borsó és 1,5 l víz.'],
            ['recipe_id' => 4, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Sózzuk, borsozzuk, és kb. 20 perc alatt puhára főzzük.'],
        ]);

        // Gyümölcsleves
        DB::table('recipe')->insert([
            'id' => 5,
            'title' => 'Gyümölcsleves',
            'description' => 'Hideg meggyes-almás gyümölcsleves tejföllel és fahéjjal, nyári napokra.',
            'prep_time' => 30, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-07-09', 'updated_at' => '2026-07-09',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 5, 'food_type_id' => 1], ['recipe_id' => 5, 'food_type_id' => 3],
            ['recipe_id' => 5, 'food_type_id' => 12],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 5, 'meal_time_id' => 2], ['recipe_id' => 5, 'meal_time_id' => 4],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 5, 'diet_id' => 2], ['recipe_id' => 5, 'diet_id' => 4], ['recipe_id' => 5, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 5, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert(['recipe_id' => 5, 'free_from_id' => 4]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 5, 'ingredient_id' => 54, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 5, 'ingredient_id' => 29, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 5, 'ingredient_id' => 8, 'quantity' => 4, 'unit' => 11],
            ['recipe_id' => 5, 'ingredient_id' => 7, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 5, 'ingredient_id' => 1, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 5, 'ingredient_id' => 49, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 5, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A meggyet kimagozzuk, az almát meghámozzuk és felkockázzuk.'],
            ['recipe_id' => 5, 'position' => 2, 'step_category_id' => 3,
                'description' => 'A gyümölcsöt 1 liter vízzel, a cukorral és a fahéjjal feltesszük főni.'],
            ['recipe_id' => 5, 'position' => 3, 'step_category_id' => 2,
                'description' => 'A tejfölt simára keverjük a liszttel, és kevés forró levet adunk hozzá.'],
            ['recipe_id' => 5, 'position' => 4, 'step_category_id' => 3,
                'description' => 'A tejfölös keveréket a leveshez öntjük, és egyszer felforraljuk.'],
            ['recipe_id' => 5, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Kihűtjük, és jól behűtve tálaljuk.'],
        ]);

        // Sajtleves
        DB::table('recipe')->insert([
            'id' => 6,
            'title' => 'Sajtleves',
            'description' => 'Krémes sajtleves vajas rántással és fokhagymával.',
            'prep_time' => 25, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-02-27', 'updated_at' => '2026-02-27',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 6, 'food_type_id' => 1], ['recipe_id' => 6, 'food_type_id' => 4],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 6, 'meal_time_id' => 3]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 6, 'diet_id' => 2], ['recipe_id' => 6, 'diet_id' => 4], ['recipe_id' => 6, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 6, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert(['recipe_id' => 6, 'free_from_id' => 4]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 6, 'ingredient_id' => 5, 'quantity' => 50, 'unit' => 0],
            ['recipe_id' => 6, 'ingredient_id' => 1, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 6, 'ingredient_id' => 22, 'quantity' => 2, 'unit' => 5],
            ['recipe_id' => 6, 'ingredient_id' => 4, 'quantity' => 500, 'unit' => 2],
            ['recipe_id' => 6, 'ingredient_id' => 6, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 6, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 6, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A sajtot lereszeljük, a fokhagymát meghámozzuk és összezúzzuk.'],
            ['recipe_id' => 6, 'position' => 2, 'step_category_id' => 3,
                'description' => 'A vajat megolvasztjuk, belekeverjük a lisztet, és világos rántást készítünk.'],
            ['recipe_id' => 6, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Hozzáadjuk a fokhagymát, majd csomómentesen felöntjük a tejjel és 5 dl vízzel.'],
            ['recipe_id' => 6, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Sózzuk, és pár percig főzzük, amíg kicsit besűrűsödik.'],
            ['recipe_id' => 6, 'position' => 5, 'step_category_id' => 3,
                'description' => 'Lehúzzuk a tűzről, és addig keverjük benne a sajtot, amíg teljesen elolvad.'],
            ['recipe_id' => 6, 'position' => 6, 'step_category_id' => 5, 'description' => 'Forrón tálaljuk.'],
        ]);

        // Pörkölt
        DB::table('recipe')->insert([
            'id' => 7,
            'title' => 'Pörkölt',
            'description' => 'Hagyományos sertéspörkölt házi galuskával.',
            'prep_time' => 90, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-01-05', 'updated_at' => '2026-01-05',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 7, 'food_type_id' => 2]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 7, 'meal_time_id' => 2], ['recipe_id' => 7, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 7, 'diet_id' => 1], ['recipe_id' => 7, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 7, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert(['recipe_id' => 7, 'free_from_id' => 2]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 7, 'ingredient_id' => 27, 'quantity' => 800, 'unit' => 0],
            ['recipe_id' => 7, 'ingredient_id' => 21, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 7, 'ingredient_id' => 35, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 7, 'ingredient_id' => 23, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 7, 'ingredient_id' => 18, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 7, 'ingredient_id' => 19, 'quantity' => 2, 'unit' => 12],
            ['recipe_id' => 7, 'ingredient_id' => 1, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 7, 'ingredient_id' => 9, 'quantity' => 2, 'unit' => 4],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 7, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A húst 2-3 cm-es kockákra vágjuk, a hagymát apróra, a paradicsomot kockára.'],
            ['recipe_id' => 7, 'position' => 2, 'step_category_id' => 3,
                'description' => 'Az olajon üvegesre dinszteljük a hagymát, majd lehúzzuk a tűzről.'],
            ['recipe_id' => 7, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Belekeverjük a pirospaprikát, hozzáadjuk a húst, a paradicsomot és a sót.'],
            ['recipe_id' => 7, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Fedő alatt kb. egy órát pároljuk, ha elfő a leve, pótoljuk egy kis vízzel.'],
            ['recipe_id' => 7, 'position' => 5, 'step_category_id' => 2,
                'description' => 'A lisztből, a tojásokból, egy csipet sóból és 2 dl vízből galuskatésztát keverünk.'],
            ['recipe_id' => 7, 'position' => 6, 'step_category_id' => 3,
                'description' => 'Galuskaszaggatóval forrásban lévő sós vízbe szaggatjuk, és kifőzzük.'],
            ['recipe_id' => 7, 'position' => 7, 'step_category_id' => 5,
                'description' => 'A pörköltet a galuskával tálaljuk.'],
        ]);

        // Rántott csirke
        DB::table('recipe')->insert([
            'id' => 8,
            'title' => 'Rántott csirke',
            'description' => 'Ropogós rántott csirkemell házi hasábburgonyával.',
            'prep_time' => 45, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-04-11', 'updated_at' => '2026-04-12',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 8, 'food_type_id' => 2]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 8, 'meal_time_id' => 2], ['recipe_id' => 8, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 8, 'diet_id' => 1], ['recipe_id' => 8, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 8, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert(['recipe_id' => 8, 'free_from_id' => 2]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 8, 'ingredient_id' => 26, 'quantity' => 600, 'unit' => 0],
            ['recipe_id' => 8, 'ingredient_id' => 1, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 8, 'ingredient_id' => 9, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 8, 'ingredient_id' => 40, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 8, 'ingredient_id' => 24, 'quantity' => 800, 'unit' => 0],
            ['recipe_id' => 8, 'ingredient_id' => 18, 'quantity' => 500, 'unit' => 2],
            ['recipe_id' => 8, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 8, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A csirkemellet felszeleteljük, kicsit kiklopfoljuk, és megsózzuk.'],
            ['recipe_id' => 8, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A szeleteket sorban lisztbe, felvert tojásba, majd zsemlemorzsába forgatjuk.'],
            ['recipe_id' => 8, 'position' => 3, 'step_category_id' => 4,
                'description' => 'Bő, forró olajban mindkét oldalukat aranybarnára sütjük.'],
            ['recipe_id' => 8, 'position' => 4, 'step_category_id' => 1,
                'description' => 'A burgonyát meghámozzuk és hasábokra vágjuk.'],
            ['recipe_id' => 8, 'position' => 5, 'step_category_id' => 4,
                'description' => 'A hasábokat ugyanabban az olajban ropogósra sütjük, majd megsózzuk.'],
            ['recipe_id' => 8, 'position' => 6, 'step_category_id' => 5,
                'description' => 'A rántott húst a sült krumplival együtt tálaljuk.'],
        ]);

        // Bolognai spagetti
        DB::table('recipe')->insert([
            'id' => 9,
            'title' => 'Bolognai spagetti',
            'description' => 'Olasz klasszikus: spagetti darált marhahúsos paradicsomszósszal.',
            'prep_time' => 50, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/pasta_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-06-30', 'updated_at' => '2026-06-30',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 9, 'food_type_id' => 2], ['recipe_id' => 9, 'food_type_id' => 8],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 9, 'meal_time_id' => 2], ['recipe_id' => 9, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 9, 'diet_id' => 1], ['recipe_id' => 9, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 9, 'cuisine_id' => 2]);
        DB::table('free_from_recipe')->insert(['recipe_id' => 9, 'free_from_id' => 4]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 9, 'ingredient_id' => 2, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 9, 'ingredient_id' => 28, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 9, 'ingredient_id' => 23, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 9, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 9, 'ingredient_id' => 36, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 9, 'ingredient_id' => 22, 'quantity' => 2, 'unit' => 5],
            ['recipe_id' => 9, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 9, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 9, 'ingredient_id' => 6, 'quantity' => 50, 'unit' => 0],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 9, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A hagymát, a fokhagymát és a répát apróra vágjuk, a paradicsomot felkockázzuk.'],
            ['recipe_id' => 9, 'position' => 2, 'step_category_id' => 3,
                'description' => 'Az olajon megdinszteljük a zöldségeket, majd hozzáadjuk a darált húst.'],
            ['recipe_id' => 9, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Ha a hús kifehéredett, hozzáadjuk a paradicsomot és a sót, és 30 percig főzzük.'],
            ['recipe_id' => 9, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Közben a spagettit sós vízben al dentére főzzük, majd leszűrjük.'],
            ['recipe_id' => 9, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Tésztára szedjük a szószt, és jó sok reszelt sajtot szórunk rá.'],
        ]);

        // Lasagne
        DB::table('recipe')->insert([
            'id' => 10,
            'title' => 'Lasagne',
            'description' => 'Rétegezett lasagne darált hússal, paradicsomszósszal és besamellel.',
            'prep_time' => 90, 'difficulty' => 2, 'servings' => 6,
            'thumbnail' => 'images/recipes/default/pasta_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-03-23', 'updated_at' => '2026-03-23',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 10, 'food_type_id' => 2], ['recipe_id' => 10, 'food_type_id' => 8],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 10, 'meal_time_id' => 3]);
        DB::table('diet_recipe')->insert(['recipe_id' => 10, 'diet_id' => 1]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 10, 'cuisine_id' => 2]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 10, 'ingredient_id' => 2, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 10, 'ingredient_id' => 28, 'quantity' => 600, 'unit' => 0],
            ['recipe_id' => 10, 'ingredient_id' => 23, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 10, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 10, 'ingredient_id' => 5, 'quantity' => 50, 'unit' => 0],
            ['recipe_id' => 10, 'ingredient_id' => 1, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 10, 'ingredient_id' => 4, 'quantity' => 500, 'unit' => 2],
            ['recipe_id' => 10, 'ingredient_id' => 6, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 10, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 10, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A darált húst a hagymával megpirítjuk, majd a paradicsommal 20 percig főzzük.'],
            ['recipe_id' => 10, 'position' => 2, 'step_category_id' => 3,
                'description' => 'A vajból és a lisztből rántást készítünk, felöntjük a tejjel, és sűrűre főzzük.'],
            ['recipe_id' => 10, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Tepsibe rétegezzük a lasagnelapokat, a húsos szószt és a besamelt.'],
            ['recipe_id' => 10, 'position' => 4, 'step_category_id' => 2,
                'description' => 'A tetejére besamel kerül, ezt megszórjuk a reszelt sajttal.'],
            ['recipe_id' => 10, 'position' => 5, 'step_category_id' => 4,
                'description' => '180 fokon kb. 40 percig sütjük, amíg a teteje aranybarna lesz.'],
            ['recipe_id' => 10, 'position' => 6, 'step_category_id' => 5,
                'description' => 'Pár perc pihentetés után szeletekre vágva tálaljuk.'],
        ]);

        // Caesar saláta
        DB::table('recipe')->insert([
            'id' => 11,
            'title' => 'Caesar saláta',
            'description' => 'Római saláta sült csirkemellel, pirított kenyérkockával és reszelt sajttal.',
            'prep_time' => 25, 'difficulty' => 0, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/salad_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-08-02', 'updated_at' => '2026-08-02',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 11, 'food_type_id' => 6], ['recipe_id' => 11, 'food_type_id' => 2],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 11, 'meal_time_id' => 2]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 11, 'diet_id' => 1], ['recipe_id' => 11, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 11, 'cuisine_id' => 5]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 11, 'ingredient_id' => 41, 'quantity' => 1, 'unit' => 6],
            ['recipe_id' => 11, 'ingredient_id' => 26, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 11, 'ingredient_id' => 3, 'quantity' => 2, 'unit' => 7],
            ['recipe_id' => 11, 'ingredient_id' => 6, 'quantity' => 50, 'unit' => 0],
            ['recipe_id' => 11, 'ingredient_id' => 9, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 11, 'ingredient_id' => 16, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 11, 'ingredient_id' => 51, 'quantity' => 0.5, 'unit' => 4],
            ['recipe_id' => 11, 'ingredient_id' => 18, 'quantity' => 4, 'unit' => 11],
            ['recipe_id' => 11, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 11, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A salátát megmossuk, szárazra csepegtetjük és falatnyi darabokra tépjük.'],
            ['recipe_id' => 11, 'position' => 2, 'step_category_id' => 4,
                'description' => 'A csirkemellet sózzuk, kevés olajon átsütjük, majd felszeleteljük.'],
            ['recipe_id' => 11, 'position' => 3, 'step_category_id' => 4,
                'description' => 'A kenyeret felkockázzuk, és serpenyőben ropogósra pirítjuk.'],
            ['recipe_id' => 11, 'position' => 4, 'step_category_id' => 2,
                'description' => 'Az öntethez a tojássárgáját, a mustárt, a citrom levét és az olajat kikeverjük.'],
            ['recipe_id' => 11, 'position' => 5, 'step_category_id' => 5,
                'description' => 'A salátára rakjuk a csirkét és a kenyérkockát, meglocsoljuk, sajtot reszelünk rá.'],
        ]);

        // Görög saláta
        DB::table('recipe')->insert([
            'id' => 12,
            'title' => 'Görög saláta',
            'description' => 'Friss saláta paradicsommal, uborkával, hagymával, fetával és olívabogyóval.',
            'prep_time' => 15, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/salad_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-07-15', 'updated_at' => '2026-07-15',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 12, 'food_type_id' => 6], ['recipe_id' => 12, 'food_type_id' => 4],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 12, 'meal_time_id' => 2], ['recipe_id' => 12, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 12, 'diet_id' => 2], ['recipe_id' => 12, 'diet_id' => 4],
            ['recipe_id' => 12, 'diet_id' => 5], ['recipe_id' => 12, 'diet_id' => 6],
            ['recipe_id' => 12, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 12, 'cuisine_id' => 7]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 12, 'free_from_id' => 1], ['recipe_id' => 12, 'free_from_id' => 3],
            ['recipe_id' => 12, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 12, 'ingredient_id' => 23, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 12, 'ingredient_id' => 43, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 12, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 12, 'ingredient_id' => 42, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 12, 'ingredient_id' => 44, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 12, 'ingredient_id' => 18, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 12, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 12, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A paradicsomot és az uborkát nagyobb kockákra, a hagymát vékony karikákra vágjuk.'],
            ['recipe_id' => 12, 'position' => 2, 'step_category_id' => 5,
                'description' => 'Mehet rá az olívabogyó, a morzsolt feta, egy kis só és olaj.'],
        ]);

        // Sült krumpli
        DB::table('recipe')->insert([
            'id' => 13,
            'title' => 'Sült krumpli',
            'description' => 'Ropogós, sütőben sült burgonya köretnek vagy nassolnivalónak.',
            'prep_time' => 45, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/side_dish_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-09-04', 'updated_at' => '2026-09-04',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 13, 'food_type_id' => 5], ['recipe_id' => 13, 'food_type_id' => 7],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 13, 'meal_time_id' => 2], ['recipe_id' => 13, 'meal_time_id' => 4],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 13, 'diet_id' => 2], ['recipe_id' => 13, 'diet_id' => 3],
            ['recipe_id' => 13, 'diet_id' => 4], ['recipe_id' => 13, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 13, 'cuisine_id' => 5]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 13, 'free_from_id' => 1], ['recipe_id' => 13, 'free_from_id' => 2],
            ['recipe_id' => 13, 'free_from_id' => 3], ['recipe_id' => 13, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 13, 'ingredient_id' => 24, 'quantity' => 1, 'unit' => 1],
            ['recipe_id' => 13, 'ingredient_id' => 18, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 13, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 13, 'ingredient_id' => 35, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 13, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A burgonyát meghámozzuk, és egyforma hasábokra vágjuk.'],
            ['recipe_id' => 13, 'position' => 2, 'step_category_id' => 2,
                'description' => 'Tálban összeforgatjuk az olajjal, a sóval és a pirospaprikával.'],
            ['recipe_id' => 13, 'position' => 3, 'step_category_id' => 4,
                'description' => 'Tepsibe terítjük, és 200 fokon kb. 35 percig sütjük, félidőben átforgatjuk.'],
        ]);

        // Párolt rizs
        DB::table('recipe')->insert([
            'id' => 14,
            'title' => 'Párolt rizs',
            'description' => 'Egyszerű, puha párolt rizs, a legtöbb főételhez illő köret.',
            'prep_time' => 25, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/side_dish_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-01-26', 'updated_at' => '2026-01-26',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 14, 'food_type_id' => 5]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 14, 'meal_time_id' => 2], ['recipe_id' => 14, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 14, 'diet_id' => 2], ['recipe_id' => 14, 'diet_id' => 3],
            ['recipe_id' => 14, 'diet_id' => 4], ['recipe_id' => 14, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 14, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 14, 'free_from_id' => 1], ['recipe_id' => 14, 'free_from_id' => 2],
            ['recipe_id' => 14, 'free_from_id' => 3], ['recipe_id' => 14, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 14, 'ingredient_id' => 25, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 14, 'ingredient_id' => 18, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 14, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 14, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A megmosott rizst kevés olajon üvegesre pirítjuk.'],
            ['recipe_id' => 14, 'position' => 2, 'step_category_id' => 3,
                'description' => 'Rá a dupla mennyiségű víz, só, és lefedve, kis lángon 18 perc. Nem kevergetjük!'],
            ['recipe_id' => 14, 'position' => 3, 'step_category_id' => 5,
                'description' => 'Villával átlazítjuk, és kész.'],
        ]);

        // Palacsinta
        DB::table('recipe')->insert([
            'id' => 15,
            'title' => 'Palacsinta',
            'description' => 'Vékony, hagyományos palacsinta, kedvünk szerint töltve.',
            'prep_time' => 30, 'difficulty' => 1, 'servings' => 6,
            'thumbnail' => 'images/recipes/default/dessert_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-03-08', 'updated_at' => '2026-05-19',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 15, 'food_type_id' => 3], ['recipe_id' => 15, 'food_type_id' => 7],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 15, 'meal_time_id' => 1], ['recipe_id' => 15, 'meal_time_id' => 4],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 15, 'diet_id' => 2], ['recipe_id' => 15, 'diet_id' => 4],
            ['recipe_id' => 15, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 15, 'cuisine_id' => 1]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 15, 'ingredient_id' => 1, 'quantity' => 250, 'unit' => 0],
            ['recipe_id' => 15, 'ingredient_id' => 4, 'quantity' => 500, 'unit' => 2],
            ['recipe_id' => 15, 'ingredient_id' => 9, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 15, 'ingredient_id' => 8, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 15, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 13],
            ['recipe_id' => 15, 'ingredient_id' => 18, 'quantity' => 3, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 15, 'position' => 1, 'step_category_id' => 2,
                'description' => 'A lisztet, a tojásokat, a cukrot és a sót a tej felével csomómentesre keverjük.'],
            ['recipe_id' => 15, 'position' => 2, 'step_category_id' => 2,
                'description' => 'Hozzáadjuk a maradék tejet és az olajat, majd 20 percig pihentetjük.'],
            ['recipe_id' => 15, 'position' => 3, 'step_category_id' => 4,
                'description' => 'Forró serpenyőben vékony lapokat sütünk, mindegyiket mindkét oldalán.'],
            ['recipe_id' => 15, 'position' => 4, 'step_category_id' => 5,
                'description' => 'Mehet bele lekvár, kakaó vagy túró, kinek mi a kedvence.'],
        ]);

        // Almás pite
        DB::table('recipe')->insert([
            'id' => 16,
            'title' => 'Almás pite',
            'description' => 'Omlós tésztás almás pite fahéjas töltelékkel.',
            'prep_time' => 75, 'difficulty' => 1, 'servings' => 10,
            'thumbnail' => 'images/recipes/default/dessert_thumbnail.svg',
            'user_id' => 3,
            'created_at' => '2026-10-12', 'updated_at' => '2026-10-12',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 16, 'food_type_id' => 3], ['recipe_id' => 16, 'food_type_id' => 9],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 16, 'meal_time_id' => 4], ['recipe_id' => 16, 'meal_time_id' => 5],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 16, 'diet_id' => 2], ['recipe_id' => 16, 'diet_id' => 4],
            ['recipe_id' => 16, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 16, 'cuisine_id' => 1]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 16, 'ingredient_id' => 1, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 16, 'ingredient_id' => 5, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 16, 'ingredient_id' => 8, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 16, 'ingredient_id' => 9, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 16, 'ingredient_id' => 29, 'quantity' => 1, 'unit' => 1],
            ['recipe_id' => 16, 'ingredient_id' => 49, 'quantity' => 2, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 16, 'position' => 1, 'step_category_id' => 2,
                'description' => 'A lisztet elmorzsoljuk a hideg vajjal, és a tojással, 80 g cukorral összegyúrjuk.'],
            ['recipe_id' => 16, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A tésztát két részre osztjuk, és 30 percre hűtőbe tesszük.'],
            ['recipe_id' => 16, 'position' => 3, 'step_category_id' => 1,
                'description' => 'Az almát lereszeljük, kinyomkodjuk, és elkeverjük a maradék cukorral és a fahéjjal.'],
            ['recipe_id' => 16, 'position' => 4, 'step_category_id' => 2,
                'description' => 'Az egyik lapot tepsibe tesszük, rásimítjuk a tölteléket, és befedjük a másikkal.'],
            ['recipe_id' => 16, 'position' => 5, 'step_category_id' => 4,
                'description' => '180 fokon kb. 40 percig sütjük.'],
            ['recipe_id' => 16, 'position' => 6, 'step_category_id' => 5,
                'description' => 'Kihűlés után szeletekre vágva tálaljuk.'],
        ]);

        // Tiramisu
        DB::table('recipe')->insert([
            'id' => 17,
            'title' => 'Tiramisu',
            'description' => 'Olasz desszert kávéba mártott babapiskótával és mascarponés krémmel.',
            'prep_time' => 40, 'difficulty' => 1, 'servings' => 8,
            'thumbnail' => 'images/recipes/default/dessert_thumbnail.svg',
            'user_id' => 3,
            'created_at' => '2026-04-27', 'updated_at' => '2026-04-27',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 17, 'food_type_id' => 3]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 17, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 17, 'diet_id' => 2], ['recipe_id' => 17, 'diet_id' => 4],
            ['recipe_id' => 17, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 17, 'cuisine_id' => 2]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 17, 'ingredient_id' => 37, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 17, 'ingredient_id' => 38, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 17, 'ingredient_id' => 9, 'quantity' => 4, 'unit' => 4],
            ['recipe_id' => 17, 'ingredient_id' => 8, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 17, 'ingredient_id' => 39, 'quantity' => 300, 'unit' => 2],
            ['recipe_id' => 17, 'ingredient_id' => 33, 'quantity' => 2, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 17, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A kávét lefőzzük, és teljesen kihűtjük.'],
            ['recipe_id' => 17, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A tojássárgákat a cukorral habosra keverjük, majd hozzákeverjük a mascarponét.'],
            ['recipe_id' => 17, 'position' => 3, 'step_category_id' => 2,
                'description' => 'A tojásfehérjéket kemény habbá verjük, és óvatosan a krémhez forgatjuk.'],
            ['recipe_id' => 17, 'position' => 4, 'step_category_id' => 2,
                'description' => 'A piskótákat egyenként a kávéba mártjuk, és egy tál aljára rakjuk.'],
            ['recipe_id' => 17, 'position' => 5, 'step_category_id' => 2,
                'description' => 'Rásimítjuk a krém felét, majd megismételjük a piskóta- és krémréteget.'],
            ['recipe_id' => 17, 'position' => 6, 'step_category_id' => 5,
                'description' => 'Egy éjszakára hűtőbe tesszük, tálalás előtt kakaót szitálunk a tetejére.'],
        ]);

        // Csokoládés süti
        DB::table('recipe')->insert([
            'id' => 18,
            'title' => 'Csokoládés süti',
            'description' => 'Szaftos, sűrű csokis brownie, kockákra vágva.',
            'prep_time' => 40, 'difficulty' => 0, 'servings' => 12,
            'thumbnail' => 'images/recipes/default/dessert_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-02-09', 'updated_at' => '2026-02-09',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 18, 'food_type_id' => 3], ['recipe_id' => 18, 'food_type_id' => 7],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 18, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 18, 'diet_id' => 2], ['recipe_id' => 18, 'diet_id' => 4],
            ['recipe_id' => 18, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 18, 'cuisine_id' => 5]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 18, 'ingredient_id' => 32, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 18, 'ingredient_id' => 5, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 18, 'ingredient_id' => 8, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 18, 'ingredient_id' => 9, 'quantity' => 3, 'unit' => 4],
            ['recipe_id' => 18, 'ingredient_id' => 1, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 18, 'ingredient_id' => 33, 'quantity' => 2, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 18, 'position' => 1, 'step_category_id' => 2,
                'description' => 'A csokoládét és a vajat vízgőz felett összeolvasztjuk, majd kicsit hűlni hagyjuk.'],
            ['recipe_id' => 18, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A tojásokat a cukorral habosra keverjük, és hozzáöntjük a csokis keveréket.'],
            ['recipe_id' => 18, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Beleszitáljuk a lisztet és a kakaóport, és épp csak összekeverjük.'],
            ['recipe_id' => 18, 'position' => 4, 'step_category_id' => 4,
                'description' => 'Sütőpapíros tepsibe öntjük, és 180 fokon kb. 25 percig sütjük.'],
            ['recipe_id' => 18, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Ha kihűlt, kockákra vágjuk. A közepe maradjon kicsit ragacsos!'],
        ]);

        // Bruschetta
        DB::table('recipe')->insert([
            'id' => 19,
            'title' => 'Bruschetta',
            'description' => 'Pirított kenyér friss paradicsommal, fokhagymával és olívaolajjal.',
            'prep_time' => 15, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/starter_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-06-06', 'updated_at' => '2026-06-06',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 19, 'food_type_id' => 4]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 19, 'meal_time_id' => 3], ['recipe_id' => 19, 'meal_time_id' => 5],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 19, 'diet_id' => 2], ['recipe_id' => 19, 'diet_id' => 3],
            ['recipe_id' => 19, 'diet_id' => 4], ['recipe_id' => 19, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 19, 'cuisine_id' => 2]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 19, 'free_from_id' => 2], ['recipe_id' => 19, 'free_from_id' => 3],
            ['recipe_id' => 19, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 19, 'ingredient_id' => 3, 'quantity' => 8, 'unit' => 7],
            ['recipe_id' => 19, 'ingredient_id' => 23, 'quantity' => 4, 'unit' => 4],
            ['recipe_id' => 19, 'ingredient_id' => 22, 'quantity' => 2, 'unit' => 5],
            ['recipe_id' => 19, 'ingredient_id' => 18, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 19, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 19, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A paradicsomot apró kockákra vágjuk, sózzuk, és elkeverjük 2 evőkanál olajjal.'],
            ['recipe_id' => 19, 'position' => 2, 'step_category_id' => 4,
                'description' => 'A kenyérszeleteket serpenyőben vagy sütőben ropogósra pirítjuk.'],
            ['recipe_id' => 19, 'position' => 3, 'step_category_id' => 2,
                'description' => 'A még meleg kenyeret bedörzsöljük a félbevágott fokhagymával.'],
            ['recipe_id' => 19, 'position' => 4, 'step_category_id' => 5,
                'description' => 'Rákanalazzuk a paradicsomot, meglocsoljuk a maradék olajjal, és azonnal tálaljuk.'],
        ]);

        // Guacamole
        DB::table('recipe')->insert([
            'id' => 20,
            'title' => 'Guacamole',
            'description' => 'Mexikói avokádókrém lime-mal, paradicsommal és hagymával, mártogatósnak.',
            'prep_time' => 15, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/starter_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-08-19', 'updated_at' => '2026-08-19',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 20, 'food_type_id' => 4], ['recipe_id' => 20, 'food_type_id' => 7],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 20, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 20, 'diet_id' => 2], ['recipe_id' => 20, 'diet_id' => 3],
            ['recipe_id' => 20, 'diet_id' => 4], ['recipe_id' => 20, 'diet_id' => 5],
            ['recipe_id' => 20, 'diet_id' => 6], ['recipe_id' => 20, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 20, 'cuisine_id' => 6]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 20, 'free_from_id' => 1], ['recipe_id' => 20, 'free_from_id' => 2],
            ['recipe_id' => 20, 'free_from_id' => 3], ['recipe_id' => 20, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 20, 'ingredient_id' => 45, 'quantity' => 3, 'unit' => 4],
            ['recipe_id' => 20, 'ingredient_id' => 46, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 20, 'ingredient_id' => 23, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 20, 'ingredient_id' => 21, 'quantity' => 0.5, 'unit' => 4],
            ['recipe_id' => 20, 'ingredient_id' => 22, 'quantity' => 1, 'unit' => 5],
            ['recipe_id' => 20, 'ingredient_id' => 52, 'quantity' => 0.5, 'unit' => 4],
            ['recipe_id' => 20, 'ingredient_id' => 19, 'quantity' => 0.5, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 20, 'position' => 1, 'step_category_id' => 1,
                'description' => 'Az avokádókat félbevágjuk, kimagozzuk, és a húsukat egy tálba kanalazzuk.'],
            ['recipe_id' => 20, 'position' => 2, 'step_category_id' => 2,
                'description' => 'Villával pürésítjük, és rögtön rácsavarjuk a lime levét, hogy ne barnuljon meg.'],
            ['recipe_id' => 20, 'position' => 3, 'step_category_id' => 1,
                'description' => 'A paradicsomot, a hagymát, a fokhagymát és a chilit nagyon apróra vágjuk.'],
            ['recipe_id' => 20, 'position' => 4, 'step_category_id' => 2,
                'description' => 'Az egészet összekeverjük az avokádóval, és megsózzuk.'],
            ['recipe_id' => 20, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Tortilla chipsszel vagy friss zöldségekkel tálaljuk.'],
        ]);

        // Házi kenyér
        DB::table('recipe')->insert([
            'id' => 21,
            'title' => 'Házi kenyér',
            'description' => 'Ropogós héjú, egyszerű fehér kenyér házi sütéshez.',
            'prep_time' => 180, 'difficulty' => 2, 'servings' => 10,
            'thumbnail' => 'images/recipes/default/bakery_thumbnail.svg',
            'user_id' => 3,
            'created_at' => '2026-05-03', 'updated_at' => '2026-05-10',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 21, 'food_type_id' => 9]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 21, 'meal_time_id' => 1]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 21, 'diet_id' => 2], ['recipe_id' => 21, 'diet_id' => 3],
            ['recipe_id' => 21, 'diet_id' => 4], ['recipe_id' => 21, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 21, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 21, 'free_from_id' => 2], ['recipe_id' => 21, 'free_from_id' => 3],
            ['recipe_id' => 21, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 21, 'ingredient_id' => 1, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 21, 'ingredient_id' => 47, 'quantity' => 20, 'unit' => 0],
            ['recipe_id' => 21, 'ingredient_id' => 19, 'quantity' => 2, 'unit' => 12],
            ['recipe_id' => 21, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 21, 'position' => 1, 'step_category_id' => 2,
                'description' => 'Az élesztőt 3 dl langyos vízben feloldjuk.'],
            ['recipe_id' => 21, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A lisztet összekeverjük a sóval, hozzáöntjük az élesztős vizet és az olajat.'],
            ['recipe_id' => 21, 'position' => 3, 'step_category_id' => 2,
                'description' => '10 percig dagasztjuk, amíg sima, rugalmas tésztát kapunk.'],
            ['recipe_id' => 21, 'position' => 4, 'step_category_id' => 2,
                'description' => 'Letakarva, meleg helyen 1 órát kelesztjük, amíg duplájára nő.'],
            ['recipe_id' => 21, 'position' => 5, 'step_category_id' => 2,
                'description' => 'Cipót formázunk belőle, és még 40 percig kelni hagyjuk.'],
            ['recipe_id' => 21, 'position' => 6, 'step_category_id' => 4,
                'description' => 'Előmelegített sütőben 220 fokon kb. 35 percig sütjük.'],
            ['recipe_id' => 21, 'position' => 7, 'step_category_id' => 5,
                'description' => 'Hagyjuk kihűlni, mielőtt felvágjuk, különben ragacsos lesz a belseje.'],
        ]);

        // Kakaós csiga
        DB::table('recipe')->insert([
            'id' => 22,
            'title' => 'Kakaós csiga',
            'description' => 'Puha, kelt tésztás kakaós csiga, mint a pékségben.',
            'prep_time' => 120, 'difficulty' => 1, 'servings' => 12,
            'thumbnail' => 'images/recipes/default/bakery_thumbnail.svg',
            'user_id' => 3,
            'created_at' => '2026-09-21', 'updated_at' => '2026-09-21',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 22, 'food_type_id' => 9], ['recipe_id' => 22, 'food_type_id' => 7],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 22, 'meal_time_id' => 1], ['recipe_id' => 22, 'meal_time_id' => 5],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 22, 'diet_id' => 2], ['recipe_id' => 22, 'diet_id' => 4],
            ['recipe_id' => 22, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 22, 'cuisine_id' => 1]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 22, 'ingredient_id' => 1, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 22, 'ingredient_id' => 4, 'quantity' => 250, 'unit' => 2],
            ['recipe_id' => 22, 'ingredient_id' => 47, 'quantity' => 25, 'unit' => 0],
            ['recipe_id' => 22, 'ingredient_id' => 5, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 22, 'ingredient_id' => 8, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 22, 'ingredient_id' => 9, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 22, 'ingredient_id' => 33, 'quantity' => 4, 'unit' => 11],
            ['recipe_id' => 22, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 22, 'position' => 1, 'step_category_id' => 2,
                'description' => 'Az élesztőt a langyos tejben egy kanál cukorral felfuttatjuk.'],
            ['recipe_id' => 22, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A liszthez adjuk a tejet, a tojást, a sót és a vaj felét, és megdagasztjuk.'],
            ['recipe_id' => 22, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Letakarva, meleg helyen 1 órát kelesztjük.'],
            ['recipe_id' => 22, 'position' => 4, 'step_category_id' => 2,
                'description' => 'Téglalappá nyújtjuk, megkenjük a maradék vajjal, és megszórjuk a cukros kakaóval.'],
            ['recipe_id' => 22, 'position' => 5, 'step_category_id' => 2,
                'description' => 'Szorosan feltekerjük, 3 cm-es szeletekre vágjuk, és tepsibe sorakoztatjuk.'],
            ['recipe_id' => 22, 'position' => 6, 'step_category_id' => 4,
                'description' => '180 fokon kb. 25 percig sütjük.'],
            ['recipe_id' => 22, 'position' => 7, 'step_category_id' => 5,
                'description' => 'Langyosan a legjobb, egy bögre tejjel.'],
        ]);

        // Narancsos smoothie
        DB::table('recipe')->insert([
            'id' => 23,
            'title' => 'Narancsos smoothie',
            'description' => 'Frissítő narancsos-banános smoothie hozzáadott cukor nélkül.',
            'prep_time' => 10, 'difficulty' => 0, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/drink_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-07-28', 'updated_at' => '2026-07-28',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 23, 'food_type_id' => 10], ['recipe_id' => 23, 'food_type_id' => 12],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 23, 'meal_time_id' => 1], ['recipe_id' => 23, 'meal_time_id' => 5],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 23, 'diet_id' => 2], ['recipe_id' => 23, 'diet_id' => 3],
            ['recipe_id' => 23, 'diet_id' => 4], ['recipe_id' => 23, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 23, 'cuisine_id' => 5]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 23, 'free_from_id' => 1], ['recipe_id' => 23, 'free_from_id' => 2],
            ['recipe_id' => 23, 'free_from_id' => 3],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 23, 'ingredient_id' => 31, 'quantity' => 3, 'unit' => 4],
            ['recipe_id' => 23, 'ingredient_id' => 30, 'quantity' => 1, 'unit' => 4],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 23, 'position' => 1, 'step_category_id' => 2,
                'description' => 'Kifacsarjuk a narancsokat, és a banánnal együtt simára turmixoljuk.'],
            ['recipe_id' => 23, 'position' => 2, 'step_category_id' => 5,
                'description' => 'Rögtön igyuk meg, mert állás közben szétválik.'],
        ]);

        // Banános turmix
        DB::table('recipe')->insert([
            'id' => 24,
            'title' => 'Banános turmix',
            'description' => 'Krémes, tejes banánturmix egy kis mézzel, gyors reggelire.',
            'prep_time' => 10, 'difficulty' => 0, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/drink_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-04-02', 'updated_at' => '2026-04-02',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 24, 'food_type_id' => 10]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 24, 'meal_time_id' => 1], ['recipe_id' => 24, 'meal_time_id' => 4],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 24, 'diet_id' => 2], ['recipe_id' => 24, 'diet_id' => 4],
            ['recipe_id' => 24, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 24, 'cuisine_id' => 5]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 24, 'free_from_id' => 1], ['recipe_id' => 24, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 24, 'ingredient_id' => 30, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 24, 'ingredient_id' => 4, 'quantity' => 400, 'unit' => 2],
            ['recipe_id' => 24, 'ingredient_id' => 50, 'quantity' => 1, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 24, 'position' => 1, 'step_category_id' => 2,
                'description' => 'A banánt feldaraboljuk, és a tejjel meg a mézzel habosra turmixoljuk.'],
            ['recipe_id' => 24, 'position' => 2, 'step_category_id' => 5,
                'description' => 'Hidegen a legfinomabb.'],
        ]);

        // Almabefőtt
        DB::table('recipe')->insert([
            'id' => 25,
            'title' => 'Almabefőtt',
            'description' => 'Fahéjas almabefőtt télire, sütemények töltelékének is jó.',
            'prep_time' => 60, 'difficulty' => 1, 'servings' => 6,
            'thumbnail' => 'images/recipes/default/preserve_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-09-13', 'updated_at' => '2026-09-13',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 25, 'food_type_id' => 11], ['recipe_id' => 25, 'food_type_id' => 12],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 25, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 25, 'diet_id' => 2], ['recipe_id' => 25, 'diet_id' => 3],
            ['recipe_id' => 25, 'diet_id' => 4], ['recipe_id' => 25, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 25, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 25, 'free_from_id' => 1], ['recipe_id' => 25, 'free_from_id' => 2],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 25, 'ingredient_id' => 29, 'quantity' => 2, 'unit' => 1],
            ['recipe_id' => 25, 'ingredient_id' => 8, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 25, 'ingredient_id' => 49, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 25, 'ingredient_id' => 51, 'quantity' => 1, 'unit' => 4],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 25, 'position' => 1, 'step_category_id' => 1,
                'description' => 'Az üvegeket és a tetejüket alaposan kimossuk, és forró vízzel kiöblítjük.'],
            ['recipe_id' => 25, 'position' => 2, 'step_category_id' => 1,
                'description' => 'Az almát meghámozzuk, kimagozzuk és cikkekre vágjuk.'],
            ['recipe_id' => 25, 'position' => 3, 'step_category_id' => 3,
                'description' => '1 liter vizet felforralunk a cukorral, a fahéjjal és a citrom levével.'],
            ['recipe_id' => 25, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Beletesszük az almát, és 5 percig főzzük.'],
            ['recipe_id' => 25, 'position' => 5, 'step_category_id' => 2,
                'description' => 'Az almát az üvegekbe szedjük, felöntjük a sziruppal, és szorosan lezárjuk.'],
            ['recipe_id' => 25, 'position' => 6, 'step_category_id' => 2,
                'description' => 'Az üvegeket fejjel lefelé fordítva, letakarva hagyjuk kihűlni.'],
            ['recipe_id' => 25, 'position' => 7, 'step_category_id' => 5,
                'description' => 'Hűvös helyen tároljuk, és desszertként vagy töltelékként tálaljuk.'],
        ]);

        // Eperbefőtt
        DB::table('recipe')->insert([
            'id' => 26,
            'title' => 'Eperbefőtt',
            'description' => 'Egész szem eperből készült befőtt, ahogy a nagymama csinálta.',
            'prep_time' => 45, 'difficulty' => 1, 'servings' => 6,
            'thumbnail' => 'images/recipes/default/preserve_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-06-17', 'updated_at' => '2026-06-17',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 26, 'food_type_id' => 11], ['recipe_id' => 26, 'food_type_id' => 12],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 26, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 26, 'diet_id' => 2], ['recipe_id' => 26, 'diet_id' => 3],
            ['recipe_id' => 26, 'diet_id' => 4], ['recipe_id' => 26, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 26, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 26, 'free_from_id' => 1], ['recipe_id' => 26, 'free_from_id' => 2],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 26, 'ingredient_id' => 48, 'quantity' => 1, 'unit' => 1],
            ['recipe_id' => 26, 'ingredient_id' => 8, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 26, 'ingredient_id' => 51, 'quantity' => 1, 'unit' => 4],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 26, 'position' => 1, 'step_category_id' => 1,
                'description' => 'Az epret megmossuk, és lecsípjük a zöld szárát.'],
            ['recipe_id' => 26, 'position' => 2, 'step_category_id' => 1,
                'description' => 'Az üvegeket alaposan kimossuk, és forró vízzel kiöblítjük.'],
            ['recipe_id' => 26, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Az epret az üvegekbe rakjuk.'],
            ['recipe_id' => 26, 'position' => 4, 'step_category_id' => 3,
                'description' => '7 dl vizet felforralunk a cukorral és a citrom levével.'],
            ['recipe_id' => 26, 'position' => 5, 'step_category_id' => 2,
                'description' => 'A forró sziruppal felöntjük az epret, és az üvegeket szorosan lezárjuk.'],
            ['recipe_id' => 26, 'position' => 6, 'step_category_id' => 3,
                'description' => 'Az üvegeket egy fazék vízben 10 percig forraljuk, és a vízben hagyjuk kihűlni.'],
            ['recipe_id' => 26, 'position' => 7, 'step_category_id' => 5,
                'description' => 'Hűvös helyen tároljuk, palacsintához vagy desszertekhez tálaljuk.'],
        ]);

        // Gyümölcssaláta
        DB::table('recipe')->insert([
            'id' => 27,
            'title' => 'Gyümölcssaláta',
            'description' => 'Színes, friss gyümölcssaláta mézes-citromos öntettel.',
            'prep_time' => 15, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/fruit_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-08-25', 'updated_at' => '2026-08-25',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 27, 'food_type_id' => 12], ['recipe_id' => 27, 'food_type_id' => 3],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 27, 'meal_time_id' => 4], ['recipe_id' => 27, 'meal_time_id' => 5],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 27, 'diet_id' => 2], ['recipe_id' => 27, 'diet_id' => 4],
            ['recipe_id' => 27, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 27, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 27, 'free_from_id' => 1], ['recipe_id' => 27, 'free_from_id' => 2],
            ['recipe_id' => 27, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 27, 'ingredient_id' => 29, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 27, 'ingredient_id' => 30, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 27, 'ingredient_id' => 31, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 27, 'ingredient_id' => 48, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 27, 'ingredient_id' => 50, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 27, 'ingredient_id' => 51, 'quantity' => 0.5, 'unit' => 4],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 27, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A gyümölcsöket megpucoljuk, és falatnyi darabokra vágjuk.'],
            ['recipe_id' => 27, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A mézet elkeverjük a citrom levével, és a gyümölcsökre öntjük.'],
            ['recipe_id' => 27, 'position' => 3, 'step_category_id' => 5,
                'description' => 'Átforgatjuk, és hűtőben pihentetjük egy kicsit.'],
        ]);

        // Mézes-diós sült alma
        DB::table('recipe')->insert([
            'id' => 28,
            'title' => 'Mézes-diós sült alma',
            'description' => 'Sütőben sült alma mézes-diós töltelékkel és fahéjjal.',
            'prep_time' => 40, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/fruit_thumbnail.svg',
            'user_id' => 3,
            'created_at' => '2026-11-02', 'updated_at' => '2026-11-02',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 28, 'food_type_id' => 3], ['recipe_id' => 28, 'food_type_id' => 12],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 28, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 28, 'diet_id' => 2], ['recipe_id' => 28, 'diet_id' => 4],
            ['recipe_id' => 28, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 28, 'cuisine_id' => 1]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 28, 'free_from_id' => 1], ['recipe_id' => 28, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 28, 'ingredient_id' => 29, 'quantity' => 4, 'unit' => 4],
            ['recipe_id' => 28, 'ingredient_id' => 11, 'quantity' => 60, 'unit' => 0],
            ['recipe_id' => 28, 'ingredient_id' => 50, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 28, 'ingredient_id' => 49, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 28, 'ingredient_id' => 5, 'quantity' => 20, 'unit' => 0],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 28, 'position' => 1, 'step_category_id' => 1,
                'description' => 'Az almákat megmossuk, és almavájóval kivájjuk a magházukat.'],
            ['recipe_id' => 28, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A diót apróra vágjuk, és összekeverjük a mézzel és a fahéjjal.'],
            ['recipe_id' => 28, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Az almákat megtöltjük a diós keverékkel, és mindegyik tetejére kis vajat teszünk.'],
            ['recipe_id' => 28, 'position' => 4, 'step_category_id' => 4,
                'description' => '180 fokon kb. 25 percig sütjük, amíg az alma megpuhul.'],
            ['recipe_id' => 28, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Melegen, a kisült levével meglocsolva tálaljuk.'],
        ]);

        // Sült hal
        DB::table('recipe')->insert([
            'id' => 29,
            'title' => 'Sült hal',
            'description' => 'Serpenyőben sült fehér halfilé citrommal és párolt rizzsel.',
            'prep_time' => 35, 'difficulty' => 1, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-10-05', 'updated_at' => '2026-10-05',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 29, 'food_type_id' => 2]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 29, 'meal_time_id' => 2], ['recipe_id' => 29, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 29, 'diet_id' => 4], ['recipe_id' => 29, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 29, 'cuisine_id' => 7]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 29, 'free_from_id' => 2], ['recipe_id' => 29, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 29, 'ingredient_id' => 13, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 29, 'ingredient_id' => 1, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 29, 'ingredient_id' => 51, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 29, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 29, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 29, 'ingredient_id' => 25, 'quantity' => 150, 'unit' => 0],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 29, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A rizst kétszeres mennyiségű sós vízben lefedve puhára pároljuk.'],
            ['recipe_id' => 29, 'position' => 2, 'step_category_id' => 1,
                'description' => 'A halfilét leöblítjük, papírtörlővel szárazra itatjuk, és megsózzuk.'],
            ['recipe_id' => 29, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Vékonyan megforgatjuk a lisztben.'],
            ['recipe_id' => 29, 'position' => 4, 'step_category_id' => 4,
                'description' => 'Forró olajon oldalanként 3-4 percig sütjük.'],
            ['recipe_id' => 29, 'position' => 5, 'step_category_id' => 5,
                'description' => 'A rizzsel és citromkarikákkal tálaljuk, a halat meglocsoljuk citromlével.'],
        ]);

        // Rák saláta
        DB::table('recipe')->insert([
            'id' => 30,
            'title' => 'Rák saláta',
            'description' => 'Ázsiai garnélarák saláta uborkával, szójás-lime-os öntettel.',
            'prep_time' => 25, 'difficulty' => 1, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/salad_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-06-23', 'updated_at' => '2026-07-01',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 30, 'food_type_id' => 6], ['recipe_id' => 30, 'food_type_id' => 4],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 30, 'meal_time_id' => 2]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 30, 'diet_id' => 4], ['recipe_id' => 30, 'diet_id' => 5],
            ['recipe_id' => 30, 'diet_id' => 6], ['recipe_id' => 30, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 30, 'cuisine_id' => 4]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 30, 'free_from_id' => 2], ['recipe_id' => 30, 'free_from_id' => 3],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 30, 'ingredient_id' => 14, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 30, 'ingredient_id' => 43, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 30, 'ingredient_id' => 41, 'quantity' => 0.5, 'unit' => 6],
            ['recipe_id' => 30, 'ingredient_id' => 10, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 30, 'ingredient_id' => 46, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 30, 'ingredient_id' => 18, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 30, 'ingredient_id' => 17, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 30, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A rákot sós vízben 2-3 percig főzzük, majd hideg vízben lehűtjük és megpucoljuk.'],
            ['recipe_id' => 30, 'position' => 2, 'step_category_id' => 1,
                'description' => 'Az uborkát vékonyan felszeleteljük, a salátát falatnyira tépjük.'],
            ['recipe_id' => 30, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Az öntethez a szójaszószt, a lime levét és az olajat összekeverjük.'],
            ['recipe_id' => 30, 'position' => 4, 'step_category_id' => 5,
                'description' => 'A rákot a zöldségekkel összeforgatjuk, meglocsoljuk, és szezámmaggal megszórjuk.'],
        ]);

        // Zellerkrémleves
        DB::table('recipe')->insert([
            'id' => 31,
            'title' => 'Zellerkrémleves',
            'description' => 'Selymes zellerkrémleves vajjal és egy kevés tejjel.',
            'prep_time' => 35, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-01-31', 'updated_at' => '2026-01-31',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 31, 'food_type_id' => 1], ['recipe_id' => 31, 'food_type_id' => 4],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 31, 'meal_time_id' => 2], ['recipe_id' => 31, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 31, 'diet_id' => 2], ['recipe_id' => 31, 'diet_id' => 4],
            ['recipe_id' => 31, 'diet_id' => 5], ['recipe_id' => 31, 'diet_id' => 6],
            ['recipe_id' => 31, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 31, 'cuisine_id' => 3]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 31, 'free_from_id' => 1], ['recipe_id' => 31, 'free_from_id' => 3],
            ['recipe_id' => 31, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 31, 'ingredient_id' => 15, 'quantity' => 600, 'unit' => 0],
            ['recipe_id' => 31, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 31, 'ingredient_id' => 5, 'quantity' => 40, 'unit' => 0],
            ['recipe_id' => 31, 'ingredient_id' => 4, 'quantity' => 200, 'unit' => 2],
            ['recipe_id' => 31, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 31, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 31, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A zellert meghámozzuk és felkockázzuk, a hagymát apróra vágjuk.'],
            ['recipe_id' => 31, 'position' => 2, 'step_category_id' => 3,
                'description' => 'A vajon megdinszteljük a hagymát, majd hozzáadjuk a zellert.'],
            ['recipe_id' => 31, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Felöntjük 8 dl vízzel, sózzuk, és kb. 25 percig főzzük, amíg a zeller megpuhul.'],
            ['recipe_id' => 31, 'position' => 4, 'step_category_id' => 2,
                'description' => 'Hozzáöntjük a tejet, és botmixerrel krémesre turmixoljuk.'],
            ['recipe_id' => 31, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Frissen őrölt borssal megszórva, melegen tálaljuk.'],
        ]);

        // Mustáros csirke
        DB::table('recipe')->insert([
            'id' => 32,
            'title' => 'Mustáros csirke',
            'description' => 'Szaftos csirkemell mustáros-tejfölös mártásban.',
            'prep_time' => 40, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-05-12', 'updated_at' => '2026-05-12',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 32, 'food_type_id' => 2]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 32, 'meal_time_id' => 2], ['recipe_id' => 32, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 32, 'diet_id' => 1], ['recipe_id' => 32, 'diet_id' => 5],
            ['recipe_id' => 32, 'diet_id' => 6], ['recipe_id' => 32, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 32, 'cuisine_id' => 3]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 32, 'free_from_id' => 1], ['recipe_id' => 32, 'free_from_id' => 3],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 32, 'ingredient_id' => 26, 'quantity' => 600, 'unit' => 0],
            ['recipe_id' => 32, 'ingredient_id' => 16, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 32, 'ingredient_id' => 7, 'quantity' => 200, 'unit' => 0],
            ['recipe_id' => 32, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 32, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 32, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 32, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 32, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A csirkemellet csíkokra vágjuk, sózzuk, borsozzuk, a hagymát apróra vágjuk.'],
            ['recipe_id' => 32, 'position' => 2, 'step_category_id' => 4,
                'description' => 'Az olajon fehéredésig sütjük a húst, majd kivesszük a serpenyőből.'],
            ['recipe_id' => 32, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Ugyanott megdinszteljük a hagymát, és felöntjük 1 dl vízzel.'],
            ['recipe_id' => 32, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Belekeverjük a mustárt és a tejfölt, visszatesszük a húst, és 10 percig főzzük.'],
            ['recipe_id' => 32, 'position' => 5, 'step_category_id' => 5,
                'description' => 'A szafttal együtt, rizzsel vagy burgonyával tálaljuk.'],
        ]);

        // Szezámmagos csirke
        DB::table('recipe')->insert([
            'id' => 33,
            'title' => 'Szezámmagos csirke',
            'description' => 'Ázsiai stílusú mézes-szójás csirke pirított szezámmaggal.',
            'prep_time' => 35, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-03-29', 'updated_at' => '2026-03-29',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 33, 'food_type_id' => 2]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 33, 'meal_time_id' => 2], ['recipe_id' => 33, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 33, 'diet_id' => 1], ['recipe_id' => 33, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 33, 'cuisine_id' => 4]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 33, 'free_from_id' => 2], ['recipe_id' => 33, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 33, 'ingredient_id' => 26, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 33, 'ingredient_id' => 10, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 33, 'ingredient_id' => 50, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 33, 'ingredient_id' => 22, 'quantity' => 2, 'unit' => 5],
            ['recipe_id' => 33, 'ingredient_id' => 17, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 33, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 33, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A csirkemellet falatnyi kockákra vágjuk, a fokhagymát összezúzzuk.'],
            ['recipe_id' => 33, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A szójaszószt, a mézet és a fokhagymát összekeverjük.'],
            ['recipe_id' => 33, 'position' => 3, 'step_category_id' => 4,
                'description' => 'Az olajon a húst minden oldalán aranybarnára sütjük.'],
            ['recipe_id' => 33, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Ráöntjük a szószt, és addig forgatjuk, amíg besűrűsödik és bevonja a húst.'],
            ['recipe_id' => 33, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Szezámmagot szórunk rá, rizzsel az igazi.'],
        ]);

        // Földimogyorós tészta
        DB::table('recipe')->insert([
            'id' => 34,
            'title' => 'Földimogyorós tészta',
            'description' => 'Gyors ázsiai tészta földimogyorós-szójás szósszal és egy kis chilivel.',
            'prep_time' => 25, 'difficulty' => 0, 'servings' => 3,
            'thumbnail' => 'images/recipes/default/pasta_thumbnail.svg',
            'user_id' => 4,
            'created_at' => '2026-10-20', 'updated_at' => '2026-10-20',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 34, 'food_type_id' => 8], ['recipe_id' => 34, 'food_type_id' => 2],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 34, 'meal_time_id' => 3]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 34, 'diet_id' => 2], ['recipe_id' => 34, 'diet_id' => 3],
            ['recipe_id' => 34, 'diet_id' => 4], ['recipe_id' => 34, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 34, 'cuisine_id' => 4]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 34, 'free_from_id' => 2], ['recipe_id' => 34, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 34, 'ingredient_id' => 2, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 34, 'ingredient_id' => 12, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 34, 'ingredient_id' => 10, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 34, 'ingredient_id' => 46, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 34, 'ingredient_id' => 22, 'quantity' => 1, 'unit' => 5],
            ['recipe_id' => 34, 'ingredient_id' => 52, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 34, 'ingredient_id' => 18, 'quantity' => 1, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 34, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A tésztát sós vízben kifőzzük, és leszűrjük.'],
            ['recipe_id' => 34, 'position' => 2, 'step_category_id' => 1,
                'description' => 'A földimogyorót szárazon megpirítjuk, és durvára vágjuk.'],
            ['recipe_id' => 34, 'position' => 3, 'step_category_id' => 2,
                'description' => 'A szójaszószt, a lime levét, a zúzott fokhagymát és az olajat összekeverjük.'],
            ['recipe_id' => 34, 'position' => 4, 'step_category_id' => 2,
                'description' => 'A meleg tésztát összeforgatjuk a szósszal és a felkarikázott chilivel.'],
            ['recipe_id' => 34, 'position' => 5, 'step_category_id' => 5,
                'description' => 'A tetejére szórjuk a földimogyorót, és melegen tálaljuk.'],
        ]);

        // Diós süti
        DB::table('recipe')->insert([
            'id' => 35,
            'title' => 'Diós süti',
            'description' => 'Puha, diós kevert sütemény, kávé mellé tökéletes.',
            'prep_time' => 50, 'difficulty' => 1, 'servings' => 12,
            'thumbnail' => 'images/recipes/default/dessert_thumbnail.svg',
            'user_id' => 2,
            'created_at' => '2026-04-18', 'updated_at' => '2026-04-18',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 35, 'food_type_id' => 3], ['recipe_id' => 35, 'food_type_id' => 7],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 35, 'meal_time_id' => 4]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 35, 'diet_id' => 2], ['recipe_id' => 35, 'diet_id' => 4],
            ['recipe_id' => 35, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 35, 'cuisine_id' => 1]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 35, 'ingredient_id' => 1, 'quantity' => 250, 'unit' => 0],
            ['recipe_id' => 35, 'ingredient_id' => 11, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 35, 'ingredient_id' => 5, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 35, 'ingredient_id' => 8, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 35, 'ingredient_id' => 9, 'quantity' => 3, 'unit' => 4],
            ['recipe_id' => 35, 'ingredient_id' => 4, 'quantity' => 100, 'unit' => 2],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 35, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A diót durvára daráljuk, a vajat szobahőmérsékletűre hagyjuk.'],
            ['recipe_id' => 35, 'position' => 2, 'step_category_id' => 2,
                'description' => 'A vajat a cukorral habosra keverjük, majd egyenként hozzáadjuk a tojásokat.'],
            ['recipe_id' => 35, 'position' => 3, 'step_category_id' => 2,
                'description' => 'Hozzákeverjük a lisztet, a tejet és a diót.'],
            ['recipe_id' => 35, 'position' => 4, 'step_category_id' => 4,
                'description' => 'Kivajazott tepsibe simítjuk, és 180 fokon kb. 30 percig sütjük.'],
            ['recipe_id' => 35, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Kihűlés után szeletekre vágva tálaljuk.'],
        ]);

        // Keto saláta
        DB::table('recipe')->insert([
            'id' => 36,
            'title' => 'Keto saláta',
            'description' => 'Laktató, alacsony szénhidráttartalmú saláta sajttal, tojással és avokádóval.',
            'prep_time' => 20, 'difficulty' => 0, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/salad_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-09-30', 'updated_at' => '2026-09-30',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 36, 'food_type_id' => 6]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 36, 'meal_time_id' => 2]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 36, 'diet_id' => 2], ['recipe_id' => 36, 'diet_id' => 4],
            ['recipe_id' => 36, 'diet_id' => 5], ['recipe_id' => 36, 'diet_id' => 6],
            ['recipe_id' => 36, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 36, 'cuisine_id' => 5]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 36, 'free_from_id' => 1], ['recipe_id' => 36, 'free_from_id' => 3],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 36, 'ingredient_id' => 41, 'quantity' => 1, 'unit' => 6],
            ['recipe_id' => 36, 'ingredient_id' => 43, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 36, 'ingredient_id' => 45, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 36, 'ingredient_id' => 9, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 36, 'ingredient_id' => 6, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 36, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 36, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 36, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A tojásokat 10 percig keményre főzzük, majd lehűtjük és meghámozzuk.'],
            ['recipe_id' => 36, 'position' => 2, 'step_category_id' => 1,
                'description' => 'A salátát feltépjük, az uborkát, az avokádót, a sajtot és a tojást felvágjuk.'],
            ['recipe_id' => 36, 'position' => 3, 'step_category_id' => 5,
                'description' => 'Mindent tálra rendezünk, sózzuk, meglocsoljuk olajjal, és azonnal tálaljuk.'],
        ]);

        // Low-carb csirke
        DB::table('recipe')->insert([
            'id' => 37,
            'title' => 'Low-carb csirke',
            'description' => 'Grillezett csirkemell friss zöldségekkel, köret nélkül.',
            'prep_time' => 25, 'difficulty' => 0, 'servings' => 2,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-07-22', 'updated_at' => '2026-07-22',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 37, 'food_type_id' => 2], ['recipe_id' => 37, 'food_type_id' => 6],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 37, 'meal_time_id' => 2], ['recipe_id' => 37, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 37, 'diet_id' => 1], ['recipe_id' => 37, 'diet_id' => 5],
            ['recipe_id' => 37, 'diet_id' => 6], ['recipe_id' => 37, 'diet_id' => 7],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 37, 'cuisine_id' => 5]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 37, 'free_from_id' => 1], ['recipe_id' => 37, 'free_from_id' => 2],
            ['recipe_id' => 37, 'free_from_id' => 3], ['recipe_id' => 37, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 37, 'ingredient_id' => 26, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 37, 'ingredient_id' => 23, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 37, 'ingredient_id' => 43, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 37, 'ingredient_id' => 41, 'quantity' => 0.5, 'unit' => 6],
            ['recipe_id' => 37, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 37, 'ingredient_id' => 51, 'quantity' => 0.5, 'unit' => 4],
            ['recipe_id' => 37, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 37, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 37, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A csirkemellet sózzuk, borsozzuk, és meglocsoljuk a citrom levével.'],
            ['recipe_id' => 37, 'position' => 2, 'step_category_id' => 4,
                'description' => 'Grillserpenyőben, kevés olajon oldalanként 5-6 percig sütjük, majd felszeleteljük.'],
            ['recipe_id' => 37, 'position' => 3, 'step_category_id' => 1,
                'description' => 'A paradicsomot és az uborkát felkockázzuk, a salátát falatnyira tépjük.'],
            ['recipe_id' => 37, 'position' => 4, 'step_category_id' => 5,
                'description' => 'A zöldségeket meglocsoljuk a maradék olajjal, és a csirkével együtt tálaljuk.'],
        ]);

        // Chilis bab
        DB::table('recipe')->insert([
            'id' => 38,
            'title' => 'Chilis bab',
            'description' => 'Csípős, mexikói ihletésű chilis bab darált marhahússal.',
            'prep_time' => 60, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/main_course_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-02-20', 'updated_at' => '2026-03-11',
        ]);
        DB::table('food_type_recipe')->insert(['recipe_id' => 38, 'food_type_id' => 2]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 38, 'meal_time_id' => 2], ['recipe_id' => 38, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 38, 'diet_id' => 1], ['recipe_id' => 38, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 38, 'cuisine_id' => 6]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 38, 'free_from_id' => 1], ['recipe_id' => 38, 'free_from_id' => 2],
            ['recipe_id' => 38, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 38, 'ingredient_id' => 28, 'quantity' => 500, 'unit' => 0],
            ['recipe_id' => 38, 'ingredient_id' => 34, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 38, 'ingredient_id' => 23, 'quantity' => 400, 'unit' => 0],
            ['recipe_id' => 38, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 38, 'ingredient_id' => 22, 'quantity' => 2, 'unit' => 5],
            ['recipe_id' => 38, 'ingredient_id' => 52, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 38, 'ingredient_id' => 35, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 38, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
            ['recipe_id' => 38, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 38, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A hagymát, a fokhagymát és a chilit apróra vágjuk.'],
            ['recipe_id' => 38, 'position' => 2, 'step_category_id' => 3,
                'description' => 'Az olajon megdinszteljük, majd hozzáadjuk a darált húst, és morzsásra pirítjuk.'],
            ['recipe_id' => 38, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Megszórjuk a pirospaprikával, hozzáadjuk a paradicsomot és a sót.'],
            ['recipe_id' => 38, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Fél órát főzzük, aztán mehet bele a leszűrt bab még 10 percre.'],
            ['recipe_id' => 38, 'position' => 5, 'step_category_id' => 5,
                'description' => 'Tejföllel vagy reszelt sajttal is nagyon jó.'],
        ]);

        // Francia hagymaleves
        DB::table('recipe')->insert([
            'id' => 39,
            'title' => 'Francia hagymaleves',
            'description' => 'Klasszikus francia hagymaleves sajtos pirítóssal.',
            'prep_time' => 60, 'difficulty' => 1, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/soup_thumbnail.svg',
            'user_id' => 1,
            'created_at' => '2026-10-27', 'updated_at' => '2026-10-27',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 39, 'food_type_id' => 1], ['recipe_id' => 39, 'food_type_id' => 4],
        ]);
        DB::table('meal_time_recipe')->insert(['recipe_id' => 39, 'meal_time_id' => 3]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 39, 'diet_id' => 2], ['recipe_id' => 39, 'diet_id' => 4],
            ['recipe_id' => 39, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 39, 'cuisine_id' => 3]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 39, 'free_from_id' => 3], ['recipe_id' => 39, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 39, 'ingredient_id' => 21, 'quantity' => 6, 'unit' => 4],
            ['recipe_id' => 39, 'ingredient_id' => 5, 'quantity' => 50, 'unit' => 0],
            ['recipe_id' => 39, 'ingredient_id' => 1, 'quantity' => 1, 'unit' => 11],
            ['recipe_id' => 39, 'ingredient_id' => 3, 'quantity' => 4, 'unit' => 7],
            ['recipe_id' => 39, 'ingredient_id' => 6, 'quantity' => 100, 'unit' => 0],
            ['recipe_id' => 39, 'ingredient_id' => 19, 'quantity' => 1, 'unit' => 12],
            ['recipe_id' => 39, 'ingredient_id' => 20, 'quantity' => 1, 'unit' => 13],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 39, 'position' => 1, 'step_category_id' => 1,
                'description' => 'A hagymát meghámozzuk, és vékony félkarikákra szeleteljük.'],
            ['recipe_id' => 39, 'position' => 2, 'step_category_id' => 3,
                'description' => 'A vajon lassú tűzön, gyakran kevergetve kb. 30 percig karamellizáljuk.'],
            ['recipe_id' => 39, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Megszórjuk a liszttel, felöntjük 1 liter vízzel, fűszerezzük, és 15 percig főzzük.'],
            ['recipe_id' => 39, 'position' => 4, 'step_category_id' => 4,
                'description' => 'A kenyérszeletekre reszelt sajtot szórunk, és sütőben ráolvasztjuk.'],
            ['recipe_id' => 39, 'position' => 5, 'step_category_id' => 5,
                'description' => 'A levest tányérba merjük, és a sajtos pirítóst a tetejére tesszük.'],
        ]);

        // Zöldséges rizs
        DB::table('recipe')->insert([
            'id' => 40,
            'title' => 'Zöldséges rizs',
            'description' => 'Ázsiai pirított rizs sárgarépával, zöldborsóval és szójaszósszal.',
            'prep_time' => 25, 'difficulty' => 0, 'servings' => 4,
            'thumbnail' => 'images/recipes/default/side_dish_thumbnail.svg',
            'user_id' => 5,
            'created_at' => '2026-08-11', 'updated_at' => '2026-08-11',
        ]);
        DB::table('food_type_recipe')->insert([
            ['recipe_id' => 40, 'food_type_id' => 5], ['recipe_id' => 40, 'food_type_id' => 2],
        ]);
        DB::table('meal_time_recipe')->insert([
            ['recipe_id' => 40, 'meal_time_id' => 2], ['recipe_id' => 40, 'meal_time_id' => 3],
        ]);
        DB::table('diet_recipe')->insert([
            ['recipe_id' => 40, 'diet_id' => 2], ['recipe_id' => 40, 'diet_id' => 3],
            ['recipe_id' => 40, 'diet_id' => 4], ['recipe_id' => 40, 'diet_id' => 5],
        ]);
        DB::table('cuisine_recipe')->insert(['recipe_id' => 40, 'cuisine_id' => 4]);
        DB::table('free_from_recipe')->insert([
            ['recipe_id' => 40, 'free_from_id' => 2], ['recipe_id' => 40, 'free_from_id' => 4],
        ]);
        DB::table('ingredient_recipe')->insert([
            ['recipe_id' => 40, 'ingredient_id' => 25, 'quantity' => 300, 'unit' => 0],
            ['recipe_id' => 40, 'ingredient_id' => 36, 'quantity' => 2, 'unit' => 4],
            ['recipe_id' => 40, 'ingredient_id' => 53, 'quantity' => 150, 'unit' => 0],
            ['recipe_id' => 40, 'ingredient_id' => 21, 'quantity' => 1, 'unit' => 4],
            ['recipe_id' => 40, 'ingredient_id' => 10, 'quantity' => 3, 'unit' => 11],
            ['recipe_id' => 40, 'ingredient_id' => 18, 'quantity' => 2, 'unit' => 11],
        ]);
        DB::table('step')->insert([
            ['recipe_id' => 40, 'position' => 1, 'step_category_id' => 3,
                'description' => 'A rizst előre megfőzzük, és hagyjuk teljesen kihűlni (a tegnapi rizs a legjobb).'],
            ['recipe_id' => 40, 'position' => 2, 'step_category_id' => 1,
                'description' => 'A sárgarépát apró kockákra, a hagymát vékony csíkokra vágjuk.'],
            ['recipe_id' => 40, 'position' => 3, 'step_category_id' => 3,
                'description' => 'Wokban, forró olajon 3-4 percig pirítjuk a répát, a hagymát és a borsót.'],
            ['recipe_id' => 40, 'position' => 4, 'step_category_id' => 3,
                'description' => 'Hozzáadjuk a rizst, és erős lángon, folyamatos kevergetéssel átpirítjuk.'],
            ['recipe_id' => 40, 'position' => 5, 'step_category_id' => 2,
                'description' => 'Meglocsoljuk a szójaszósszal, és jól összeforgatjuk.'],
            ['recipe_id' => 40, 'position' => 6, 'step_category_id' => 5,
                'description' => 'Melegen, köretként vagy önálló ételként tálaljuk.'],
        ]);
    }
}
