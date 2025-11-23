<!DOCTYPE html>
<html lang="id" class="no-js">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="codexcoder" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- site favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets-user/images/favicon.png') }}" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets-user/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/icofont.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/lightcase.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/style.min.css') }}" />

    <title>Login Masyarakat - Sistem Lelang</title>
</head>

<body class="light-version">
    <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here -->

    <!-- ===============// header section start here \\================= -->
    <header class="header light-version">
        <div class="container-fluid d-flex justify-content-center align-items-center py-3">
            <div class="header__logo text-center">
                <a href="#">
                    <img src="{{ asset('assets-user/images/logo/Lalelang.png') }}" alt="logo"
                        style="max-width: 50px;" />
                </a>
            </div>
        </div>
    </header>
    <!-- ===============//header section end here \\================= -->

    <!-- ==========login Section start Here========== -->
    <div class="login-section light-version padding-top padding-bottom">
        <div class="container">
            <div class="row g-5 align-items-center flex-md-row-reverse">
                <div class="col-lg-5">
                    <div class="account-wrapper">
                        <h3 class="title">Sign In</h3>
                        <p class="mb-4">Masuk untuk mengikuti lelang online kami</p>

                        <form class="account-form" method="POST" action="{{ route('masyarakat.login.post') }}">
                            @csrf

                            {{-- Tampilkan pesan sukses --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Tampilkan pesan error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                    id="floatingNik" name="nik" value="{{ old('nik') }}"
                                    placeholder="Masukkan NIK 16 digit" maxlength="16" required autofocus>
                                <label for="floatingNik">NIK</label>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="floatingPassword" name="password" placeholder="Masukkan password" required>
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <div class="d-flex justify-content-between flex-wrap pt-sm-2">
                                    <div class="checkgroup">
                                        <input type="checkbox" name="remember" id="remember" />
                                        <label for="remember">Ingat Saya</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="default-btn move-top w-100">
                                    <span>Masuk</span>
                                </button>
                            </div>
                        </form>

                        <div class="account-bottom text-center mt-3">
                            <span class="d-block cate pt-3">
                                Belum punya akun? <a href="{{ route('masyarakat.register') }}">Daftar Sekarang</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="account-img">
                        <img src="{{ asset('assets-user/images/account/123.gif') }}" alt="shape-image" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Login Section ends Here========== -->

    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop light-version">
        <i class="icofont-stylish-up"></i>
    </a>
    <!-- scrollToTop ending here -->

    <!-- All Scripts -->
    <script src="{{ asset('assets-user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/lightcase.js') }}"></script>
    <script src="{{ asset('assets-user/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/countdown.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets-user/js/functions.js') }}"></script>
</body>

</html>
