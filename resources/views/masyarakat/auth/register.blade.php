<!DOCTYPE html>
<html lang="id" class="no-js">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="codexcoder" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- site favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets-user/images/favicon.png') }}" />

    <!-- ====== All css file ========= -->
    <link rel="stylesheet" href="{{ asset('assets-user/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/icofont.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/lightcase.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-user/css/style.min.css') }}" />

    <title>Daftar Akun - Sistem Lelang</title>
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
                        style="max-width: 100px;" />
                </a>
            </div>
        </div>
    </header>
    <!-- ===============//header section end here \\================= -->

    <!-- Register Section start -->
    <div class="login-section light-version padding-top padding-bottom">
        <div class="container">
            <div class="row g-5 align-items-center flex-md-row-reverse">
                <div class="col-lg-5">
                    <div class="account-wrapper">
                        <h3 class="title">Sign Up</h3>
                        <p class="mb-4">Daftar untuk mengikuti lelang</p>

                        <form class="account-form" method="POST" action="{{ route('masyarakat.register.post') }}">
                            @csrf

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
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                    placeholder="Nama Lengkap" required autofocus>
                                <label for="nama_lengkap">Nama Lengkap</label>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                    id="nik" name="nik" maxlength="16" value="{{ old('nik') }}"
                                    placeholder="NIK (16 digit)" required>
                                <label for="nik">NIK</label>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                    id="telp" name="telp" value="{{ old('telp') }}"
                                    placeholder="08xxxxxxxxxx" required>
                                <label for="telp">Nomor Telepon</label>
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                    placeholder="Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                                <label for="alamat">Alamat Lengkap</label>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation">Konfirmasi Password</label>
                            </div>

                            <div class="checkgroup">
                                <input type="checkbox" name="terms" id="terms"
                                    class="@error('terms') is-invalid @enderror" value="1" required />
                                <label for="terms">Saya menyetujui Syarat dan Ketentuan</label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group mb-3">
                                <button type="submit" class="default-btn move-top w-100">
                                    <span>Daftar</span>
                                </button>
                            </div>
                        </form>

                        <div class="account-bottom text-center pt-3">
                            <span class="d-block cate">
                                Sudah punya akun? <a href="{{ route('masyarakat.login') }}">Masuk</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="account-img">
                        <img src="{{ asset('assets-user/images/account/1234.gif') }}" alt="shape-image" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Section ends Here-->

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
