<!-- ===============// header section start here \\================= -->
<header class="header light-version">
    <div class="container-fluid">
        <div class="header__content">
            <div class="header__logo">
                <a href="{{ route('masyarakat.dashboard') }}">
                    <img src="{{ asset('assets-user/images/logo/lalelang.png') }}"
                        style="max-width: 70px; max-height: 100px;" alt="logo" />
                </a>
            </div>

            <div class="header__menu ms-auto">
                <ul class="header__nav mb-0">
                    <li class="header__nav-item"><a href="{{ route('masyarakat.dashboard') }}"
                            class="header__nav-link">Beranda</a></li>
                    <li class="header__nav-item"><a href="{{ route('masyarakat.lelang') }}"
                            class="header__nav-link">Lelang</a></li>
                    <li class="header__nav-item"><a href="{{ route('masyarakat.history') }}"
                            class="header__nav-link">Riwayat</a></li>
                    <li class="header__nav-item"><a href="{{ route('masyarakat.tentang') }}"
                            class="header__nav-link">Tentang</a></li>
                </ul>
            </div>

            <div class="header__actions">
                <div class="header__action header__action--profile">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-offset="-100,10">
                            <span data-blast="bgColor"><i class="icofont-user"></i></span>
                            <span
                                class="d-none d-md-inline">{{ auth()->guard('masyarakat')->user()->nama_lengkap ?? 'User' }}</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('masyarakat.profile') }}"><i
                                        class="icofont-options me-1"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('masyarakat.history') }}"><i
                                        class="icofont-lightning-ray me-1"></i> Riwayat</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('masyarakat.logout') }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="icofont-logout me-1"></i>
                                        Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <button class="menu-trigger header__btn" id="menu05">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>
<!-- ===============//header section end here \\================= -->
