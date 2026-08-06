<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            // User 1 (admin) - receptek 1-10
            ['title' => 'Gulyásleves',                  'description' => 'Hagyományos magyar gulyásleves marhahússal, burgonyával, sárgarépával és paprikával. A lassú főzésnek köszönhetően az ízek tökéletesen összeérnek.', 'creation_date' => '2024-01-15', 'user_id' => 1],
            ['title' => 'Csirkepörkölt',                'description' => 'Szaftos csirkepörkölt hagymás alapon, paprikával és paradicsommal. Hagyományos magyar étel, amely tökéletes nokedlivel vagy tarhonyával.', 'creation_date' => '2024-02-10', 'user_id' => 1],
            ['title' => 'Túrós csusza',                 'description' => 'Édes túrós csusza tejföllel és szalonnával. A házi készítésű tésztát gazdagon megkenjük túróval és megszórjuk ropogós szalonnadarabokkal.', 'creation_date' => '2024-03-05', 'user_id' => 1],
            ['title' => 'Rakott krumpli',               'description' => 'Réteges rakott burgonya tojással, kolbásszal és tejföllel. A sütőben aranybarnára sütve az egyik legnépszerűbb magyar egytálétel.', 'creation_date' => '2024-03-20', 'user_id' => 1],
            ['title' => 'Halászlé',                     'description' => 'Bajai halászlé vegyes halakból, paprikás alapon. Friss pontyból, harcsából és keszegből készül, tésztával tálalva.', 'creation_date' => '2024-04-12', 'user_id' => 1],
            ['title' => 'Lángos',                       'description' => 'Ropogós lángos tejföllel és reszelt sajttal. A kelt tésztából készült finomság forró olajban sül, majd gazdagon megkenik.', 'creation_date' => '2024-05-01', 'user_id' => 1],
            ['title' => 'Palacsinta',                   'description' => 'Vékony palacsinta kakaós, lekváros vagy túróval töltött változatban. A klasszikus desszert minden magyar család kedvence.', 'creation_date' => '2024-05-18', 'user_id' => 1],
            ['title' => 'Székelykáposzta',              'description' => 'Savanyú káposztás, sertéshúsos egytálétel tejföllel. A lassú főzés során az ízek tökéletesen összeérnek, igazi téli csemege.', 'creation_date' => '2024-06-08', 'user_id' => 1],
            ['title' => 'Paprikás csirke',              'description' => 'Tejfölös paprikás csirke nokedlivel. A csirkedarabokat paprikás hagymás alapon pároljuk puhára, majd tejfölös habarással sűrítjük.', 'creation_date' => '2024-07-02', 'user_id' => 1],
            ['title' => 'Meggyes pite',                 'description' => 'Omlós tésztájú meggyes pite fahéjjal. A friss meggyet cukorral és fahéjjal ízesítjük, majd rácsos tésztával borítjuk.', 'creation_date' => '2024-07-25', 'user_id' => 1],

            // User 2 - receptek 11-20
            ['title' => 'Bolognai spagetti',            'description' => 'Olasz stílusú darált húsos spagetti paradicsomos szósszal. Hosszan főzött mártás hagymával, sárgarépával és zellerrel.', 'creation_date' => '2024-08-10', 'user_id' => 2],
            ['title' => 'Csirkemell saláta',            'description' => 'Grillezett csirkemell friss zöldsalátával, paradicsommal és öntettel. Egészséges és könnyű ebéd vagy vacsora.', 'creation_date' => '2024-08-22', 'user_id' => 2],
            ['title' => 'Töltött paprika',              'description' => 'Darálthúsos töltött paprika paradicsomos szószban. A paprikákat rizses-húsos töltelékkel töltjük, majd paradicsomlében főzzük.', 'creation_date' => '2024-09-05', 'user_id' => 2],
            ['title' => 'Borsóleves',                   'description' => 'Krémes zöldborsóleves pirított kenyérkockákkal. Friss vagy mirelit borsóból készül, tejszínnel dúsítva.', 'creation_date' => '2024-09-18', 'user_id' => 2],
            ['title' => 'Rántott sajt',                 'description' => 'Ropogós panírozott sajt hasábburgonyával. A sajtszeleteket lisztbe, tojásba és zsemlemorzsába forgatjuk, majd aranybarnára sütjük.', 'creation_date' => '2024-10-01', 'user_id' => 2],
            ['title' => 'Zserbó',                       'description' => 'Diós-lekváros zserbó csokoládébevonattal. A vékony tésztarétegek közé diós töltelék és sárgabaracklekvár kerül.', 'creation_date' => '2024-10-15', 'user_id' => 2],
            ['title' => 'Fokhagymakrémleves',           'description' => 'Krémes fokhagymaleves pirított kenyérrel és sajttal. A fokhagymát lassan pároljuk, majd krémesre turmixoljuk.', 'creation_date' => '2024-11-02', 'user_id' => 2],
            ['title' => 'Marhapörkölt',                 'description' => 'Hagyományos marhapörkölt csipetkével. A marhahúst hagymás-paprikás alapon lassan puhára főzzük.', 'creation_date' => '2024-11-20', 'user_id' => 2],
            ['title' => 'Dobos torta',                  'description' => 'Klasszikus dobos torta karamellréteggel. Vékony lapok között vajkrém, a tetején roppanós karamell.', 'creation_date' => '2024-12-05', 'user_id' => 2],
            ['title' => 'Káposztás tészta',             'description' => 'Pirított káposztás metélttészta. Az apróra vágott káposztát zsíron pirítjuk, majd összekeverjük a főtt tésztával.', 'creation_date' => '2024-12-18', 'user_id' => 2],

            // User 3 - receptek 21-30
            ['title' => 'Sertésborda rántva',           'description' => 'Ropogósra rántott sertésborda citrommal. A hússzeleteket kiklopfoljuk, panírozzuk és bő olajban kisütjük.', 'creation_date' => '2025-01-08', 'user_id' => 3],
            ['title' => 'Paradicsomleves',              'description' => 'Tejfölös paradicsomleves bazsalikommal. A paradicsomot hagymával és fűszerekkel főzzük, majd simára turmixoljuk.', 'creation_date' => '2025-01-22', 'user_id' => 3],
            ['title' => 'Töltött káposzta',             'description' => 'Savanyú káposztába töltött darált hús rizzsel. A tölteléket füstölt hússal és kolbásszal együtt főzzük.', 'creation_date' => '2025-02-05', 'user_id' => 3],
            ['title' => 'Mákos guba',                   'description' => 'Édes mákos guba vaníliasodóval. A száraz kiflit tejjel áztatjuk, megszórjuk mákkal és cukorral.', 'creation_date' => '2025-02-20', 'user_id' => 3],
            ['title' => 'Zöldborsófőzelék',             'description' => 'Krémes zöldborsófőzelék rántással. A borsót hagymával és rántással sűrítjük, sült virslivel tálaljuk.', 'creation_date' => '2025-03-08', 'user_id' => 3],
            ['title' => 'Csirkepaprikás',               'description' => 'Erdélyi csirkepaprikás galuskával. A csirkét paprikás-tejfölös szószban főzzük, házi galuskával tálaljuk.', 'creation_date' => '2025-03-22', 'user_id' => 3],
            ['title' => 'Almás rétes',                  'description' => 'Házi almás rétes fahéjas töltelékkel. A vékony rétestésztát reszelt almával és dióval töltjük.', 'creation_date' => '2025-04-05', 'user_id' => 3],
            ['title' => 'Spenótfőzelék',                'description' => 'Krémes spenótfőzelék főtt tojással. A spenótot hagymával és fokhagymával pároljuk, tejszínnel dúsítjuk.', 'creation_date' => '2025-04-18', 'user_id' => 3],
            ['title' => 'Bakonyi sertésborda',          'description' => 'Gombás-tejfölös bakonyi sertésborda. A húst gombás szósszal borítjuk, sütőben sütjük készre.', 'creation_date' => '2025-05-02', 'user_id' => 3],
            ['title' => 'Krumplifőzelék',               'description' => 'Hagyományos krumplifőzelék rántással. A burgonyát sós vízben főzzük, rántással sűrítjük.', 'creation_date' => '2025-05-15', 'user_id' => 3],

            // User 4 - receptek 31-40
            ['title' => 'Gombapörkölt',                 'description' => 'Szaftos gombapörkölt tejföllel. A gombát hagymás-paprikás alapon pároljuk, tejföllel dúsítjuk.', 'creation_date' => '2025-06-01', 'user_id' => 4],
            ['title' => 'Túrógombóc',                   'description' => 'Édes túrógombóc tejföllel és cukorral. A túróból készült gombócokat zsemlemorzsába forgatjuk.', 'creation_date' => '2025-06-15', 'user_id' => 4],
            ['title' => 'Húsleves',                     'description' => 'Arany húsleves gazdag zöldségekkel és csigatésztával. A húst és zöldségeket lassan főzzük, hogy az ízek kioldódjanak.', 'creation_date' => '2025-06-28', 'user_id' => 4],
            ['title' => 'Rakott palacsinta',            'description' => 'Rakott palacsinta darált húsos töltelékkel. A palacsintákat húsos raguval rétegezzük, tejföllel és sajttal.', 'creation_date' => '2025-07-10', 'user_id' => 4],
            ['title' => 'Fasírt',                       'description' => 'Sütőben sült fasírt hagymás burgonyapürével. A darált húst tojással, fűszerekkel és zsemlemorzsával keverjük.', 'creation_date' => '2025-07-25', 'user_id' => 4],
            ['title' => 'Karfiolleves',                 'description' => 'Krémes karfiolleves sajttal. A karfiolt megfőzzük, turmixoljuk, majd sajttal és tejszínnel dúsítjuk.', 'creation_date' => '2025-08-05', 'user_id' => 4],
            ['title' => 'Töltött tojás',                'description' => 'Töltött tojás majonézes töltelékkel. A főtt tojások sárgáját mustárral és majonézzel keverjük.', 'creation_date' => '2025-08-20', 'user_id' => 4],
            ['title' => 'Sólet',                        'description' => 'Hagyományos sólet babbal és füstölt hússal. A babot és a húst együtt főzzük hagymával és fűszerekkel.', 'creation_date' => '2025-09-02', 'user_id' => 4],
            ['title' => 'Gyümölcsleves',                'description' => 'Hideg gyümölcsleves tejszínnel. Vegyes gyümölcsökből készült édes leves, amelyet hidegen tálalunk.', 'creation_date' => '2025-09-18', 'user_id' => 4],
            ['title' => 'Puliszka',                     'description' => 'Krémes puliszka sajttal és tejföllel. A kukoricadarát sós vízben főzzük sűrűre, sajttal megszórjuk.', 'creation_date' => '2025-10-01', 'user_id' => 4],

            // User 5 - receptek 41-50
            ['title' => 'Sertésszelet paradicsommal',   'description' => 'Sült sertésszelet paradicsomos szószban sajttal. A húst megsütjük, paradicsommal és reszelt sajttal borítjuk.', 'creation_date' => '2025-10-15', 'user_id' => 5],
            ['title' => 'Babgulyás',                    'description' => 'Kiadós babgulyás füstölt csülökkel. A babot és a húst együtt főzzük paprikás alapon.', 'creation_date' => '2025-10-28', 'user_id' => 5],
            ['title' => 'Kakaós csiga',                 'description' => 'Puha kakaós csiga cukormázzal. A kelt tésztát kakaóval és cukorral töltjük, felcsavarjuk és megsütjük.', 'creation_date' => '2025-11-10', 'user_id' => 5],
            ['title' => 'Savanyú krumplileves',         'description' => 'Savanykás krumplileves kolbásszal. A burgonyát ecetes lében főzzük füstölt hússal és kolbásszal.', 'creation_date' => '2025-11-22', 'user_id' => 5],
            ['title' => 'Rántott csirkemell',           'description' => 'Ropogós panírozott csirkemell citrommal. A húst lisztbe, tojásba és zsemlemorzsába forgatjuk.', 'creation_date' => '2025-12-05', 'user_id' => 5],
            ['title' => 'Brokkoli krémleves',           'description' => 'Egészséges brokkoli krémleves sajttal. A brokkolit megfőzzük, krémesre turmixoljuk, sajttal ízesítjük.', 'creation_date' => '2025-12-18', 'user_id' => 5],
            ['title' => 'Tarhonyás hús',                'description' => 'Hagyományos tarhonyás hús paprikás alapon. A tarhonyát pirítjuk, majd a pörkölttel együtt főzzük.', 'creation_date' => '2026-01-05', 'user_id' => 5],
            ['title' => 'Madártej',                     'description' => 'Habgaluskás madártej vaníliasodóval. A tojáshabot tejben főzzük ki, édes vaníliaszósszal tálaljuk.', 'creation_date' => '2026-01-20', 'user_id' => 5],
            ['title' => 'Csülkös bableves',             'description' => 'Gazdag bableves csülökkel és kolbásszal. A babot és csülköt együtt főzzük zöldségekkel.', 'creation_date' => '2026-02-03', 'user_id' => 5],
            ['title' => 'Lecsó',                        'description' => 'Hagyományos magyar lecsó paprikából és paradicsomból. Kolbásszal és tojással gazdagítva.', 'creation_date' => '2026-02-18', 'user_id' => 5],

            // User 6 - receptek 51-60
            ['title' => 'Burgonyafőzelék',              'description' => 'Sűrű burgonyafőzelék rántással és petrezselyemmel. A burgonyát főzzük, rántással sűrítjük.', 'creation_date' => '2026-03-05', 'user_id' => 6],
            ['title' => 'Csirkemell rolád',             'description' => 'Sajtos-sonkás csirkemell rolád. A csirkemellet kiklopfoljuk, sajttal és sonkával töltjük, feltekerjük.', 'creation_date' => '2026-03-18', 'user_id' => 6],
            ['title' => 'Paradicsomos csirkemell',      'description' => 'Paradicsomos szószban sült csirkemell sajttal. A húst paradicsommal és reszelt sajttal borítjuk.', 'creation_date' => '2026-04-01', 'user_id' => 6],
            ['title' => 'Sütőtök krémleves',            'description' => 'Őszi sütőtök krémleves pirított tökmaggal. A sütőtököt megsütjük, krémesre turmixoljuk.', 'creation_date' => '2026-04-15', 'user_id' => 6],
            ['title' => 'Rizses hús',                   'description' => 'Paprikás rizses hús zöldborsóval. A rizst és a húst együtt főzzük paprikás alapon.', 'creation_date' => '2026-04-28', 'user_id' => 6],
            ['title' => 'Málnás muffin',                'description' => 'Puha málnás muffin cukormázzal. A tésztába friss vagy fagyasztott málnát keverünk.', 'creation_date' => '2026-05-10', 'user_id' => 6],
            ['title' => 'Sárgaborsó főzelék',           'description' => 'Krémes sárgaborsó főzelék füstölt kolbásszal. A sárgaborsót puhára főzzük és összetörjük.', 'creation_date' => '2026-05-22', 'user_id' => 6],
            ['title' => 'Csokis brownie',               'description' => 'Sűrű, nedves csokoládés brownie dióval. A csokoládét és vajat megolvasztjuk, a tésztába diót keverünk.', 'creation_date' => '2026-06-05', 'user_id' => 6],
            ['title' => 'Kolbászos lecsós tészta',      'description' => 'Lecsóval és kolbásszal készült tésztaétel. A lecsót kolbásszal gazdagítjuk, tésztával tálaljuk.', 'creation_date' => '2026-06-18', 'user_id' => 6],
            ['title' => 'Zabkása',                      'description' => 'Gyümölcsös zabkása mézzel és dióval. A zabpelyhet tejjel főzzük, gyümölccsel és mézzel ízesítjük.', 'creation_date' => '2026-07-01', 'user_id' => 6],

            // User 7 - receptek 61-70
            ['title' => 'Sertésragu leves',             'description' => 'Gazdag sertésragu leves zöldségekkel. A sertéshúst hagymával és zöldségekkel főzzük.', 'creation_date' => '2024-01-20', 'user_id' => 7],
            ['title' => 'Csirkés Caesar saláta',        'description' => 'Grillezett csirkés Caesar saláta parmezánnal és krutonnal. Római saláta, parmezán és Caesar öntet.', 'creation_date' => '2024-02-15', 'user_id' => 7],
            ['title' => 'Rakott cukkini',               'description' => 'Rakott cukkini darált hússal és sajttal. A cukkinit rétegezzük hússal és sajttal, sütőben sütjük.', 'creation_date' => '2024-03-10', 'user_id' => 7],
            ['title' => 'Tárkonyos csirkeraguleves',    'description' => 'Tárkonyos csirkeraguleves zöldségekkel. A csirkét zöldségekkel és tárkonnyal főzzük.', 'creation_date' => '2024-04-05', 'user_id' => 7],
            ['title' => 'Görög saláta',                 'description' => 'Hagyományos görög saláta olívabogyóval és fetasajttal. Paradicsom, uborka, paprika és hagyma.', 'creation_date' => '2024-05-02', 'user_id' => 7],
            ['title' => 'Burgonyás pogácsa',            'description' => 'Puha burgonyás pogácsa sajttal. A burgonyát összetörjük, tésztába gyúrjuk és kisütjük.', 'creation_date' => '2024-05-25', 'user_id' => 7],
            ['title' => 'Spenótos-tejfölös tészta',    'description' => 'Spenótos-tejfölös penne tészta. A spenótot tejszínnel és tejföllel keverjük, tésztával tálaljuk.', 'creation_date' => '2024-06-15', 'user_id' => 7],
            ['title' => 'Céklaleves',                   'description' => 'Színes céklaleves tejszínnel. A céklát megfőzzük, krémesre turmixoljuk, tejszínnel tálaljuk.', 'creation_date' => '2024-07-08', 'user_id' => 7],
            ['title' => 'Mártásos csirkemell',          'description' => 'Gombás-tejszínes mártásos csirkemell. A csirkét gombás tejszínes szósszal borítjuk.', 'creation_date' => '2024-08-02', 'user_id' => 7],
            ['title' => 'Diós kalács',                  'description' => 'Ünnepi diós kalács élesztős tésztából. A tésztát diós töltelékkel töltjük és felcsavarjuk.', 'creation_date' => '2024-09-12', 'user_id' => 7],

            // User 8 - receptek 71-80
            ['title' => 'Zöldséges csirke stir fry',    'description' => 'Gyors zöldséges csirke wokban sütve. A csirkét és zöldségeket magas hőfokon pirítjuk.', 'creation_date' => '2024-10-05', 'user_id' => 8],
            ['title' => 'Paradicsomos bab',             'description' => 'Fűszeres paradicsomos bab kolbásszal. A babot paradicsomos szószban főzzük kolbásszal.', 'creation_date' => '2024-10-25', 'user_id' => 8],
            ['title' => 'Sajtos-tejfölös melegszendvics','description' => 'Sütőben sült sajtos-tejfölös melegszendvics. A kenyérre tejfölös-sajtos keveréket kenünk.', 'creation_date' => '2024-11-12', 'user_id' => 8],
            ['title' => 'Zöldségkrémleves',             'description' => 'Vegyes zöldségkrémleves pirított kenyérrel. Sárgarépa, burgonya és zeller krémesre turmixolva.', 'creation_date' => '2024-12-01', 'user_id' => 8],
            ['title' => 'Csirkés wrap',                 'description' => 'Grillezett csirkés wrap zöldségekkel. A tortillába csirkét, salátát és öntetet teszünk.', 'creation_date' => '2024-12-20', 'user_id' => 8],
            ['title' => 'Krumplis tészta',              'description' => 'Pirított krumplis metélttészta hagymával. A burgonyát pirítjuk, tésztával keverjük.', 'creation_date' => '2025-01-10', 'user_id' => 8],
            ['title' => 'Csokoládé torta',              'description' => 'Gazdag csokoládé torta csokoládékrémmel. A tésztába kakaót és olvasztott csokoládét keverünk.', 'creation_date' => '2025-02-08', 'user_id' => 8],
            ['title' => 'Zöldséges lasagne',            'description' => 'Zöldséges lasagne ricottával és sajttal. A lasagne lapokat zöldséges raguval és sajttal rétegezzük.', 'creation_date' => '2025-03-05', 'user_id' => 8],
            ['title' => 'Chilis bab',                   'description' => 'Fűszeres chilis bab darált hússal. A babot és húst chilivel és fűszerekkel főzzük.', 'creation_date' => '2025-04-02', 'user_id' => 8],
            ['title' => 'Túrós palacsinta',             'description' => 'Édes túróval töltött palacsinta tejföllel. A palacsintákat édes túróval töltjük és megsütjük.', 'creation_date' => '2025-05-01', 'user_id' => 8],

            // User 9 - receptek 81-90
            ['title' => 'Borsos tokány',                'description' => 'Fekete borsos sertés tokány tejszínnel. A húst vastag szeletekre vágjuk, borssal és tejszínnel főzzük.', 'creation_date' => '2025-05-20', 'user_id' => 9],
            ['title' => 'Sütőben sült csirkecomb',      'description' => 'Ropogósra sült csirkecomb fűszerekkel. A combokat fűszerezzük és sütőben aranybarnára sütjük.', 'creation_date' => '2025-06-10', 'user_id' => 9],
            ['title' => 'Karfiol gratin',               'description' => 'Sajtos karifol gratin tejszínnel. A karifolt sajtos tejszínes szósszal borítjuk és megsütjük.', 'creation_date' => '2025-07-05', 'user_id' => 9],
            ['title' => 'Burgonyaleves',                'description' => 'Krémes burgonyaleves szalonnával. A burgonyát főzzük, krémesre turmixoljuk, szalonnával tálaljuk.', 'creation_date' => '2025-07-28', 'user_id' => 9],
            ['title' => 'Töltött cukkini',              'description' => 'Darált hússal töltött cukkini sajttal. A cukkinit kivájjuk, hússal töltjük és megsütjük.', 'creation_date' => '2025-08-15', 'user_id' => 9],
            ['title' => 'Gyros tál',                    'description' => 'Házilag készített gyros tál csirkéből. A csirkét fűszeres szósszal pácoljuk és megsütjük.', 'creation_date' => '2025-09-08', 'user_id' => 9],
            ['title' => 'Vanília puding',               'description' => 'Házi vanília puding tejszínhabbal. A tejet vaníliával és cukorral főzzük, keményítővel sűrítjük.', 'creation_date' => '2025-10-02', 'user_id' => 9],
            ['title' => 'Csirkés quesadilla',           'description' => 'Sajtos-csirkés quesadilla. A tortillába csirkét és sajtot teszünk, serpenyőben megsütjük.', 'creation_date' => '2025-10-25', 'user_id' => 9],
            ['title' => 'Paradicsomos tészta',          'description' => 'Egyszerű paradicsomos tészta bazsalikommal. A paradicsomot fokhagymával és bazsalikommal főzzük.', 'creation_date' => '2025-11-15', 'user_id' => 9],
            ['title' => 'Diós sütemény',                'description' => 'Omlós diós sütemény porcukorral. A tésztába darált diót keverünk, sütőben kisütjük.', 'creation_date' => '2025-12-08', 'user_id' => 9],

            // User 10 - receptek 91-100
            ['title' => 'Sertésszűz pecsenye',          'description' => 'Sütőben sült sertésszűz fűszerekkel. A húst fűszerezzük és sütőben lassan megsütjük.', 'creation_date' => '2026-01-02', 'user_id' => 10],
            ['title' => 'Zöldborsós rizs',              'description' => 'Zöldborsós rizs hagymával. A rizst hagymán pirítjuk, zöldborsóval és vízzel főzzük.', 'creation_date' => '2026-01-22', 'user_id' => 10],
            ['title' => 'Tojásos nokedli',              'description' => 'Tojásos nokedli tejföllel. A nokedlit tojással és tejföllel keverjük össze.', 'creation_date' => '2026-02-10', 'user_id' => 10],
            ['title' => 'Sajtos pogácsa',               'description' => 'Kelt tésztás sajtos pogácsa. A tésztát reszelt sajttal dagasztjuk és kisütjük.', 'creation_date' => '2026-03-01', 'user_id' => 10],
            ['title' => 'Csirke curry',                 'description' => 'Krémes csirke curry rizzsel. A csirkét curry fűszerrel és tejszínnel főzzük.', 'creation_date' => '2026-03-20', 'user_id' => 10],
            ['title' => 'Meggyleves',                   'description' => 'Hideg édes meggyleves tejszínnel. A meggyet cukorral és fahéjjal főzzük, hidegen tálaljuk.', 'creation_date' => '2026-04-10', 'user_id' => 10],
            ['title' => 'Sajtos makaróni',              'description' => 'Sütőben sült sajtos makaróni. A makarónit sajtos szósszal leöntjük és megsütjük.', 'creation_date' => '2026-05-02', 'user_id' => 10],
            ['title' => 'Hagymás rostélyos',            'description' => 'Hagymás rostélyos serpenyőben sütve. A húst hagymás alapon pirítjuk, fűszerezzük.', 'creation_date' => '2026-05-22', 'user_id' => 10],
            ['title' => 'Epres tiramisu',               'description' => 'Epres tiramisu mascarponéval. A piskótát kávéba áztatjuk, eperrel és krémmel rétegezzük.', 'creation_date' => '2026-06-12', 'user_id' => 10],
            ['title' => 'Zöldséges omlett',             'description' => 'Zöldséges omlett sajttal. A tojásba paprikát, paradicsomot és sajtot keverünk.', 'creation_date' => '2026-07-01', 'user_id' => 10],
        ];

        foreach ($recipes as $recipe) {
            $recipe['created_at'] = $recipe['creation_date'];
            $recipe['updated_at'] = $recipe['creation_date'];
            DB::table('recipe')->insert($recipe);
        }
    }
}