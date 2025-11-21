<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header" style="display: flex; align-items: center; padding: 20px; border-bottom: 1px solid #ddd;">
        <div style="margin-right: 15px;">
            <img src="{{ asset('assets/images/lelang.gif') }}" class="logo-icon" alt="logo icon"
                style="width: 40px; height: auto;">
        </div>
        <div style="display: flex; flex-direction: column;">
            <h4 class="logo-text" style="font-size: 20px; font-weight: bold; margin: 0;">La-Lelang</h4>
            <small class="logo-text" style="font-size: 6px; margin-top: 5px;">Powered by Zean</small>
        </div>
    </div>

    <ul class="metismenu" id="menu">
        <!-- BERANDA -->
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                <div class="parent-icon">
                    <img src="{{ asset('assets/icons/home-outline.svg') }}" width="20" height="20"
                        alt="Beranda">
                </div>
                <div class="menu-title">Beranda</div>
            </a>
        </li>

        <!-- DATA -->
        <li class="menu-label">Data</li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <img src="{{ asset('assets/icons/apps-outline.svg') }}" width="20" height="20"
                        alt="Data">
                </div>
                <div class="menu-title">Master Data</div>
            </a>
            <ul>
                <!-- Data Petugas (Admin Only) -->
                @if (Auth::guard('petugas')->user()->level->level === 'administrator')
                    <li>
                        <a href="{{ route('admin.petugas.index') }}"
                            class="{{ request()->routeIs('admin.petugas.*') ? 'mm-active' : '' }}">
                            <img src="{{ asset('assets/icons/people-outline.svg') }}" width="16" height="16"
                                alt="Petugas" style="margin-right: 8px;">
                            Petugas
                        </a>
                    </li>
                @endif

                <!-- Data Barang -->
                <li>
                    <a href="{{ route('admin.barang.index') }}"
                        class="{{ request()->routeIs('admin.barang.*') ? 'mm-active' : '' }}">
                        <img src="{{ asset('assets/icons/cube-outline.svg') }}" width="16" height="16"
                            alt="Barang" style="margin-right: 8px;">
                        Barang
                    </a>
                </li>

                <!-- Data Masyarakat (Admin Only) -->
                @if (Auth::guard('petugas')->user()->level->level === 'administrator')
                    <li>
                        <a href="{{ route('admin.masyarakat.index') }}"
                            class="{{ request()->routeIs('admin.masyarakat.*') ? 'mm-active' : '' }}">
                            <img src="{{ asset('assets/icons/person-outline.svg') }}" width="16" height="16"
                                alt="Masyarakat" style="margin-right: 8px;">
                            Masyarakat
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        <!-- LELANG (Petugas Only) -->
        @if (Auth::guard('petugas')->user()->level->level === 'petugas')
            <li class="menu-label">Lelang</li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                        <img src="{{ asset('assets/icons/hammer-outline.svg') }}" width="20" height="20"
                            alt="Lelang">
                    </div>
                    <div class="menu-title">Manajemen Lelang</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.lelang.index') }}"
                            class="{{ request()->routeIs('admin.lelang.*') ? 'mm-active' : '' }}">
                            <img src="{{ asset('assets/icons/pricetag-outline.svg') }}" width="16" height="16"
                                alt="Kelola Lelang" style="margin-right: 8px;">
                            Kelola Lelang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.history.index') }}"
                            class="{{ request()->routeIs('admin.history.*') ? 'mm-active' : '' }}">
                            <img src="{{ asset('assets/icons/time-outline.svg') }}" width="16" height="16"
                                alt="History Lelang" style="margin-right: 8px;">
                            History Lelang
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- LAPORAN -->
        <li class="menu-label">Laporan</li>
        <li>
            <a href="{{ route('admin.laporan.index') }}"
                class="{{ request()->routeIs('admin.laporan.*') ? 'mm-active' : '' }}">
                <div class="parent-icon">
                    <img src="{{ asset('assets/icons/document-text-outline.svg') }}" width="20" height="20"
                        alt="Laporan">
                </div>
                <div class="menu-title">Laporan</div>
            </a>
        </li>

        <!-- TENTANG -->
        <li class="menu-label">Informasi</li>
        <li>
            <a href="{{ route('admin.tentang') }}"
                class="{{ request()->routeIs('admin.tentang') ? 'mm-active' : '' }}">
                <div class="parent-icon">
                    <img src="{{ asset('assets/icons/information-circle-outline.svg') }}" width="20" height="20"
                        alt="Tentang">
                </div>
                <div class="menu-title">Tentang</div>
            </a>
        </li>

        <!-- PROFIL & LOGOUT -->
        <li class="menu-label">Akun</li>
        <li>
            <a href="{{ route('admin.profile') }}"
                class="{{ request()->routeIs('admin.profile') ? 'mm-active' : '' }}">

                <div class="parent-icon">
                    <img src="{{ asset('assets/icons/person-circle-outline.svg') }}" width="20" height="20"
                        alt="Profil">
                </div>
                <div class="menu-title">Profil Saya</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <div class="parent-icon">
                    <img src="{{ asset('assets/icons/log-out-outline.svg') }}" width="20" height="20"
                        alt="Logout">
                </div>
                <div class="menu-title">Logout</div>
            </a>
        </li>
    </ul>
</aside>
