<!-- ===============//footer section start here \\================= -->
<footer class="footer-section light-version">
    <div class="footer-top" style="background-image: url({{ asset('assets-user/images/footer/bg-light.jpg') }});">
        <div class="footer-links" style="padding: 30px;">
            <div class="container">
                <div class="footer-link-item">
                    <ul class="footer-link-list d-flex flex-wrap gap-3 p-0 m-0 list-unstyled">
                        <h5>Menu</h5>
                        <li><a href="{{ route('masyarakat.dashboard') }}" class="footer-link">Dashboard</a></li>
                        <li><a href="{{ route('masyarakat.lelang') ?? '#' }}" class="footer-link">Lelang</a></li>
                        <li><a href="{{ route('masyarakat.history') ?? '#' }}" class="footer-link">Riwayat</a></li>
                        <li><a href="{{ route('masyarakat.tentang') ?? '#' }}" class="footer-link">Tentang</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="text-center py-4 mb-0">All rights reserved &copy; La-Lelang || Design By: Zidan ft. codexder</p>
        </div>
    </div>
</footer>
<!-- ===============//footer section end here \\================= -->
