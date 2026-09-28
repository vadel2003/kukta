<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientRecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Recept ID => [hozzávaló neve, mennyiség, mértékegység]
        // A mennyiségek pontosan egyeznek a StepSeeder lépéseiben leírtakkal.
        $recipeIngredients = [
            1 => [ // Gulyásleves (6 adag)
                ['Marhahús', 800, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Víz', 2000, 'ml'], ['Só', 2, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Babérlevél', 2, 'db'],
                ['Burgonya', 600, 'g'], ['Sárgarépa', 2, 'db'], ['Paprika', 2, 'db'], ['Paradicsom', 1, 'db'],
            ],
            2 => [ // Csirkepörkölt (4 adag)
                ['Csirkecomb', 800, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Víz', 300, 'ml'], ['Paprika', 2, 'db'], ['Paradicsom', 1, 'db'], ['Só', 1.5, 'teáskanál'],
                ['Bors', 0.5, 'teáskanál'], ['Tejföl', 200, 'g'], ['Nokedli', 500, 'g'],
            ],
            3 => [ // Túrós csusza (4 adag)
                ['Tészta', 400, 'g'], ['Só', 2, 'teáskanál'], ['Szalonna', 150, 'g'], ['Túró', 400, 'g'], ['Tejföl', 300, 'g'],
            ],
            4 => [ // Rakott krumpli (6 adag)
                ['Burgonya', 1000, 'g'], ['Tojás', 6, 'db'], ['Kolbász', 200, 'g'], ['Vaj', 30, 'g'],
                ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Tejföl', 400, 'g'],
            ],
            5 => [ // Halászlé (6 adag)
                ['Ponty', 1000, 'g'], ['Harcsa', 500, 'g'], ['Keszeg', 300, 'g'], ['Hagyma', 3, 'db'], ['Víz', 2500, 'ml'],
                ['Pirospaprika őrlemény', 3, 'evőkanál'], ['Só', 2, 'teáskanál'], ['Paprika', 1, 'db'], ['Paradicsom', 1, 'db'],
                ['Tészta', 300, 'g'],
            ],
            6 => [ // Lángos (4 adag)
                ['Élesztő', 25, 'g'], ['Tej', 300, 'ml'], ['Cukor', 5, 'g'], ['Liszt', 500, 'g'], ['Só', 1, 'teáskanál'],
                ['Olaj', 500, 'ml'], ['Tejföl', 200, 'g'], ['Sajt', 150, 'g'],
            ],
            7 => [ // Palacsinta (4 adag)
                ['Liszt', 200, 'g'], ['Tojás', 2, 'db'], ['Tej', 400, 'ml'], ['Cukor', 20, 'g'], ['Só', 0.25, 'teáskanál'],
                ['Olaj', 2, 'evőkanál'], ['Baracklekvár', 150, 'g'], ['Kakaópor', 30, 'g'], ['Porcukor', 40, 'g'],
            ],
            8 => [ // Székelykáposzta (6 adag)
                ['Sertéshús', 800, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Fokhagyma', 2, 'gerezd'],
                ['Pirospaprika őrlemény', 2, 'evőkanál'], ['Víz', 700, 'ml'], ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'],
                ['Babérlevél', 2, 'db'], ['Savanyú káposzta', 1000, 'g'], ['Tejföl', 300, 'g'], ['Liszt', 20, 'g'],
            ],
            9 => [ // Paprikás csirke (4 adag)
                ['Csirkecomb', 1000, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Paprika', 1, 'db'], ['Paradicsom', 1, 'db'], ['Víz', 300, 'ml'], ['Só', 1.5, 'teáskanál'],
                ['Tejföl', 300, 'g'], ['Liszt', 20, 'g'], ['Nokedli', 500, 'g'],
            ],
            10 => [ // Meggyes pite (8 adag)
                ['Liszt', 400, 'g'], ['Vaj', 200, 'g'], ['Cukor', 180, 'g'], ['Sütőpor', 1, 'teáskanál'], ['Tojás', 2, 'db'],
                ['Meggy', 800, 'g'], ['Fahéj', 1, 'teáskanál'], ['Keményítő', 2, 'evőkanál'], ['Porcukor', 30, 'g'],
            ],
            11 => [ // Bolognai spagetti (4 adag)
                ['Hagyma', 1, 'db'], ['Fokhagyma', 2, 'gerezd'], ['Olaj', 2, 'evőkanál'], ['Darált hús', 500, 'g'],
                ['Sárgarépa', 1, 'db'], ['Zeller', 1, 'db'], ['Paradicsom', 2, 'db'], ['Paradicsomszósz', 500, 'ml'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Bazsalikom', 1, 'teáskanál'], ['Spagetti', 400, 'g'],
                ['Parmezán', 40, 'g'],
            ],
            12 => [ // Csirkemell saláta (2 adag)
                ['Csirkemell', 300, 'g'], ['Só', 0.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Olaj', 2, 'evőkanál'],
                ['Saláta', 1, 'fej'], ['Paradicsom', 2, 'db'], ['Uborka', 1, 'db'], ['Citrom', 1, 'db'],
            ],
            13 => [ // Töltött paprika (6 adag)
                ['Paprika', 8, 'db'], ['Rizs', 100, 'g'], ['Hagyma', 1, 'db'], ['Darált hús', 500, 'g'], ['Tojás', 1, 'db'],
                ['Só', 2, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Paradicsomszósz', 1000, 'ml'], ['Cukor', 30, 'g'],
            ],
            14 => [ // Borsóleves (4 adag)
                ['Hagyma', 1, 'db'], ['Vaj', 30, 'g'], ['Zöldborsó', 500, 'g'], ['Víz', 700, 'ml'], ['Tej', 200, 'ml'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tejszín', 100, 'ml'], ['Kenyér', 2, 'szelet'],
                ['Olaj', 1, 'evőkanál'],
            ],
            15 => [ // Rántott sajt (4 adag)
                ['Sajt', 600, 'g'], ['Tojás', 3, 'db'], ['Liszt', 100, 'g'], ['Zsemlemorzsa', 200, 'g'], ['Burgonya', 800, 'g'],
                ['Olaj', 500, 'ml'], ['Só', 1, 'teáskanál'],
            ],
            16 => [ // Zserbó (12 adag)
                ['Élesztő', 20, 'g'], ['Tej', 100, 'ml'], ['Liszt', 500, 'g'], ['Vaj', 280, 'g'], ['Cukor', 200, 'g'],
                ['Tojás', 1, 'db'], ['Dió', 300, 'g'], ['Baracklekvár', 400, 'g'], ['Csokoládé', 150, 'g'],
            ],
            17 => [ // Fokhagymakrémleves (4 adag)
                ['Fokhagyma', 10, 'gerezd'], ['Vaj', 40, 'g'], ['Liszt', 20, 'g'], ['Víz', 600, 'ml'], ['Tej', 300, 'ml'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tejszín', 200, 'ml'], ['Kenyér', 4, 'szelet'],
                ['Sajt', 80, 'g'],
            ],
            18 => [ // Marhapörkölt (6 adag)
                ['Marhahús', 1200, 'g'], ['Hagyma', 3, 'db'], ['Zsír', 50, 'g'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Fokhagyma', 2, 'gerezd'], ['Paprika', 1, 'db'], ['Paradicsom', 1, 'db'], ['Só', 2, 'teáskanál'],
                ['Bors', 0.5, 'teáskanál'], ['Víz', 500, 'ml'], ['Csipetke', 300, 'g'],
            ],
            19 => [ // Dobos torta (10 adag)
                ['Tojás', 10, 'db'], ['Cukor', 470, 'g'], ['Liszt', 120, 'g'], ['Csokoládé', 150, 'g'], ['Vaj', 250, 'g'],
            ],
            20 => [ // Káposztás tészta (4 adag)
                ['Káposzta', 800, 'g'], ['Só', 1.5, 'teáskanál'], ['Olaj', 4, 'evőkanál'], ['Cukor', 10, 'g'],
                ['Bors', 0.5, 'teáskanál'], ['Tészta', 400, 'g'],
            ],
            21 => [ // Sertésborda rántva (4 adag)
                ['Sertéshús', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tojás', 2, 'db'],
                ['Liszt', 80, 'g'], ['Zsemlemorzsa', 150, 'g'], ['Olaj', 400, 'ml'], ['Citrom', 1, 'db'],
            ],
            22 => [ // Paradicsomleves (4 adag)
                ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Paradicsom', 8, 'db'], ['Víz', 500, 'ml'], ['Só', 1, 'teáskanál'],
                ['Cukor', 20, 'g'], ['Bazsalikom', 1, 'teáskanál'], ['Tejföl', 100, 'g'], ['Kenyér', 2, 'szelet'],
            ],
            23 => [ // Töltött káposzta (6 adag)
                ['Savanyú káposzta', 1500, 'g'], ['Darált hús', 600, 'g'], ['Rizs', 100, 'g'], ['Hagyma', 1, 'db'],
                ['Tojás', 1, 'db'], ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'],
                ['Füstölt tarja', 300, 'g'], ['Kolbász', 200, 'g'], ['Víz', 1500, 'ml'], ['Tejföl', 300, 'g'],
            ],
            24 => [ // Mákos guba (4 adag)
                ['Kifli', 6, 'db'], ['Tej', 800, 'ml'], ['Cukor', 80, 'g'], ['Mák', 100, 'g'], ['Porcukor', 80, 'g'],
                ['Tojás', 3, 'db'], ['Vanília', 1, 'teáskanál'],
            ],
            25 => [ // Zöldborsófőzelék (4 adag)
                ['Hagyma', 1, 'db'], ['Olaj', 3, 'evőkanál'], ['Zöldborsó', 600, 'g'], ['Víz', 500, 'ml'], ['Só', 1, 'teáskanál'],
                ['Cukor', 10, 'g'], ['Liszt', 30, 'g'], ['Tej', 200, 'ml'], ['Petrezselyem', 1, 'csokor'], ['Virsli', 4, 'db'],
            ],
            26 => [ // Csirkepaprikás (4 adag)
                ['Csirkemell', 600, 'g'], ['Hagyma', 2, 'db'], ['Zsír', 40, 'g'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Paprika', 2, 'db'], ['Víz', 300, 'ml'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'],
                ['Tejföl', 250, 'g'], ['Liszt', 20, 'g'], ['Nokedli', 500, 'g'],
            ],
            27 => [ // Almás rétes (8 adag)
                ['Liszt', 250, 'g'], ['Víz', 150, 'ml'], ['Olaj', 2, 'evőkanál'], ['Só', 0.25, 'teáskanál'], ['Alma', 6, 'db'],
                ['Cukor', 100, 'g'], ['Fahéj', 1, 'teáskanál'], ['Dió', 80, 'g'], ['Vaj', 60, 'g'], ['Zsemlemorzsa', 40, 'g'],
                ['Porcukor', 20, 'g'],
            ],
            28 => [ // Spenótfőzelék (4 adag)
                ['Fokhagyma', 3, 'gerezd'], ['Olaj', 2, 'evőkanál'], ['Spenót', 600, 'g'], ['Só', 1, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Liszt', 30, 'g'], ['Tej', 300, 'ml'], ['Tejszín', 100, 'ml'], ['Tojás', 4, 'db'],
            ],
            29 => [ // Bakonyi sertésborda (4 adag)
                ['Sertéshús', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Olaj', 3, 'evőkanál'],
                ['Hagyma', 1, 'db'], ['Gomba', 300, 'g'], ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Tejföl', 200, 'g'],
                ['Tejszín', 100, 'ml'], ['Rizs', 300, 'g'], ['Víz', 600, 'ml'],
            ],
            30 => [ // Krumplifőzelék (4 adag)
                ['Burgonya', 800, 'g'], ['Víz', 800, 'ml'], ['Só', 1.5, 'teáskanál'], ['Babérlevél', 1, 'db'],
                ['Olaj', 2, 'evőkanál'], ['Liszt', 30, 'g'], ['Pirospaprika őrlemény', 1, 'teáskanál'], ['Ecet', 1, 'evőkanál'],
                ['Petrezselyem', 1, 'csokor'],
            ],
            31 => [ // Gombapörkölt (4 adag)
                ['Gomba', 800, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Paprika', 1, 'db'], ['Paradicsom', 1, 'db'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'],
                ['Víz', 100, 'ml'], ['Tejföl', 200, 'g'], ['Nokedli', 500, 'g'],
            ],
            32 => [ // Túrógombóc (4 adag)
                ['Túró', 500, 'g'], ['Tojás', 2, 'db'], ['Cukor', 30, 'g'], ['Liszt', 100, 'g'], ['Só', 0.25, 'teáskanál'],
                ['Vaj', 50, 'g'], ['Zsemlemorzsa', 100, 'g'], ['Tejföl', 200, 'g'], ['Porcukor', 40, 'g'],
            ],
            33 => [ // Húsleves (8 adag)
                ['Marhahús', 1000, 'g'], ['Víz', 3000, 'ml'], ['Sárgarépa', 3, 'db'], ['Zeller', 1, 'db'], ['Hagyma', 1, 'db'],
                ['Fokhagyma', 2, 'gerezd'], ['Só', 2, 'teáskanál'], ['Bors', 1, 'teáskanál'], ['Babérlevél', 2, 'db'],
                ['Csigatészta', 200, 'g'],
            ],
            34 => [ // Rakott palacsinta (6 adag)
                ['Liszt', 200, 'g'], ['Tojás', 2, 'db'], ['Tej', 400, 'ml'], ['Só', 1.25, 'teáskanál'], ['Olaj', 3, 'evőkanál'],
                ['Hagyma', 1, 'db'], ['Darált hús', 500, 'g'], ['Paradicsomszósz', 200, 'ml'], ['Bors', 0.5, 'teáskanál'],
                ['Vaj', 10, 'g'], ['Tejföl', 300, 'g'], ['Sajt', 150, 'g'],
            ],
            35 => [ // Fasírt (6 adag)
                ['Darált hús', 800, 'g'], ['Tojás', 2, 'db'], ['Hagyma', 1, 'db'], ['Fokhagyma', 2, 'gerezd'],
                ['Zsemlemorzsa', 60, 'g'], ['Só', 2.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Olaj', 2, 'evőkanál'],
                ['Burgonya', 1200, 'g'], ['Vaj', 50, 'g'], ['Tej', 200, 'ml'],
            ],
            36 => [ // Karfiolleves (4 adag)
                ['Karfiol', 600, 'g'], ['Víz', 800, 'ml'], ['Só', 1, 'teáskanál'], ['Tej', 200, 'ml'], ['Tejszín', 100, 'ml'],
                ['Sajt', 100, 'g'], ['Bors', 0.25, 'teáskanál'], ['Kenyér', 2, 'szelet'],
            ],
            37 => [ // Töltött tojás (4 adag)
                ['Tojás', 6, 'db'], ['Majonéz', 3, 'evőkanál'], ['Mustár', 1, 'teáskanál'], ['Só', 0.25, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Pirospaprika őrlemény', 0.5, 'teáskanál'], ['Petrezselyem', 0.5, 'csokor'],
            ],
            38 => [ // Sólet (6 adag)
                ['Szárazbab', 500, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Fokhagyma', 3, 'gerezd'],
                ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Liszt', 20, 'g'], ['Marhahús', 600, 'g'], ['Só', 2, 'teáskanál'],
                ['Bors', 0.5, 'teáskanál'], ['Víz', 2500, 'ml'], ['Tojás', 6, 'db'],
            ],
            39 => [ // Gyümölcsleves (4 adag)
                ['Alma', 2, 'db'], ['Eper', 200, 'g'], ['Meggy', 200, 'g'], ['Víz', 1000, 'ml'], ['Cukor', 100, 'g'],
                ['Fahéj', 0.5, 'teáskanál'], ['Keményítő', 2, 'evőkanál'], ['Tejszín', 200, 'ml'],
            ],
            40 => [ // Puliszka (4 adag)
                ['Víz', 1000, 'ml'], ['Só', 1, 'teáskanál'], ['Kukoricadara', 250, 'g'], ['Vaj', 30, 'g'], ['Tejföl', 200, 'g'],
                ['Sajt', 150, 'g'],
            ],
            41 => [ // Sertésszelet paradicsommal (4 adag)
                ['Sertéshús', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Olaj', 2, 'evőkanál'],
                ['Paradicsom', 3, 'db'], ['Bazsalikom', 1, 'teáskanál'], ['Sajt', 150, 'g'],
            ],
            42 => [ // Babgulyás (6 adag)
                ['Szárazbab', 400, 'g'], ['Füstölt csülök', 800, 'g'], ['Víz', 3000, 'ml'], ['Babérlevél', 2, 'db'],
                ['Hagyma', 2, 'db'], ['Olaj', 2, 'evőkanál'], ['Fokhagyma', 3, 'gerezd'], ['Pirospaprika őrlemény', 2, 'evőkanál'],
                ['Sárgarépa', 2, 'db'], ['Burgonya', 400, 'g'], ['Paprika', 1, 'db'], ['Paradicsom', 1, 'db'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'],
            ],
            43 => [ // Kakaós csiga (8 adag)
                ['Élesztő', 25, 'g'], ['Tej', 280, 'ml'], ['Cukor', 150, 'g'], ['Liszt', 500, 'g'], ['Só', 0.5, 'teáskanál'],
                ['Tojás', 2, 'db'], ['Vaj', 130, 'g'], ['Kakaópor', 40, 'g'], ['Porcukor', 100, 'g'],
            ],
            44 => [ // Savanyú krumplileves (4 adag)
                ['Burgonya', 600, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Liszt', 20, 'g'],
                ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Víz', 1500, 'ml'], ['Füstölt tarja', 200, 'g'], ['Babérlevél', 2, 'db'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Ecet', 2, 'evőkanál'], ['Kolbász', 150, 'g'],
                ['Tejföl', 150, 'g'],
            ],
            45 => [ // Rántott csirkemell (4 adag)
                ['Csirkemell', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tojás', 2, 'db'],
                ['Liszt', 80, 'g'], ['Zsemlemorzsa', 150, 'g'], ['Olaj', 400, 'ml'], ['Citrom', 1, 'db'], ['Saláta', 1, 'fej'],
            ],
            46 => [ // Brokkoli krémleves (4 adag)
                ['Brokkoli', 500, 'g'], ['Hagyma', 1, 'db'], ['Vaj', 20, 'g'], ['Víz', 700, 'ml'], ['Só', 1, 'teáskanál'],
                ['Tej', 200, 'ml'], ['Tejszín', 100, 'ml'], ['Sajt', 80, 'g'], ['Bors', 0.25, 'teáskanál'],
            ],
            47 => [ // Tarhonyás hús (4 adag)
                ['Tarhonya', 300, 'g'], ['Olaj', 3, 'evőkanál'], ['Hagyma', 1, 'db'], ['Sertéshús', 500, 'g'],
                ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Paprika', 1, 'db'], ['Paradicsom', 1, 'db'], ['Só', 1.5, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Víz', 800, 'ml'],
            ],
            48 => [ // Madártej (4 adag)
                ['Tej', 1000, 'ml'], ['Vanília', 1, 'teáskanál'], ['Tojás', 6, 'db'], ['Só', 0.25, 'teáskanál'], ['Cukor', 150, 'g'],
            ],
            49 => [ // Csülkös bableves (6 adag)
                ['Szárazbab', 400, 'g'], ['Füstölt csülök', 1000, 'g'], ['Víz', 3000, 'ml'], ['Babérlevél', 2, 'db'],
                ['Sárgarépa', 2, 'db'], ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Hagyma', 1, 'db'],
                ['Olaj', 2, 'evőkanál'], ['Fokhagyma', 2, 'gerezd'], ['Liszt', 20, 'g'], ['Pirospaprika őrlemény', 1, 'evőkanál'],
                ['Kolbász', 200, 'g'], ['Tejföl', 150, 'g'],
            ],
            50 => [ // Lecsó (4 adag)
                ['Hagyma', 2, 'db'], ['Olaj', 2, 'evőkanál'], ['Kolbász', 150, 'g'], ['Paprika', 6, 'db'], ['Paradicsom', 4, 'db'],
                ['Só', 1, 'teáskanál'], ['Pirospaprika őrlemény', 1, 'teáskanál'], ['Tojás', 4, 'db'],
            ],
            51 => [ // Burgonyafőzelék (4 adag)
                ['Burgonya', 800, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Víz', 700, 'ml'], ['Só', 1.5, 'teáskanál'],
                ['Tejföl', 150, 'g'], ['Liszt', 30, 'g'], ['Pirospaprika őrlemény', 1, 'teáskanál'], ['Petrezselyem', 1, 'csokor'],
            ],
            52 => [ // Csirkemell rolád (4 adag)
                ['Csirkemell', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Sonka', 120, 'g'],
                ['Sajt', 120, 'g'], ['Olaj', 2, 'evőkanál'], ['Rizs', 250, 'g'], ['Víz', 500, 'ml'],
            ],
            53 => [ // Paradicsomos csirkemell (4 adag)
                ['Csirkemell', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Olaj', 2, 'evőkanál'],
                ['Paradicsomszósz', 300, 'ml'], ['Bazsalikom', 1, 'teáskanál'], ['Paradicsom', 2, 'db'], ['Sajt', 150, 'g'],
            ],
            54 => [ // Sütőtök krémleves (4 adag)
                ['Sütőtök', 800, 'g'], ['Olaj', 2, 'evőkanál'], ['Hagyma', 1, 'db'], ['Víz', 500, 'ml'], ['Tej', 200, 'ml'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tejszín', 100, 'ml'], ['Tökmag', 40, 'g'],
            ],
            55 => [ // Rizses hús (4 adag)
                ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Sertéshús', 500, 'g'], ['Pirospaprika őrlemény', 1, 'evőkanál'],
                ['Paprika', 1, 'db'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Víz', 800, 'ml'],
                ['Rizs', 250, 'g'], ['Zöldborsó', 150, 'g'],
            ],
            56 => [ // Málnás muffin (12 adag)
                ['Liszt', 250, 'g'], ['Cukor', 150, 'g'], ['Sütőpor', 2, 'teáskanál'], ['Só', 0.25, 'teáskanál'],
                ['Tojás', 2, 'db'], ['Tej', 200, 'ml'], ['Vaj', 100, 'g'], ['Málna', 200, 'g'], ['Porcukor', 20, 'g'],
            ],
            57 => [ // Sárgaborsó főzelék (4 adag)
                ['Sárgaborsó', 400, 'g'], ['Víz', 1200, 'ml'], ['Babérlevél', 1, 'db'], ['Só', 1.5, 'teáskanál'],
                ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Fokhagyma', 2, 'gerezd'], ['Kolbász', 200, 'g'],
            ],
            58 => [ // Csokis brownie (9 adag)
                ['Csokoládé', 200, 'g'], ['Vaj', 150, 'g'], ['Cukor', 200, 'g'], ['Tojás', 3, 'db'], ['Liszt', 100, 'g'],
                ['Kakaópor', 20, 'g'], ['Só', 0.25, 'teáskanál'], ['Dió', 100, 'g'],
            ],
            59 => [ // Kolbászos lecsós tészta (4 adag)
                ['Tészta', 400, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Kolbász', 200, 'g'], ['Paprika', 4, 'db'],
                ['Paradicsom', 3, 'db'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Pirospaprika őrlemény', 1, 'teáskanál'],
            ],
            60 => [ // Zabkása (2 adag)
                ['Zabpehely', 100, 'g'], ['Tej', 400, 'ml'], ['Méz', 2, 'evőkanál'], ['Banán', 1, 'db'], ['Eper', 100, 'g'],
                ['Dió', 30, 'g'],
            ],
            61 => [ // Sertésragu leves (6 adag)
                ['Sertéshús', 500, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Víz', 2000, 'ml'], ['Só', 2, 'teáskanál'],
                ['Bors', 0.5, 'teáskanál'], ['Babérlevél', 2, 'db'], ['Sárgarépa', 2, 'db'], ['Burgonya', 400, 'g'],
                ['Zöldborsó', 150, 'g'], ['Tejföl', 200, 'g'], ['Liszt', 20, 'g'], ['Petrezselyem', 1, 'csokor'],
            ],
            62 => [ // Csirkés Caesar saláta (2 adag)
                ['Csirkemell', 300, 'g'], ['Só', 0.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Olaj', 2, 'evőkanál'],
                ['Saláta', 1, 'fej'], ['Kenyér', 2, 'szelet'], ['Majonéz', 3, 'evőkanál'], ['Citrom', 0.5, 'db'],
                ['Fokhagyma', 1, 'gerezd'], ['Mustár', 1, 'teáskanál'], ['Parmezán', 40, 'g'],
            ],
            63 => [ // Rakott cukkini (6 adag)
                ['Cukkini', 1000, 'g'], ['Só', 1.5, 'teáskanál'], ['Hagyma', 1, 'db'], ['Olaj', 3, 'evőkanál'],
                ['Darált hús', 500, 'g'], ['Paradicsomszósz', 300, 'ml'], ['Bors', 0.5, 'teáskanál'], ['Tejföl', 200, 'g'],
                ['Sajt', 150, 'g'],
            ],
            64 => [ // Tárkonyos csirkeraguleves (4 adag)
                ['Csirkemell', 400, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Só', 1.5, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Tárkony', 1, 'teáskanál'], ['Sárgarépa', 2, 'db'], ['Zöldborsó', 100, 'g'],
                ['Víz', 1500, 'ml'], ['Tejföl', 200, 'g'], ['Liszt', 20, 'g'],
            ],
            65 => [ // Görög saláta (4 adag)
                ['Paradicsom', 4, 'db'], ['Uborka', 1, 'db'], ['Paprika', 1, 'db'], ['Hagyma', 1, 'db'], ['Olívabogyó', 80, 'g'],
                ['Olaj', 3, 'evőkanál'], ['Só', 0.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Feta sajt', 200, 'g'],
            ],
            66 => [ // Burgonyás pogácsa (8 adag)
                ['Burgonya', 250, 'g'], ['Élesztő', 20, 'g'], ['Tej', 100, 'ml'], ['Cukor', 5, 'g'], ['Liszt', 500, 'g'],
                ['Vaj', 150, 'g'], ['Tojás', 2, 'db'], ['Só', 2, 'teáskanál'], ['Sajt', 100, 'g'],
            ],
            67 => [ // Spenótos-tejfölös tészta (4 adag)
                ['Penne', 400, 'g'], ['Fokhagyma', 3, 'gerezd'], ['Olaj', 2, 'evőkanál'], ['Spenót', 300, 'g'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tejszín', 200, 'ml'], ['Tejföl', 150, 'g'], ['Sajt', 80, 'g'],
            ],
            68 => [ // Céklaleves (4 adag)
                ['Cékla', 600, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 1, 'evőkanál'], ['Víz', 800, 'ml'], ['Só', 1, 'teáskanál'],
                ['Ecet', 1, 'evőkanál'], ['Tejszín', 100, 'ml'], ['Tejföl', 100, 'g'],
            ],
            69 => [ // Mártásos csirkemell (4 adag)
                ['Csirkemell', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Olaj', 3, 'evőkanál'],
                ['Hagyma', 1, 'db'], ['Gomba', 300, 'g'], ['Tejszín', 200, 'ml'], ['Tészta', 400, 'g'],
            ],
            70 => [ // Diós kalács (10 adag)
                ['Élesztő', 25, 'g'], ['Tej', 350, 'ml'], ['Cukor', 230, 'g'], ['Liszt', 500, 'g'], ['Só', 0.5, 'teáskanál'],
                ['Tojás', 2, 'db'], ['Vaj', 100, 'g'], ['Dió', 250, 'g'],
            ],
            71 => [ // Zöldséges csirke stir fry (4 adag)
                ['Csirkemell', 500, 'g'], ['Szójaszósz', 4, 'evőkanál'], ['Keményítő', 1, 'evőkanál'], ['Paprika', 2, 'db'],
                ['Sárgarépa', 2, 'db'], ['Hagyma', 1, 'db'], ['Brokkoli', 300, 'g'], ['Rizs', 300, 'g'], ['Víz', 600, 'ml'],
                ['Olaj', 3, 'evőkanál'], ['Fokhagyma', 2, 'gerezd'], ['Gyömbér', 20, 'g'], ['Földimogyoró', 40, 'g'],
            ],
            72 => [ // Paradicsomos bab (4 adag)
                ['Szárazbab', 300, 'g'], ['Víz', 1500, 'ml'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'],
                ['Fokhagyma', 2, 'gerezd'], ['Kolbász', 150, 'g'], ['Paradicsomszósz', 400, 'ml'], ['Só', 1, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Pirospaprika őrlemény', 1, 'teáskanál'], ['Cukor', 10, 'g'],
            ],
            73 => [ // Sajtos-tejfölös melegszendvics (2 adag)
                ['Tejföl', 150, 'g'], ['Sajt', 100, 'g'], ['Fokhagyma', 1, 'gerezd'], ['Só', 0.25, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Kenyér', 4, 'szelet'],
            ],
            74 => [ // Zöldségkrémleves (4 adag)
                ['Sárgarépa', 3, 'db'], ['Burgonya', 300, 'g'], ['Zeller', 1, 'db'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'],
                ['Víz', 1000, 'ml'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tejszín', 100, 'ml'],
                ['Kenyér', 2, 'szelet'],
            ],
            75 => [ // Csirkés wrap (2 adag)
                ['Csirkemell', 250, 'g'], ['Só', 0.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'],
                ['Pirospaprika őrlemény', 0.5, 'teáskanál'], ['Olaj', 1, 'evőkanál'], ['Tortilla', 2, 'db'], ['Saláta', 0.5, 'fej'],
                ['Paradicsom', 1, 'db'], ['Paprika', 1, 'db'], ['Joghurt', 100, 'g'], ['Fokhagyma', 1, 'gerezd'],
            ],
            76 => [ // Krumplis tészta (4 adag)
                ['Burgonya', 600, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 3, 'evőkanál'], ['Pirospaprika őrlemény', 1, 'teáskanál'],
                ['Só', 1.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tészta', 400, 'g'],
            ],
            77 => [ // Csokoládé torta (10 adag)
                ['Csokoládé', 200, 'g'], ['Vaj', 150, 'g'], ['Tojás', 4, 'db'], ['Cukor', 200, 'g'], ['Liszt', 150, 'g'],
                ['Kakaópor', 30, 'g'], ['Sütőpor', 1, 'teáskanál'], ['Tejszín', 200, 'ml'],
            ],
            78 => [ // Zöldséges lasagne (6 adag)
                ['Hagyma', 1, 'db'], ['Fokhagyma', 2, 'gerezd'], ['Olaj', 2, 'evőkanál'], ['Cukkini', 400, 'g'], ['Paprika', 2, 'db'],
                ['Paradicsomszósz', 700, 'ml'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Bazsalikom', 1, 'teáskanál'],
                ['Lasagne tészta', 250, 'g'], ['Ricotta', 250, 'g'], ['Sajt', 200, 'g'],
            ],
            79 => [ // Chilis bab (4 adag)
                ['Szárazbab', 250, 'g'], ['Víz', 2000, 'ml'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Darált hús', 400, 'g'],
                ['Fokhagyma', 2, 'gerezd'], ['Paprika', 1, 'db'], ['Paradicsomszósz', 400, 'ml'], ['Só', 1, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Chili', 1, 'teáskanál'], ['Rizs', 250, 'g'],
            ],
            80 => [ // Túrós palacsinta (4 adag)
                ['Liszt', 200, 'g'], ['Tojás', 3, 'db'], ['Tej', 400, 'ml'], ['Cukor', 80, 'g'], ['Só', 0.25, 'teáskanál'],
                ['Olaj', 2, 'evőkanál'], ['Túró', 500, 'g'], ['Vaníliás cukor', 1, 'csomag'], ['Tejföl', 200, 'g'],
                ['Porcukor', 20, 'g'],
            ],
            81 => [ // Borsos tokány (4 adag)
                ['Sertéshús', 600, 'g'], ['Hagyma', 2, 'db'], ['Olaj', 2, 'evőkanál'], ['Bors', 1, 'teáskanál'],
                ['Só', 1, 'teáskanál'], ['Víz', 700, 'ml'], ['Tejszín', 200, 'ml'], ['Rizs', 250, 'g'],
            ],
            82 => [ // Sütőben sült csirkecomb (4 adag)
                ['Csirkecomb', 1200, 'g'], ['Olaj', 3, 'evőkanál'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'],
                ['Pirospaprika őrlemény', 1, 'teáskanál'], ['Fokhagyma', 3, 'gerezd'], ['Burgonya', 800, 'g'], ['Citrom', 1, 'db'],
            ],
            83 => [ // Karfiol gratin (4 adag)
                ['Karfiol', 800, 'g'], ['Víz', 1500, 'ml'], ['Só', 1.5, 'teáskanál'], ['Vaj', 30, 'g'], ['Liszt', 30, 'g'],
                ['Tej', 400, 'ml'], ['Tejszín', 100, 'ml'], ['Bors', 0.25, 'teáskanál'], ['Sajt', 150, 'g'],
            ],
            84 => [ // Burgonyaleves (4 adag)
                ['Burgonya', 700, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 1, 'evőkanál'], ['Víz', 800, 'ml'], ['Tej', 200, 'ml'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Tejszín', 100, 'ml'], ['Szalonna', 100, 'g'],
            ],
            85 => [ // Töltött cukkini (4 adag)
                ['Cukkini', 4, 'db'], ['Hagyma', 1, 'db'], ['Olaj', 1, 'evőkanál'], ['Darált hús', 400, 'g'],
                ['Paradicsomszósz', 200, 'ml'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Sajt', 100, 'g'],
            ],
            86 => [ // Gyros tál (4 adag)
                ['Csirkemell', 600, 'g'], ['Olaj', 3, 'evőkanál'], ['Fokhagyma', 3, 'gerezd'], ['Pirospaprika őrlemény', 1, 'teáskanál'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Uborka', 1, 'db'], ['Joghurt', 250, 'g'],
                ['Paradicsom', 2, 'db'], ['Hagyma', 1, 'db'], ['Saláta', 0.5, 'fej'], ['Pita', 4, 'db'],
            ],
            87 => [ // Vanília puding (4 adag)
                ['Tej', 500, 'ml'], ['Cukor', 80, 'g'], ['Vanília', 1, 'teáskanál'], ['Keményítő', 3, 'evőkanál'],
                ['Tejszín', 200, 'ml'], ['Eper', 100, 'g'],
            ],
            88 => [ // Csirkés quesadilla (2 adag)
                ['Csirkemell', 250, 'g'], ['Só', 0.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'],
                ['Pirospaprika őrlemény', 0.5, 'teáskanál'], ['Olaj', 1, 'evőkanál'], ['Paprika', 1, 'db'], ['Tortilla', 4, 'db'],
                ['Sajt', 150, 'g'], ['Paradicsom', 1, 'db'],
            ],
            89 => [ // Paradicsomos tészta (4 adag)
                ['Fokhagyma', 3, 'gerezd'], ['Olaj', 3, 'evőkanál'], ['Paradicsomszósz', 500, 'ml'], ['Só', 1, 'teáskanál'],
                ['Bors', 0.25, 'teáskanál'], ['Cukor', 5, 'g'], ['Bazsalikom', 1, 'teáskanál'], ['Tészta', 400, 'g'],
                ['Sajt', 60, 'g'],
            ],
            90 => [ // Diós sütemény (10 adag)
                ['Liszt', 300, 'g'], ['Vaj', 200, 'g'], ['Cukor', 100, 'g'], ['Vaníliás cukor', 1, 'csomag'], ['Tojás', 1, 'db'],
                ['Dió', 150, 'g'], ['Porcukor', 50, 'g'],
            ],
            91 => [ // Sertésszűz pecsenye (4 adag)
                ['Sertéshús', 700, 'g'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Fokhagyma', 2, 'gerezd'],
                ['Olaj', 3, 'evőkanál'], ['Burgonya', 800, 'g'],
            ],
            92 => [ // Zöldborsós rizs (4 adag)
                ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Rizs', 300, 'g'], ['Víz', 600, 'ml'], ['Só', 1, 'teáskanál'],
                ['Zöldborsó', 200, 'g'], ['Petrezselyem', 1, 'csokor'],
            ],
            93 => [ // Tojásos nokedli (4 adag)
                ['Nokedli', 800, 'g'], ['Tojás', 6, 'db'], ['Só', 1, 'teáskanál'], ['Olaj', 2, 'evőkanál'], ['Tejföl', 200, 'g'],
                ['Saláta', 1, 'fej'],
            ],
            94 => [ // Sajtos pogácsa (8 adag)
                ['Élesztő', 20, 'g'], ['Tej', 150, 'ml'], ['Cukor', 5, 'g'], ['Liszt', 500, 'g'], ['Vaj', 200, 'g'],
                ['Tejföl', 150, 'g'], ['Tojás', 2, 'db'], ['Só', 2, 'teáskanál'], ['Sajt', 200, 'g'],
            ],
            95 => [ // Csirke curry (4 adag)
                ['Csirkemell', 600, 'g'], ['Hagyma', 1, 'db'], ['Olaj', 2, 'evőkanál'], ['Fokhagyma', 2, 'gerezd'],
                ['Gyömbér', 15, 'g'], ['Curry por', 2, 'evőkanál'], ['Paradicsom', 2, 'db'], ['Tejszín', 200, 'ml'],
                ['Só', 1, 'teáskanál'], ['Rizs', 300, 'g'], ['Víz', 600, 'ml'],
            ],
            96 => [ // Meggyleves (4 adag)
                ['Meggy', 500, 'g'], ['Víz', 1000, 'ml'], ['Cukor', 120, 'g'], ['Fahéj', 0.5, 'teáskanál'],
                ['Keményítő', 1, 'evőkanál'], ['Tejszín', 200, 'ml'],
            ],
            97 => [ // Sajtos makaróni (4 adag)
                ['Makaróni', 400, 'g'], ['Vaj', 40, 'g'], ['Liszt', 30, 'g'], ['Tej', 500, 'ml'], ['Sajt', 250, 'g'],
                ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'],
            ],
            98 => [ // Hagymás rostélyos (4 adag)
                ['Marhahús', 800, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Liszt', 30, 'g'], ['Hagyma', 3, 'db'],
                ['Olaj', 4, 'evőkanál'], ['Víz', 200, 'ml'], ['Burgonya', 800, 'g'],
            ],
            99 => [ // Epres tiramisu (8 adag)
                ['Tojás', 4, 'db'], ['Cukor', 100, 'g'], ['Mascarpone', 500, 'g'], ['Kávé', 300, 'ml'], ['Eper', 400, 'g'],
                ['Babapiskóta', 300, 'g'], ['Kakaópor', 20, 'g'],
            ],
            100 => [ // Zöldséges omlett (2 adag)
                ['Tojás', 4, 'db'], ['Só', 0.5, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Paprika', 1, 'db'],
                ['Paradicsom', 1, 'db'], ['Olaj', 1, 'evőkanál'], ['Sajt', 50, 'g'],
            ],
            101 => [ // Hortobágyi palacsinta (6 adag)
                ['Liszt', 220, 'g'], ['Tojás', 2, 'db'], ['Tej', 400, 'ml'], ['Só', 1.25, 'teáskanál'], ['Olaj', 4, 'evőkanál'],
                ['Csirkemell', 500, 'g'], ['Hagyma', 1, 'db'], ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Paprika', 1, 'db'],
                ['Paradicsom', 1, 'db'], ['Bors', 0.25, 'teáskanál'], ['Víz', 200, 'ml'], ['Tejföl', 300, 'g'],
            ],
            102 => [ // Újházy-tyúkhúsleves (6 adag)
                ['Tyúkhús', 1500, 'g'], ['Víz', 3000, 'ml'], ['Só', 2, 'teáskanál'], ['Bors', 1, 'teáskanál'],
                ['Babérlevél', 2, 'db'], ['Sárgarépa', 3, 'db'], ['Zeller', 1, 'db'], ['Hagyma', 1, 'db'], ['Gomba', 200, 'g'],
                ['Zöldborsó', 100, 'g'], ['Csigatészta', 200, 'g'],
            ],
            103 => [ // Brassói aprópecsenye (4 adag)
                ['Sertéshús', 600, 'g'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Burgonya', 800, 'g'],
                ['Olaj', 5, 'evőkanál'], ['Fokhagyma', 4, 'gerezd'], ['Pirospaprika őrlemény', 1, 'evőkanál'], ['Víz', 100, 'ml'],
            ],
            104 => [ // Somlói galuska (8 adag)
                ['Tojás', 10, 'db'], ['Cukor', 250, 'g'], ['Liszt', 150, 'g'], ['Kakaópor', 20, 'g'], ['Dió', 80, 'g'],
                ['Tej', 500, 'ml'], ['Vanília', 1, 'teáskanál'], ['Csokoládé', 100, 'g'], ['Tejszín', 300, 'ml'],
            ],
            105 => [ // Debreceni gulyás (6 adag)
                ['Hagyma', 2, 'db'], ['Olaj', 3, 'evőkanál'], ['Pirospaprika őrlemény', 2, 'evőkanál'], ['Víz', 2000, 'ml'],
                ['Burgonya', 800, 'g'], ['Sárgarépa', 2, 'db'], ['Só', 1.5, 'teáskanál'], ['Bors', 0.5, 'teáskanál'],
                ['Kolbász', 400, 'g'], ['Paprika', 2, 'db'], ['Paradicsom', 1, 'db'],
            ],
            106 => [ // Garnélás pad thai (4 adag)
                ['Rizstészta', 250, 'g'], ['Szójaszósz', 3, 'evőkanál'], ['Cukor', 20, 'g'], ['Citrom', 1, 'db'],
                ['Chili', 0.5, 'teáskanál'], ['Olaj', 3, 'evőkanál'], ['Fokhagyma', 2, 'gerezd'], ['Garnéla', 300, 'g'],
                ['Tojás', 2, 'db'], ['Hagyma', 1, 'db'], ['Földimogyoró', 50, 'g'],
            ],
            107 => [ // Teriyaki lazac szezámmaggal (4 adag)
                ['Rizs', 300, 'g'], ['Víz', 650, 'ml'], ['Szójaszósz', 4, 'evőkanál'], ['Méz', 2, 'evőkanál'],
                ['Gyömbér', 10, 'g'], ['Fokhagyma', 2, 'gerezd'], ['Keményítő', 1, 'evőkanál'], ['Lazac', 600, 'g'],
                ['Olaj', 1, 'evőkanál'], ['Brokkoli', 400, 'g'], ['Szezámmag', 15, 'g'],
            ],
            108 => [ // Szezámos-mogyorós tofu tál (4 adag)
                ['Rizs', 300, 'g'], ['Víz', 600, 'ml'], ['Tofu', 400, 'g'], ['Keményítő', 2, 'evőkanál'], ['Olaj', 3, 'evőkanál'],
                ['Brokkoli', 300, 'g'], ['Sárgarépa', 2, 'db'], ['Fokhagyma', 2, 'gerezd'], ['Gyömbér', 10, 'g'],
                ['Szójaszósz', 4, 'evőkanál'], ['Cukor', 10, 'g'], ['Földimogyoró', 40, 'g'], ['Szezámmag', 15, 'g'],
            ],
            109 => [ // Mustáros-mézes lazac (4 adag)
                ['Lazac', 600, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.5, 'teáskanál'], ['Mustár', 2, 'evőkanál'],
                ['Méz', 2, 'evőkanál'], ['Fokhagyma', 1, 'gerezd'], ['Citrom', 1, 'db'], ['Saláta', 1, 'fej'], ['Olaj', 1, 'evőkanál'],
            ],
            110 => [ // Fokhagymás garnélás spagetti (4 adag)
                ['Spagetti', 400, 'g'], ['Olaj', 4, 'evőkanál'], ['Fokhagyma', 4, 'gerezd'], ['Chili', 0.5, 'teáskanál'],
                ['Garnéla', 400, 'g'], ['Só', 1, 'teáskanál'], ['Bors', 0.25, 'teáskanál'], ['Vaj', 20, 'g'], ['Citrom', 1, 'db'],
                ['Petrezselyem', 1, 'csokor'],
            ],
            111 => [ // Tzatziki (4 adag)
                ['Uborka', 1, 'db'], ['Só', 0.5, 'teáskanál'], ['Joghurt', 400, 'g'], ['Fokhagyma', 2, 'gerezd'],
                ['Citrom', 0.5, 'db'], ['Bors', 0.25, 'teáskanál'], ['Olaj', 1, 'evőkanál'], ['Paprika', 2, 'db'],
            ],
            112 => [ // Házi limonádé (4 adag)
                ['Cukor', 100, 'g'], ['Víz', 1000, 'ml'], ['Citrom', 4, 'db'],
            ],
            113 => [ // Epres-banános smoothie (2 adag)
                ['Eper', 200, 'g'], ['Banán', 1, 'db'], ['Joghurt', 200, 'g'], ['Tej', 200, 'ml'], ['Méz', 1, 'evőkanál'],
                ['Zabpehely', 30, 'g'],
            ],
            114 => [ // Mézes-gyömbéres citromos tea (4 adag)
                ['Gyömbér', 30, 'g'], ['Víz', 1000, 'ml'], ['Fahéj', 0.5, 'teáskanál'], ['Citrom', 1, 'db'], ['Méz', 4, 'evőkanál'],
            ],
            115 => [ // Meggybefőtt (6 üveg)
                ['Meggy', 2000, 'g'], ['Víz', 1000, 'ml'], ['Cukor', 400, 'g'],
            ],
            116 => [ // Almabefőtt fahéjjal (6 üveg)
                ['Alma', 10, 'db'], ['Citrom', 1, 'db'], ['Víz', 1000, 'ml'], ['Cukor', 300, 'g'], ['Fahéj', 1, 'teáskanál'],
            ],
            117 => [ // Eperlekvár (5 üveg)
                ['Eper', 1500, 'g'], ['Cukor', 750, 'g'], ['Citrom', 1, 'db'],
            ],
            118 => [ // Gyümölcssaláta (4 adag)
                ['Alma', 2, 'db'], ['Banán', 2, 'db'], ['Eper', 200, 'g'], ['Málna', 100, 'g'], ['Citrom', 0.5, 'db'],
                ['Méz', 2, 'evőkanál'], ['Dió', 30, 'g'],
            ],
            119 => [ // Sült alma dióval (4 adag)
                ['Alma', 4, 'db'], ['Dió', 60, 'g'], ['Méz', 3, 'evőkanál'], ['Fahéj', 1, 'teáskanál'], ['Vaj', 30, 'g'],
            ],
            120 => [ // Csokoládés eper (4 adag)
                ['Eper', 400, 'g'], ['Csokoládé', 150, 'g'], ['Dió', 30, 'g'],
            ],
            121 => [ // Garnélás sült rizs (4 adag)
                ['Rizs', 300, 'g'], ['Víz', 600, 'ml'], ['Olaj', 3, 'evőkanál'], ['Tojás', 3, 'db'], ['Garnéla', 300, 'g'],
                ['Hagyma', 1, 'db'], ['Fokhagyma', 2, 'gerezd'], ['Sárgarépa', 1, 'db'], ['Zöldborsó', 150, 'g'],
                ['Szójaszósz', 3, 'evőkanál'], ['Szezámmag', 10, 'g'],
            ],
        ];

        // Melyik hozzávaló milyen allergént/érzékenységet tartalmaz.
        // Ebből számoljuk ki a receptek allergénjeit, így nem kell kézzel karbantartani.
        $allergenMap = [
            'Glutén'   => ['Liszt', 'Tészta', 'Kenyér', 'Zsemlemorzsa', 'Spagetti', 'Nokedli', 'Csipetke', 'Tarhonya', 'Makaróni',
                           'Lasagne tészta', 'Csigatészta', 'Penne', 'Tortilla', 'Pita', 'Kifli', 'Babapiskóta', 'Zabpehely', 'Szójaszósz'],
            'Laktóz'   => ['Tej', 'Vaj', 'Tejföl', 'Tejszín', 'Sajt', 'Túró', 'Parmezán', 'Feta sajt', 'Ricotta', 'Mascarpone', 'Joghurt'],
            'Cukor'    => ['Cukor', 'Porcukor', 'Vaníliás cukor', 'Méz', 'Csokoládé', 'Baracklekvár', 'Babapiskóta'],
            'Tojás'    => ['Tojás', 'Majonéz', 'Nokedli', 'Csipetke', 'Tarhonya', 'Csigatészta', 'Babapiskóta'],
            'Szója'        => ['Szójaszósz', 'Tofu'],
            'Diófélék'     => ['Dió'],
            'Földimogyoró' => ['Földimogyoró'],
            'Hal'          => ['Ponty', 'Harcsa', 'Keszeg', 'Lazac'],
            'Rákfélék'     => ['Garnéla'],
            'Zeller'       => ['Zeller'],
            'Mustár'       => ['Mustár'],
            'Szezámmag'    => ['Szezámmag'],
        ];

        // Név => ID párosok az adatbázisból (így a fenti listában olvasható nevek szerepelhetnek)
        $ingredientIds = DB::table('ingredient')->pluck('id', 'name');
        $allergenIds = DB::table('allergen')->pluck('id', 'name');

        $records = [];
        $allergenRecords = [];

        foreach ($recipeIngredients as $recipeId => $ingredients) {
            $recipeAllergens = [];

            foreach ($ingredients as [$name, $quantity, $unit]) {
                if (!isset($ingredientIds[$name])) {
                    throw new \RuntimeException("Ismeretlen hozzávaló a(z) {$recipeId}. receptben: {$name}");
                }

                $records[] = [
                    'ingredient_id' => $ingredientIds[$name],
                    'recipe_id' => $recipeId,
                    'quantity' => $quantity,
                    'unit' => $unit,
                ];

                foreach ($allergenMap as $allergen => $names) {
                    if (in_array($name, $names)) {
                        $recipeAllergens[$allergen] = true;
                    }
                }
            }

            foreach (array_keys($recipeAllergens) as $allergen) {
                $allergenRecords[] = ['allergen_id' => $allergenIds[$allergen], 'recipe_id' => $recipeId];
            }
        }

        foreach (array_chunk($records, 200) as $chunk) {
            DB::table('ingredient_recipe')->insert($chunk);
        }

        DB::table('allergen_recipe')->insert($allergenRecords);
    }
}
