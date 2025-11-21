<!--start top header-->
<header class="top-header">
    <nav class="navbar navbar-expand gap-3">
        <div class="toggle-icon">
            <ion-icon name="menu-outline"></ion-icon>
        </div>

        <form class="searchbar">
            <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
                <ion-icon name="search-outline"></ion-icon>
            </div>
            <input class="form-control" type="text" placeholder="Cari sesuatu...">
            <div class="position-absolute top-50 translate-middle-y search-close-icon">
                <ion-icon name="close-outline"></ion-icon>
            </div>
        </form>

        <div class="top-navbar-right ms-auto d-flex align-items-center gap-3">
            <!-- Nama Petugas/Admin Sebelah Profil -->
            <span style="color: #1e3a8a; font-weight: 600; font-size: 1rem; white-space: nowrap;">
                {{ Auth::guard('petugas')->user()->nama_petugas }}
            </span>

            <!-- Profil Dummy -->
            <ul class="navbar-nav align-items-center m-0 p-0">
                <li class="nav-item dropdown dropdown-user-setting">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret p-0" href="javascript:;"
                        data-bs-toggle="dropdown">
                        <div class="user-setting">
                            <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}" class="user-img"
                                alt="{{ Auth::guard('petugas')->user()->nama_petugas }}">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <!-- Dropdown content tetap sama -->
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <div class="d-flex flex-row align-items-center gap-2">
                                    <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}"
                                        alt="{{ Auth::guard('petugas')->user()->nama_petugas }}" class="rounded-circle"
                                        width="54" height="54">
                                    <div class="">
                                        <h6 class="mb-0 dropdown-user-name">
                                            {{ Auth::guard('petugas')->user()->nama_petugas }}
                                        </h6>
                                        <small
                                            class="mb-0 dropdown-user-designation text-secondary text-capitalize">{{ Auth::guard('petugas')->user()->level->level }}</small>
                                        <br>
                                        <small
                                            class="mb-0 dropdown-user-email text-muted">{{ Auth::guard('petugas')->user()->username }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <ion-icon name="person-outline"></ion-icon>
                                    </div>
                                    <div class="ms-3"><span>Profil</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <ion-icon name="speedometer-outline"></ion-icon>
                                    </div>
                                    <div class="ms-3"><span>Dashboard</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal"
                                data-bs-target="#logoutModal">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <ion-icon name="log-out-outline"></ion-icon>
                                    </div>
                                    <div class="ms-3"><span>Logout</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--end top header-->
