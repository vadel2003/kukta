{{-- Cookie notice bar. Shown until the visitor clicks the OK button
     (the server sets the cookie_notice_seen cookie for 1 year). --}}
@if (!request()->cookie('cookie_notice_seen'))
    <form method="POST" action="{{ route('page.cookies.accept') }}" class="cookie-notice">
        @csrf
        <p>
            Az oldal használatával elfogadod a <a href="{{ route('page.cookies') }}">Süti tájékoztatóban</a> foglaltakat.
        </p>
        <button type="submit" class="btn-cookie-ok">Rendben</button>
    </form>
@endif
