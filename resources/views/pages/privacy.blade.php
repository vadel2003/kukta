@extends('layouts.app')

@section('title', 'Adatkezelési tájékoztató')

@section('content')
    <section class="page-section">
        <div class="card-stack">
            <div class="content-card">
                <h1>Adatkezelési tájékoztató</h1>
            </div>
            <div class="content-card legal-text">
                <p class="legal-meta">Hatályos: 2026. október 2-től</p>

                <p>
                    Ez a tájékoztató leírja, hogy a Kukta receptoldal (a továbbiakban: Oldal) milyen személyes
                    adatokat kezel, milyen célból, mennyi ideig, és milyen jogaid vannak ezekkel kapcsolatban.
                    A tájékoztató az Európai Unió általános adatvédelmi rendelete (GDPR, 2016/679/EU rendelet)
                    és az információs önrendelkezési jogról szóló 2011. évi CXII. törvény (Infotv.) alapján készült.
                </p>

                <h2>1. Az adatkezelő</h2>
                <ul>
                    <li>Név: [Üzemeltető neve]</li>
                    <li>Postacím: [Postacím]</li>
                    <li>E-mail: <a href="mailto:info@kukta.hu">info@kukta.hu</a></li>
                </ul>
                <p>Adatvédelmi kérdésekben a fenti e-mail címen tudsz kapcsolatba lépni velünk.</p>

                <h2>2. Milyen adatokat kezelünk, és miért?</h2>

                <h3>2.1. Regisztráció és felhasználói fiók</h3>
                <ul>
                    <li><strong>Adatok:</strong> felhasználónév, e-mail cím, jelszó (csak titkosított, visszafejthetetlen formában tároljuk), felhasználói szerepkör.</li>
                    <li><strong>Cél:</strong> a fiók létrehozása, a bejelentkezés és a regisztrált felhasználóknak szóló funkciók (recept feltöltése, kedvencek, értékelés) biztosítása.</li>
                    <li><strong>Jogalap:</strong> szerződés teljesítése – a regisztrációval elfogadott <a href="{{ route('page.terms') }}">Általános szerződési feltételek</a> szerinti szolgáltatás nyújtása (GDPR 6. cikk (1) b) pont).</li>
                    <li><strong>Időtartam:</strong> a fiók törléséig.</li>
                </ul>

                <h3>2.2. Profilkép</h3>
                <ul>
                    <li><strong>Adat:</strong> az általad feltöltött profilkép (megadása nem kötelező).</li>
                    <li><strong>Cél:</strong> a profilod megjelenítése az Oldalon.</li>
                    <li><strong>Jogalap:</strong> szerződés teljesítése (GDPR 6. cikk (1) b) pont).</li>
                    <li><strong>Időtartam:</strong> amíg le nem cseréled, vagy a fiók törléséig.</li>
                </ul>

                <h3>2.3. Feltöltött receptek, kedvencek és értékelések</h3>
                <ul>
                    <li><strong>Adatok:</strong> az általad feltöltött receptek (szöveg, képek), a kedvencnek jelölt receptek listája és a receptekre adott pontszámaid.</li>
                    <li><strong>Cél:</strong> a receptek megjelenítése, a kedvencek és az értékelések kezelése.</li>
                    <li><strong>Jogalap:</strong> szerződés teljesítése (GDPR 6. cikk (1) b) pont).</li>
                    <li>
                        <strong>Időtartam:</strong> a kedvenceket és az értékeléseket a fiók törlésekor töröljük.
                        A feltöltött recepteket a fiók törlése után is megtartjuk, de <strong>névtelenül</strong>:
                        a recept és a fiókod közötti kapcsolatot töröljük, így a recept többé nem köthető hozzád.
                        Ha a receptjeidet is törölni szeretnéd, a fiók törlése előtt egyenként törölheted őket,
                        vagy kérheted ezt tőlünk e-mailben.
                    </li>
                </ul>

                <h3>2.4. Munkamenet és biztonság</h3>
                <ul>
                    <li><strong>Adatok:</strong> IP-cím, böngésző típusa (user agent), az utolsó aktivitás időpontja, a munkamenet azonosítója.</li>
                    <li><strong>Cél:</strong> a bejelentkezés fenntartása oldalváltások között, valamint az Oldal védelme visszaélések és támadások ellen.</li>
                    <li><strong>Jogalap:</strong> jogos érdek – az Oldal biztonságos működése (GDPR 6. cikk (1) f) pont).</li>
                    <li><strong>Időtartam:</strong> a munkamenet lejárata (120 perc inaktivitás) után automatikusan törlődik.</li>
                </ul>
                <p>
                    A munkamenethez használt sütikről a <a href="{{ route('page.cookies') }}">Süti tájékoztatóban</a> olvashatsz bővebben.
                </p>

                <h2>3. Kik férnek hozzá az adatokhoz?</h2>
                <p>
                    Az adatokhoz az Oldal üzemeltetője és adminisztrátorai férnek hozzá, kizárólag a fenti célokhoz
                    szükséges mértékben. A felhasználóneved, a profilképed és a feltöltött receptjeid az Oldal
                    látogatói számára nyilvánosan láthatók. Az e-mail címedet és a jelszavadat nem tesszük közzé.
                </p>
                <p>
                    Az adatokat az Oldal tárhelyszolgáltatójának szerverein tároljuk, aki adatfeldolgozóként
                    kizárólag a tárolást végzi, az adatokat más célra nem használhatja:
                </p>
                <ul>
                    <li>[Tárhelyszolgáltató neve, székhelye, e-mail címe]</li>
                </ul>
                <p>
                    Az adatokat nem adjuk el, nem adjuk át harmadik félnek marketing célra, és nem továbbítjuk
                    az Európai Unión kívülre. Az Oldal nem használ külső analitikai, hirdetési vagy közösségi
                    média szolgáltatást, és minden fájlt (betűtípusokat, scripteket) a saját szerveréről tölt be.
                </p>

                <h2>4. Az adatok biztonsága</h2>
                <p>
                    A jelszavakat visszafejthetetlen (hash-elt) formában tároljuk, így azokat mi sem ismerjük.
                    Az űrlapokat CSRF-védelem óvja a jogosulatlan beküldéstől. Az adatbázishoz csak az
                    üzemeltető fér hozzá.
                </p>

                <h2>5. A jogaid</h2>
                <p>A GDPR alapján a következő jogok illetnek meg:</p>
                <ul>
                    <li><strong>Hozzáférés:</strong> tájékoztatást kérhetsz arról, milyen adatokat kezelünk rólad.</li>
                    <li><strong>Helyesbítés:</strong> a felhasználónevedet, az e-mail címedet és a profilképedet a Profil oldalon bármikor módosíthatod.</li>
                    <li><strong>Törlés:</strong> a fiókodat a Profil oldalon bármikor törölheted.</li>
                    <li><strong>Korlátozás:</strong> kérheted, hogy bizonyos esetekben csak tároljuk, de ne használjuk az adataidat.</li>
                    <li><strong>Adathordozhatóság:</strong> kérheted, hogy az általad megadott adatokat géppel olvasható formában kiadjuk.</li>
                    <li><strong>Tiltakozás:</strong> a jogos érdeken alapuló adatkezelés ellen tiltakozhatsz.</li>
                </ul>
                <p>
                    Kérésedet az <a href="mailto:info@kukta.hu">info@kukta.hu</a> címre küldheted. Legfeljebb
                    egy hónapon belül válaszolunk.
                </p>

                <h2>6. Jogorvoslat</h2>
                <p>Ha úgy érzed, hogy megsértettük az adatvédelmi jogaidat, panaszt tehetsz a felügyeleti hatóságnál:</p>
                <ul>
                    <li>Nemzeti Adatvédelmi és Információszabadság Hatóság (NAIH)</li>
                    <li>Cím: 1055 Budapest, Falk Miksa utca 9-11.</li>
                    <li>Postacím: 1363 Budapest, Pf. 9.</li>
                    <li>Telefon: +36 1 391 1400</li>
                    <li>E-mail: <a href="mailto:ugyfelszolgalat@naih.hu">ugyfelszolgalat@naih.hu</a></li>
                    <li>Honlap: <a href="https://www.naih.hu" target="_blank" rel="noopener">www.naih.hu</a></li>
                </ul>
                <p>
                    Emellett bírósághoz is fordulhatsz. A pert – választásod szerint – a lakóhelyed vagy a
                    tartózkodási helyed szerint illetékes törvényszék előtt is megindíthatod.
                </p>

                <h2>7. A tájékoztató módosítása</h2>
                <p>
                    Ha az Oldal működése megváltozik (például új funkció kerül be), ezt a tájékoztatót is
                    frissítjük. A mindenkori hatályos változat ezen az oldalon érhető el.
                </p>
            </div>
        </div>
    </section>
@endsection
