<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepSeeder extends Seeder
{
    public function run(): void
    {
        $recipeSteps = [
            1 => [ // Gulyásleves
                ['800 g marhahúst megmosunk és 2 cm-es kockákra vágunk.', 'Előkészítés'],
                ['2 db hagymát megtisztítunk és apróra vágunk.', 'Előkészítés'],
                ['3 evőkanál olajon megdinszteljük a hagymát, majd hozzáadjuk a húst.', 'Főzés'],
                ['Felöntjük vízzel, beleadjuk 2 teáskanál sót, és puhára főzzük.', 'Főzés'],
                ['Forrón, tányérokba merítve tálaljuk a levest.', 'Tálalás'],
            ],
            2 => [ // Paradicsomleves
                ['500 g paradicsomot megmosunk és felkockázunk.', 'Előkészítés'],
                ['2 gerezd fokhagymát felaprítunk.', 'Előkészítés'],
                ['2 evőkanál olajon megpirítjuk a fokhagymát és a paradicsomot.', 'Főzés'],
                ['Hozzáadunk 1 teáskanál sót, összefőzzük és leturmixoljuk.', 'Főzés'],
                ['Melegen, poharakba vagy tálkákba öntve tálaljuk.', 'Tálalás'],
            ],
            3 => [ // Húsleves
                ['600 g csirkemellet és 1 db zellert megtisztítunk, felvágunk.', 'Előkészítés'],
                ['1 db hagymát meghámozunk.', 'Előkészítés'],
                ['Lábosba tesszük, felöntjük vízzel és 2 teáskanál sóval fűszerezzük.', 'Főzés'],
                ['Lassan készre főzzük a levest.', 'Főzés'],
                ['Tányérokba szedve, forrón tálaljuk.', 'Tálalás'],
            ],
            4 => [ // Zöldségleves
                ['300 g burgonyát és 1 db zellert meghámozunk, felkockázunk.', 'Előkészítés'],
                ['1 db hagymát felaprítunk.', 'Előkészítés'],
                ['2 evőkanál olajon megdinszteljük a zöldségeket.', 'Főzés'],
                ['Felöntjük vízzel, hozzáadunk 1 teáskanál sót és készre főzzük.', 'Főzés'],
                ['Melegen, frissen tálaljuk a levest.', 'Tálalás'],
            ],
            5 => [ // Gyümölcsleves
                ['3 db almát és 2 db banánt meghámozunk, majd felvágunk.', 'Előkészítés'],
                ['Lábosba tesszük a gyümölcsöket, felöntjük 500 ml tejjel.', 'Elkészítés'],
                ['Hozzáadunk 2 evőkanál cukrot, és összeforraljuk.', 'Főzés'],
                ['Hűtve, poharakban tálaljuk.', 'Tálalás'],
            ],
            6 => [ // Sajtleves
                ['50 g vajat megolvasztunk, hozzáadjuk 2 evőkanál lisztet.', 'Elkészítés'],
                ['2 gerezd fokhagymát rányomunk.', 'Előkészítés'],
                ['Felöntjük vízzel, beletesszük 200 g sajtot és 1 teáskanál sót.', 'Főzés'],
                ['Addig keverjük, amíg a sajt teljesen elolvad.', 'Főzés'],
                ['Forrón, sajttal megszórva tálaljuk.', 'Tálalás'],
            ],
            7 => [ // Pörkölt
                ['600 g sertéshúst és 2 db hagymát aprítunk.', 'Előkészítés'],
                ['3 evőkanál olajon megpirítjuk a hagymát, hozzáadjuk a húst.', 'Főzés'],
                ['Hozzáadunk 2 teáskanál sót és puhára pároljuk.', 'Főzés'],
                ['Külön kifőzzük a 300 g tésztát, majd összekeverjük.', 'Elkészítés'],
                ['Forrón tálaljuk a kész pörköltet.', 'Tálalás'],
            ],
            8 => [ // Rántott csirke
                ['600 g csirkemellet felszeletelünk.', 'Előkészítés'],
                ['Megforgatjuk 100 g lisztben és 2 db felvert tojásban.', 'Elkészítés'],
                ['2 l olajban kisütjük a panírozott húst.', 'Sütés'],
                ['500 g burgonyából hasábokat vágunk és kisütjük.', 'Sütés'],
                ['Frissen, a sült krumplival együtt tálaljuk.', 'Tálalás'],
            ],
            9 => [ // Bolognai spagetti
                ['400 g sertéshúst és 1 db hagymát előkészítünk, felaprítunk.', 'Előkészítés'],
                ['2 evőkanál olajon megdinszteljük, hozzáadjuk a 400 g paradicsomot.', 'Főzés'],
                ['400 g tésztát kifőzünk sós vízben.', 'Főzés'],
                ['Összekeverjük a mártással és tálaljuk.', 'Tálalás'],
            ],
            10 => [ // Lasagne
                ['600 g sertéshúst megpirítunk serpenyőben.', 'Előkészítés'],
                ['Besamelt készítünk 3 evőkanál lisztből és 300 ml tejből.', 'Elkészítés'],
                ['Tepsibe rétegezzük az 500 g tésztát, a húst és a besamelt.', 'Elkészítés'],
                ['Megszórjuk 200 g sajttal és aranyszínűre sütjük.', 'Sütés'],
                ['Szeletekre vágva, melegen tálaljuk.', 'Tálalás'],
            ],
            11 => [ // Caesar saláta
                ['300 g csirkemellet felkockázunk és megsütünk.', 'Elkészítés'],
                ['50 g sajtot felreszelünk.', 'Előkészítés'],
                ['Összekeverjük a húst és a sajtot 2 evőkanál olajjal meg 1 csipet sóval.', 'Tálalás'],
            ],
            12 => [ // Görög saláta
                ['400 g paradicsomot és 1 db hagymát felvágunk.', 'Előkészítés'],
                ['Hozzáadunk 150 g sajtot.', 'Előkészítés'],
                ['Meglocsoljuk 3 evőkanál olajjal, meghintjük 1 teáskanál sóval és átkeverjük.', 'Tálalás'],
            ],
            13 => [ // Sült krumpli
                ['800 g burgonyát meghámozunk és hasábokra vágunk.', 'Előkészítés'],
                ['Megforgatjuk 3 evőkanál olajban és 1 teáskanál sóban.', 'Elkészítés'],
                ['Tepsibe tesszük és ropogósra sütjük.', 'Sütés'],
                ['Frissen, melegen tálaljuk a sült krumplit.', 'Tálalás'],
            ],
            14 => [ // Párolt rizs
                ['300 g rizst alaposan megmosunk.', 'Előkészítés'],
                ['2 evőkanál olajon átfuttatjuk a rizst.', 'Főzés'],
                ['Felöntjük vízzel, beleadjuk 1 teáskanál sót és lefedve készre pároljuk.', 'Főzés'],
                ['Köretként, frissen tálaljuk.', 'Tálalás'],
            ],
            15 => [ // Palacsinta
                ['250 g lisztet, 400 ml tejet, 2 db tojást, 2 evőkanál cukrot és 2 evőkanál olajat simára keverünk.', 'Elkészítés'],
                ['Forró serpenyőben egyenként kisütjük a palacsintákat.', 'Sütés'],
                ['Tekerve vagy hajtogatva tálaljuk.', 'Tálalás'],
            ],
            16 => [ // Almás pite
                ['400 g lisztet és 200 g vajat elmorzsolunk, hozzáadunk 1 db tojást.', 'Előkészítés'],
                ['6 db almát meghámozunk, lereszelünk és 4 evőkanál cukorral összekeverünk.', 'Előkészítés'],
                ['A tésztába töltjük az almát és aranybarnára sütjük.', 'Sütés'],
                ['Szeletelve, porcukorral tálaljuk.', 'Tálalás'],
            ],
            17 => [ // Tiramisu
                ['200 g kenyeret felkockázunk és leöntünk 200 ml tejjel.', 'Előkészítés'],
                ['Kikeverjük 2 db tojással és 3 evőkanál cukorral.', 'Elkészítés'],
                ['Formába rétegezzük és meghintjük 2 evőkanál kakaóporral.', 'Tálalás'],
            ],
            18 => [ // Csokoládés süti
                ['200 g lisztet, 150 g aprított csokoládét, 100 g vajat, 3 evőkanál cukrot és 2 db tojást összekeverünk.', 'Elkészítés'],
                ['Tepsibe simítjuk a masszát és megsütjük.', 'Sütés'],
                ['Hűtés után kockákra vágva tálaljuk.', 'Tálalás'],
            ],
            19 => [ // Bruschetta
                ['4 szelet kenyeret ropogósra pirítunk.', 'Előkészítés'],
                ['3 db paradicsomot és 2 gerezd fokhagymát aprítunk, összekeverünk.', 'Előkészítés'],
                ['Rátesszük a kenyérre, meglocsoljuk 2 evőkanál olajjal és 1 csipet sóval.', 'Tálalás'],
            ],
            20 => [ // Guacamole
                ['2 db paradicsomot, 1 db hagymát és 1 gerezd fokhagymát apróra vágunk.', 'Előkészítés'],
                ['Összekeverjük a zöldségeket és ízesítjük 1 teáskanál sóval.', 'Tálalás'],
            ],
            21 => [ // Házi kenyér
                ['500 g lisztet, 2 teáskanál sót, 1 evőkanál olajat és vizet összegyúrunk.', 'Elkészítés'],
                ['Alaposan megkelesztjük a tésztát.', 'Elkészítés'],
                ['Formába tesszük és ropogósra sütjük.', 'Sütés'],
                ['Szeletelve, frissen tálaljuk.', 'Tálalás'],
            ],
            22 => [ // Kakaós csiga
                ['400 g lisztet, 250 ml tejet és 80 g vajat összegyúrunk tésztává.', 'Elkészítés'],
                ['Megtöltjük 3 evőkanál kakaóporral és 3 evőkanál cukorral.', 'Elkészítés'],
                ['Feltekerjük, felvágjuk szeletekre és megsütjük.', 'Sütés'],
                ['Langyosan tálaljuk a kakaós csigát.', 'Tálalás'],
            ],
            23 => [ // Narancsos smoothie
                ['3 db narancsot kifacsarunk.', 'Előkészítés'],
                ['1 db banánnal összeturmixoljuk a narancslevet.', 'Elkészítés'],
                ['Poharakba öntve, frissen tálaljuk.', 'Tálalás'],
            ],
            24 => [ // Banános turmix
                ['2 db banánt meghámozunk és felvágunk.', 'Előkészítés'],
                ['Hozzáadunk 300 ml tejet és 1 evőkanál cukrot.', 'Elkészítés'],
                ['Egységesre turmixoljuk.', 'Elkészítés'],
                ['Poharakba töltve, hidegen tálaljuk.', 'Tálalás'],
            ],
            25 => [ // Almatöltelék befőtt
                ['1 kg almát meghámozunk és feldarabolunk.', 'Előkészítés'],
                ['Megfőzzük 100 g cukorral.', 'Főzés'],
                ['Üvegekbe töltjük és lezárjuk.', 'Elkészítés'],
                ['Kamrában tárolva, desszertként tálaljuk.', 'Tálalás'],
            ],
            26 => [ // Eperbefőtt
                ['Epret előkészítünk és üvegekbe rakunk.', 'Előkészítés'],
                ['150 g cukorral felöntjük és üvegekbe zárjuk.', 'Elkészítés'],
                ['Hűtve vagy tálalás előtt felbontva kínáljuk.', 'Tálalás'],
            ],
            27 => [ // Friss alma
                ['1 db almát alaposan megmosunk.', 'Előkészítés'],
                ['Cikkekre vágva tálaljuk.', 'Tálalás'],
            ],
            28 => [ // Narancs szeletek
                ['2 db narancsot meghámozunk.', 'Előkészítés'],
                ['Karikákra vágva tálaljuk.', 'Tálalás'],
            ],
            29 => [ // Sült hal
                ['400 g halat megsózunk 1 teáskanál sóval.', 'Előkészítés'],
                ['2 evőkanál olajon megsütjük a halat.', 'Sütés'],
                ['200 g rizst megpárolunk köretként.', 'Főzés'],
                ['A rizst és a halat együtt tálaljuk.', 'Tálalás'],
            ],
            30 => [ // Rák saláta
                ['300 g rákot megfőzünk sós vízben.', 'Főzés'],
                ['1 db zellert felaprítunk.', 'Előkészítés'],
                ['Összekeverjük 2 evőkanál szójaszósszal és 1 evőkanál olajjal.', 'Tálalás'],
            ],
            31 => [ // Zellerkrémleves
                ['2 db zellert meghámozunk és felkockázunk.', 'Előkészítés'],
                ['40 g vajon megdinszteljük a zellert.', 'Főzés'],
                ['Felöntjük 200 ml tejjel és 1 teáskanál sóval, majd puhára főzzük.', 'Főzés'],
                ['Tányérba merítve, melegen tálaljuk.', 'Tálalás'],
            ],
            32 => [ // Mustáros csirke
                ['600 g csirkemellet előkészítünk.', 'Előkészítés'],
                ['Megkenjük 3 evőkanál mustárral a húst.', 'Előkészítés'],
                ['2 evőkanál olajon és 1 teáskanál sóval készre sütjük.', 'Sütés'],
                ['Szeletelve, szaftosan tálaljuk.', 'Tálalás'],
            ],
            33 => [ // Szezámmagos csirke
                ['500 g csirkemellet felkockázunk.', 'Előkészítés'],
                ['Megforgatjuk 3 evőkanál szezámmagban és 2 evőkanál szójaszószban.', 'Elkészítés'],
                ['2 evőkanál olajon aranybarnára megsütjük.', 'Sütés'],
                ['Melegen, frissen tálaljuk.', 'Tálalás'],
            ],
            34 => [ // Földimogyorós tészta
                ['300 g tésztát kifőzünk.', 'Főzés'],
                ['100 g földimogyorót aprítunk.', 'Előkészítés'],
                ['Összekeverjük 2 evőkanál szójaszósszal és 1 evőkanál olajjal.', 'Tálalás'],
            ],
            35 => [ // Diós süti
                ['250 g lisztet, 150 g diót, 100 g vajat, 3 evőkanál cukrot és 2 db tojást összekeverünk.', 'Elkészítés'],
                ['Előmelegített sütőben megsütjük.', 'Sütés'],
                ['Szeletekre vágva tálaljuk a sütit.', 'Tálalás'],
            ],
            36 => [ // Keto saláta
                ['200 g sajtot és 2 db paradicsomot felvágunk.', 'Előkészítés'],
                ['Meglocsoljuk 2 evőkanál olajjal és 1 csipet sóval.', 'Tálalás'],
            ],
            37 => [ // Low-carb csirke
                ['400 g csirkemellet megsütünk és felkockázunk.', 'Előkészítés'],
                ['2 db paradicsomot felvágunk.', 'Előkészítés'],
                ['Összekeverjük 2 evőkanál olajjal és 1 csipet sóval.', 'Tálalás'],
            ],
            38 => [ // Chilis bab
                ['500 g sertéshúst és 2 db hagymát felaprítunk, majd 2 evőkanál olajon megpirítunk.', 'Főzés'],
                ['Hozzáadunk 400 g babot, 300 g paradicsomot és 1 teáskanál sót.', 'Főzés'],
                ['Alacsony lángon alaposan összefőzzük a chilis babot.', 'Főzés'],
                ['Forrón, tányérokba szedve tálaljuk.', 'Tálalás'],
            ],
            39 => [ // Francia hagymaleves
                ['4 db hagymát vékonyra szeletelünk.', 'Előkészítés'],
                ['50 g vajon megdinszteljük.', 'Főzés'],
                ['Felöntjük vízzel, 1 teáskanál sóval fűszerezzük és összefőzzük.', 'Főzés'],
                ['4 szelet kenyérre szórunk 100 g sajtot és rásütjük a sütőben.', 'Sütés'],
                ['A levest a sajtos pirítóssal tálaljuk.', 'Tálalás'],
            ],
            40 => [ // Zöldséges rizs
                ['300 g rizst és 1 db aprított hagymát előkészítünk.', 'Előkészítés'],
                ['2 evőkanál olajon megpirítjuk a hagymát és a rizst.', 'Főzés'],
                ['Felöntjük vízzel, ízesítjük 1 teáskanál sóval és készre pároljuk.', 'Főzés'],
                ['Melegen, köretként tálaljuk.', 'Tálalás'],
            ],
        ];

        $categoryIds = [];
        foreach (DB::table('step_category')->get() as $row) {
            $categoryIds[$row->name] = $row->id;
        }

        $records = [];
        foreach ($recipeSteps as $recipeId => $steps) {
            foreach ($steps as $index => $step) {
                $records[] = [
                    'description' => $step[0],
                    'recipe_id' => $recipeId,
                    'step_category_id' => $categoryIds[$step[1]],
                    'position' => $index + 1,
                ];
            }
        }

        DB::table('step')->insert($records);
    }
}