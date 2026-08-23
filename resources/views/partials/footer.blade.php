<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h4>Elérhetőség</h4>
            <p>📧 info@kukta.hu</p>
        </div>
        <div class="footer-section">
            <h4>Információk</h4>
            <ul>
                <li><a href="{{ route('page.privacy') }}">Adatkezelési tájékoztató</a></li>
                <li><a href="{{ route('page.cookies') }}">Süti kezelés</a></li>
                <li><a href="{{ route('page.terms') }}">Általános szerződési feltételek</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Kukta - Minden jog fenntartva</p>
    </div>
</footer>