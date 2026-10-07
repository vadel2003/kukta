@extends('layouts.app')

@section('title', 'Süti tájékoztató')

@section('content')
    <section class="page-section">
        <div class="card-stack">
            <div>
                <a href="{{ route('home') }}" class="back-link"><i data-lucide="arrow-left"></i> Vissza a főoldalra</a>
                <h1>Süti tájékoztató</h1>
            </div>
            <div class="content-card legal-text">
                <p class="legal-meta">Hatályos: 2026. október 2-től</p>

                <h2>Mi az a süti?</h2>
                <p>
                    A süti (cookie) egy kis szöveges fájl, amelyet a weboldal a böngésződben tárol. Segítségével
                    az oldal például „emlékszik” rá, hogy be vagy jelentkezve, amíg egyik oldalról a másikra lépsz.
                </p>

                <h2>Milyen sütiket használ a Kukta?</h2>
                <p>
                    A Kukta <strong>kizárólag az oldal működéséhez feltétlenül szükséges sütiket</strong> használja.
                    Nem használunk analitikai (látogatottság-mérő), hirdetési vagy közösségi média sütiket, és
                    harmadik fél sem helyez el sütit az oldalon keresztül.
                </p>

                <div class="legal-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Név</th>
                                <th>Mire való?</th>
                                <th>Meddig él?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>kukta-session</td>
                                <td>A munkamenet azonosítója: ez tartja fenn a bejelentkezést oldalváltások között.</td>
                                <td>120 perc inaktivitás után lejár</td>
                            </tr>
                            <tr>
                                <td>XSRF-TOKEN</td>
                                <td>Biztonsági süti: megakadályozza, hogy egy idegen oldal a nevedben küldjön be űrlapot (CSRF-védelem).</td>
                                <td>120 perc inaktivitás után lejár</td>
                            </tr>
                            <tr>
                                <td>cookie_notice_seen</td>
                                <td>Megjegyzi, hogy a süti tájékoztató sávot már bezártad, így nem jelenik meg újra.</td>
                                <td>1 év</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>Kell-e hozzá a beleegyezésed?</h2>
                <p>
                    Nem. A feltétlenül szükséges sütik nélkül az oldal nem tudna működni (például nem tudnál
                    bejelentkezni), ezért az uniós ePrivacy irányelv (2002/58/EK) 5. cikk (3) bekezdése és az
                    azt átültető magyar elektronikus hírközlési szabályok alapján ezekhez nem kell
                    hozzájárulás, csak tájékoztatás. Ezt a célt szolgálja az oldal alján megjelenő sáv is.
                </p>

                <h2>Hogyan törölheted a sütiket?</h2>
                <p>
                    A sütiket a böngésződ beállításaiban bármikor törölheted vagy letilthatod. Ha a szükséges
                    sütiket letiltod, a bejelentkezés és az űrlapok beküldése nem fog működni, a receptek
                    böngészése viszont továbbra is lehetséges.
                </p>

                <h2>További információ</h2>
                <p>
                    A munkamenet során kezelt személyes adatokról (például az IP-címről) az
                    <a href="{{ route('page.privacy') }}">Adatkezelési tájékoztatóban</a> olvashatsz.
                    Kérdés esetén írj nekünk: <a href="mailto:info@kukta.hu">info@kukta.hu</a>.
                </p>
            </div>
        </div>
    </section>
@endsection
