<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard Masyarakat') - Sistem Lelang</title>

    <!-- site favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets-user/images/favicon.png') }}">

    <!-- ====== All css files ========= -->
    <link rel="stylesheet" href="{{ asset('assets-user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-user/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-user/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-user/css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-user/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-user/css/style.min.css') }}">

</head>

<body class="light-version">
    <div class="wrapper">
        @include('masyarakat.partials.header')

        {{-- Jika halaman bukan dashboard, tampilkan page_header --}}
        @if (!request()->routeIs('masyarakat.dashboard'))
            @include('masyarakat.partials.page_header')
        @endif

        <div class="container light-version">
            @yield('content')
        </div>

        @include('masyarakat.partials.footer')

        <!-- scrollToTop start here -->
        <a href="#" class="scrollToTop light-version"><i class="icofont-stylish-up"></i></a>
        <!-- scrollToTop ending here -->

    </div>

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
