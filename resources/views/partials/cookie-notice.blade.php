{{-- Cookie notice bar. Shown until the visitor clicks the OK button
     (cookie_notice_seen cookie, kept for 1 year). --}}
<div id="cookieNotice" class="cookie-notice" hidden>
    <p>
        Az oldal használatával elfogadod a <a href="{{ route('page.cookies') }}">Süti tájékoztatóban</a> foglaltakat.
    </p>
    <button type="button" class="btn-cookie-ok">Rendben</button>
</div>

<script>
    if (!document.cookie.includes('cookie_notice_seen=1')) {
        const cookieNotice = document.getElementById('cookieNotice');
        cookieNotice.hidden = false;

        cookieNotice.querySelector('.btn-cookie-ok').addEventListener('click', () => {
            document.cookie = 'cookie_notice_seen=1; max-age=31536000; path=/; SameSite=Lax';
            cookieNotice.hidden = true;
        });
    }
</script>
