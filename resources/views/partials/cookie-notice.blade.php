{{-- Süti tájékoztató sáv. Az oldal csak a működéshez szükséges sütiket használja, ezekhez
     a törvény nem kér beleegyezést, csak tájékoztatást - ezért elég egyetlen "Rendben" gomb.
     Alapból rejtett (hidden), és a lenti JS csak akkor mutatja meg, ha a látogató még
     nem nyomta meg a gombot (azaz nincs meg a cookie_notice_seen süti). --}}
<div id="cookieNotice" class="cookie-notice" hidden>
    <p>
        Az oldal csak a működéshez szükséges sütiket használja (pl. bejelentkezés, biztonság).
        Részletek: <a href="{{ route('page.cookies') }}">Süti tájékoztató</a> ·
        <a href="{{ route('page.privacy') }}">Adatkezelési tájékoztató</a>
    </p>
    <button type="button" class="btn-cookie-ok">Rendben</button>
</div>

<script>
    (function () {
        const notice = document.getElementById('cookieNotice');

        // document.cookie az összes süti egy szövegben: "a=1; b=2" - ebben keressük a miénket
        if (document.cookie.includes('cookie_notice_seen=1')) return;

        notice.hidden = false;

        notice.querySelector('.btn-cookie-ok').addEventListener('click', function () {
            // 1 évig (másodpercben) emlékszik rá a böngésző, path=/ -> az egész oldalon érvényes
            document.cookie = 'cookie_notice_seen=1; max-age=31536000; path=/; SameSite=Lax';
            notice.hidden = true;
        });
    })();
</script>
