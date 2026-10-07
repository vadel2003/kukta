@extends('layouts.app')

@section('title', 'Általános szerződési feltételek')

@section('content')
    <section class="page-section">
        <div class="card-stack">
            <div>
                <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
                <h1>Általános szerződési feltételek</h1>
            </div>
            <div class="content-card legal-text">
                <p class="legal-meta">Hatályos: 2026. október 2-től</p>

                <p>
                    Ez a dokumentum a Kukta receptoldal (a továbbiakban: Oldal) használatának feltételeit
                    tartalmazza. Az Oldal használatával, illetve a regisztrációval elfogadod ezeket a feltételeket.
                </p>

                <h2>1. Az üzemeltető</h2>
                <p>
                    Az Oldal üzemeltetőjének adatai az
                    <a href="{{ route('page.imprint') }}">Impresszumban</a> találhatók.
                </p>

                <h2>2. A szolgáltatás</h2>
                <p>
                    A Kukta egy ingyenes receptoldal. Regisztráció nélkül is böngészheted és keresheted a
                    recepteket, és használhatod a lépésről lépésre vezető főzési asszisztenst. Regisztrált
                    felhasználóként ezen felül saját receptet tölthetsz fel, recepteket menthetsz a kedvenceid
                    közé, és értékelheted őket. A szolgáltatás használata díjmentes.
                </p>

                <h2>3. Regisztráció és felhasználói fiók</h2>
                <ul>
                    <li>Regisztrálni a 16. életévét betöltött személy, vagy 16 év alatti személy a szülője (törvényes képviselője) hozzájárulásával tud.</li>
                    <li>A regisztrációhoz valós, működő e-mail címet kell megadnod.</li>
                    <li>A jelszavad titokban tartása a te felelősséged. Ha úgy gondolod, hogy más hozzáfért a fiókodhoz, változtasd meg a jelszavadat, és értesíts minket.</li>
                    <li>A felhasználónév nem lehet sértő, megtévesztő, és nem sértheti más jogait (például nem lehet más személy vagy márka neve).</li>
                    <li>A fiókodat a Profil oldalon bármikor törölheted.</li>
                </ul>

                <h2>4. A feltöltött tartalmak</h2>
                <p>
                    A recept feltöltésével kijelented, hogy a recept szövege és a feltöltött képek a saját
                    alkotásod, vagy jogosult vagy a felhasználásukra. Különösen fontos, hogy más weboldalról
                    letöltött fényképet engedély nélkül ne tölts fel.
                </p>
                <p>
                    A feltöltött tartalmak szerzői joga nálad marad. A feltöltéssel díjmentes, nem kizárólagos,
                    időbeli korlátozás nélküli engedélyt adsz az üzemeltetőnek arra, hogy a tartalmat az Oldalon
                    megjelenítse. Ez az engedély a fiókod törlése után is fennmarad: a receptjeid névtelenül az
                    Oldalon maradnak, hacsak a fiók törlése előtt nem törlöd őket, vagy nem kéred tőlünk a törlésüket.
                </p>
                <p>Tilos olyan tartalmat feltölteni, amely:</p>
                <ul>
                    <li>jogszabályba ütközik, vagy mások jogait (például szerzői jogát, személyiségi jogát) sérti;</li>
                    <li>sértő, gyűlöletkeltő, erőszakos vagy szexuális jellegű;</li>
                    <li>reklámot, kéretlen hirdetést vagy más weboldalra mutató hivatkozást tartalmaz;</li>
                    <li>nem receptet tartalmaz, vagy szándékosan félrevezető (például veszélyes elkészítési módot ír le).</li>
                </ul>
                <p>
                    Az üzemeltető jogosult az ezeket a szabályokat sértő tartalmakat előzetes értesítés nélkül
                    törölni, ismételt vagy súlyos szabályszegés esetén pedig a felhasználó fiókját törölni.
                    Ha olyan tartalmat látsz, amely szerinted sérti a szabályokat, jelezd az
                    <a href="mailto:info@kukta.hu">info@kukta.hu</a> címen.
                </p>

                <h2>5. Felelősség a receptekért</h2>
                <p>
                    A receptek egy részét a felhasználók töltik fel, és ezek pontosságát az üzemeltető nem
                    ellenőrzi. A receptek, az elkészítési idők és a nehézségi szintek tájékoztató jellegűek.
                </p>
                <p>
                    <strong>Allergének és étrendek:</strong> az Oldalon szereplő allergén- és étrend-jelölések
                    (például „gluténmentes”, „vegán”) tájékoztató jellegűek, és hibásak vagy hiányosak lehetnek.
                    Ha ételallergiád vagy ételintoleranciád van, vagy speciális étrendet követsz, minden esetben
                    ellenőrizd a felhasznált alapanyagok összetételét a termékek csomagolásán.
                </p>
                <p>
                    Főzés közben a szokásos konyhai óvintézkedéseket (például a hús megfelelő átsütését, a forró
                    edények óvatos kezelését) mindig tartsd be. Az üzemeltető nem felel a receptek követéséből
                    eredő károkért.
                </p>

                <h2>6. Az Oldal elérhetősége</h2>
                <p>
                    Az üzemeltető törekszik az Oldal folyamatos működésére, de nem garantálja, hogy az Oldal
                    mindig hibamentesen és megszakítás nélkül elérhető. Az üzemeltető jogosult az Oldal
                    funkcióit módosítani, vagy a szolgáltatást megszüntetni.
                </p>

                <h2>7. Szellemi tulajdon</h2>
                <p>
                    Az Oldal arculata, logója, grafikai elemei, animációi és saját készítésű tartalmai az
                    üzemeltető szellemi tulajdonát képezik, ezeket az üzemeltető engedélye nélkül nem lehet
                    másolni vagy más oldalon felhasználni.
                </p>

                <h2>8. Adatkezelés</h2>
                <p>
                    A személyes adataid kezeléséről az <a href="{{ route('page.privacy') }}">Adatkezelési
                    tájékoztató</a>, a sütikről a <a href="{{ route('page.cookies') }}">Süti tájékoztató</a> szól.
                </p>

                <h2>9. A feltételek módosítása</h2>
                <p>
                    Az üzemeltető jogosult ezeket a feltételeket módosítani. A módosításról az Oldalon adunk
                    tájékoztatást. Ha a módosítás után is használod az Oldalt, azzal elfogadod az új feltételeket.
                </p>

                <h2>10. Irányadó jog</h2>
                <p>
                    Ezekre a feltételekre a magyar jog az irányadó. Vitás kérdésekben elsősorban békés úton,
                    egyeztetéssel próbálunk megoldást találni.
                </p>
            </div>
        </div>
    </section>
@endsection
