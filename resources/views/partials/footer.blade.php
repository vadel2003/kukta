<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h4>Elérhetőség</h4>
            <p><a href="mailto:info@kukta.hu"><i data-lucide="mail" class="footer-icon"></i> info@kukta.hu</a></p>
        </div>
        {{-- nav + aria-label: a képernyőolvasó külön navigációs területként ismeri fel --}}
        <nav class="footer-section" aria-label="Jogi információk">
            <h4>Információk</h4>
            <ul>
                <li><a href="{{ route('page.imprint') }}">Impresszum</a></li>
                <li><a href="{{ route('page.terms') }}">Általános szerződési feltételek</a></li>
                <li><a href="{{ route('page.privacy') }}">Adatkezelési tájékoztató</a></li>
                <li><a href="{{ route('page.cookies') }}">Süti tájékoztató</a></li>
            </ul>
        </nav>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Kukta</p>
    </div>
</footer>
