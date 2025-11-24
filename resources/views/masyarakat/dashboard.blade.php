@extends('masyarakat.layouts.main')

@section('title', 'Dashboard Masyarakat')

@section('content')
    <!-- ===============//banner section start here \\================= -->
    <section class="banner-section light-version"
        style="background-image: url({{ asset('assets-user/images/banner/bg-6.jpg') }});">
        <div class="container-fluid">
            <div class="banner m-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="banner-content">
                            <h1><span class="theme-color" data-blast="color">Temukan</span> Koleksi <br>
                                Dan Setumpuk <span class="theme-color" data-blast="color">Barang Lelang</span> Berkualitas
                            </h1>
                            <p>Marketplace digital untuk lelang barang-barang berkualitas.
                                temukan aset eksklusif melalui sistem lelang yang terpercaya.</p>
                            <div class="banner-btns d-flex flex-wrap">
                                <a data-blast="bgColor" href="{{ route('masyarakat.lelang') }}"
                                    class="default-btn move-top"><span>Jelajahi Lelang</span> </a>
                                <a href="{{ route('masyarakat.lelang') }}" class="default-btn move-right"><span>Ikut
                                        Lelang</span> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-image">
                            <img src="{{ asset('assets-user/images/account/Male auctioneer asking bids for painting 3d Character Illustration.png') }}"
                                alt="Lelang Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===============//banner section end here \\================= -->

    <!-- ===============//cara kerja section start here \\================= -->
    <section class="process-section padding-top">
        <div class="container">
            <div class="section-header style-3">
                <div class="header-shape"><span></span></div>
                <h3>Mudah Memulai Lelang</h3>
            </div>
            <div class="section-wrapper">
                <div class="nft-sell-wrapper">
                    <div class="row justify-content-center gx-4 gy-2">
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="nft-item style-3 light-version">
                                <div class="nft-inner text-center">
                                    <div class="nft-thumb">
                                        <img src="{{ asset('assets-user/images/nft-item/style-3/01.png') }}" alt="img"
                                            style="width: 160px; height: 160px;">
                                    </div>
                                    <div class="nft-content">
                                        <div class="author-details">
                                            <h4>Daftar Akun</h4>
                                            <p>Buat akun masyarakat dan lengkapi profil Anda dengan data yang valid untuk
                                                dapat mengikuti lelang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="nft-item style-3 light-version">
                                <div class="nft-inner text-center">
                                    <div class="nft-thumb">
                                        <img src="{{ asset('assets-user/images/nft-item/style-3/02.png') }}" alt="img"
                                            style="width: 160px; height: 160px;">
                                    </div>
                                    <div class="nft-content">
                                        <h4>Pilih Barang</h4>
                                        <p>Jelajahi berbagai barang-barang lelang yang sudah tersedia dan pilih yang sesuai
                                            dengan minat Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="nft-item style-3 light-version">
                                <div class="nft-inner text-center">
                                    <div class="nft-thumb">
                                        <img src="{{ asset('assets-user/images/nft-item/style-3/03.png') }}" alt="img"
                                            style="width: 160px; height: 160px;">
                                    </div>
                                    <div class="nft-content">
                                        <div class="author-details">
                                            <h4>Ajukan Penawaran</h4>
                                            <p>Ajukan penawaran harga untuk suatu barang yang Anda minati dengan rentang
                                                harga yang kompetitif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="nft-item style-3 light-version">
                                <div class="nft-inner text-center">
                                    <div class="nft-thumb">
                                        <img src="{{ asset('assets-user/images/nft-item/style-3/04.png') }}" alt="img"
                                            style="width: 160px; height: 160px;">
                                    </div>
                                    <div class="nft-content">
                                        <div class="author-details">
                                            <h4>Menangkan Lelang</h4>
                                            <p>Jika penawaran Anda tertinggi saat lelang berakhir, Anda berhak membeli
                                                barang tersebut</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===============//cara kerja section end here \\================= -->

    <!-- ===============//lelang aktif section start here \\================= -->
    <section class="auction-section padding-top">
        <div class="container">
            <div class="section-header light-version-2">
                <div class="header-shape"><span></span></div>
                <h3>Lelang Aktif</h3>
            </div>
            <div class="section-wrapper">
                @if ($lelangAktif->count() > 0)
                    <div class="row g-4">
                        @foreach ($lelangAktif as $lelang)
                            @php
                                $currentLeader = $lelang->historyLelang
                                    ->where('penawaran_harga', $lelang->harga_akhir)
                                    ->first();
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="nft-item light-home-2">
                                    <div class="nft-inner">
                                        <!-- nft top part -->
                                        <div class="nft-item-top d-flex justify-content-between align-items-center">
                                            <div class="author-part">
                                                <ul class="author-list d-flex">
                                                    <li class="single-author d-flex align-items-center">
                                                        <a href="javascript:void(0)" class="veryfied">
                                                            <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}"
                                                                alt="author-img">
                                                        </a>
                                                        <h6><a
                                                                href="javascript:void(0)">{{ $lelang->petugas->nama_petugas }}</a>
                                                        </h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- nft-bottom part -->
                                        <div class="nft-item-bottom">
                                            <div class="nft-thumb position-relative">
                                                @if ($lelang->barang->gambarPrimary)
                                                    <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                        alt="{{ $lelang->barang->nama_barang }}"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets-user/images/nft-item/04.gif') }}"
                                                        alt="nft-img"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                                                @endif

                                                <!-- Badge Status -->
                                                <div class="position-absolute top-0 start-0 m-2">
                                                    <span class="badge bg-success">Berlangsung</span>
                                                </div>
                                            </div>
                                            <div class="nft-content">
                                                <h5 class="mb-2">{{ $lelang->barang->nama_barang }}</h5>

                                                <!-- Info Pemenang Saat Ini -->
                                                @if ($currentLeader)
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="icofont-crown"></i>
                                                            Memimpin:
                                                            <strong>
                                                                @if ($currentLeader->user->id_user == Auth::guard('masyarakat')->id())
                                                                    Anda
                                                                @else
                                                                    {{ $currentLeader->user->nama_lengkap }}
                                                                @endif
                                                            </strong>
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="icofont-info-circle"></i>
                                                            Belum ada penawaran
                                                        </small>
                                                    </div>
                                                @endif

                                                <div class="price-like d-flex justify-content-between align-items-center">
                                                    <p class="nft-price mb-0">
                                                        @if ($lelang->harga_akhir > 0)
                                                            <span class="yellow-color">Rp
                                                                {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</span>
                                                        @else
                                                            <span class="yellow-color">Rp
                                                                {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}</span>
                                                        @endif
                                                    </p>
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-users me-1"></i>
                                                        <span>{{ $lelang->historyLelang->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="icofont-auction display-1 text-muted"></i>
                        <h4 class="text-muted mt-3">Belum Ada Lelang Aktif</h4>
                        <p class="text-muted">Saat ini tidak ada lelang yang sedang berlangsung. Silakan cek kembali nanti.
                        </p>
                        <a href="{{ route('masyarakat.lelang') }}" class="btn btn-primary mt-3">
                            <i class="icofont-refresh me-2"></i>Cek Lelang Lainnya
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ===============//lelang aktif section end here \\================= -->

    <!-- ===============//lelang coming soon section start here \\================= -->
    <section class="auction-section padding-top padding-bottom">
        <div class="container">
            <div class="section-header light-version-3">
                <div class="header-title">
                    <div>
                        <i class="icofont-clock-time" style="font-size: 24px;"></i>
                    </div>
                    <h3>Lelang Segera Dimulai</h3>
                </div>
            </div>
            <div class="section-wrapper">
                @if ($lelangComingSoon->count() > 0)
                    <div class="row g-4">
                        @foreach ($lelangComingSoon as $lelang)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="nft-item light-version-4">
                                    <div class="nft-inner">
                                        <!-- nft top part -->
                                        <div class="nft-item-top d-flex justify-content-between align-items-center">
                                            <div class="author-part">
                                                <ul class="author-list d-flex">
                                                    <li class="single-author d-flex align-items-center">
                                                        <a href="javascript:void(0)" class="veryfied">
                                                            <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}"
                                                                alt="author-img">
                                                        </a>
                                                        <h6><a
                                                                href="javascript:void(0)">{{ $lelang->petugas->nama_petugas }}</a>
                                                        </h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- nft-bottom part -->
                                        <div class="nft-item-bottom">
                                            <div class="nft-thumb position-relative">
                                                @if ($lelang->barang->gambarPrimary)
                                                    <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                        alt="{{ $lelang->barang->nama_barang }}"
                                                        style="width: 100%; height: 200px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets-user/images/nft-item/05.gif') }}"
                                                        alt="nft-img"
                                                        style="width: 100%; height: 200px; object-fit: cover;">
                                                @endif

                                                <!-- Badge Status -->
                                                <div class="position-absolute top-0 start-0 m-2">
                                                    <span class="badge bg-warning text-dark">Segera</span>
                                                </div>
                                            </div>
                                            <div class="nft-content">
                                                <h5 class="mb-2">{{ Str::limit($lelang->barang->nama_barang, 20) }}</h5>

                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="icofont-info-circle"></i>
                                                        Menunggu dimulai
                                                    </small>
                                                </div>

                                                <div class="price-like d-flex justify-content-between align-items-center">
                                                    <p class="nft-price mb-0">
                                                        <span class="yellow-color">Rp
                                                            {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}</span>
                                                    </p>
                                                    {{-- <div class="d-flex align-items-center">
                                                        <i class="icofont-eye me-1"></i>
                                                        <span>0</span>
                                                    </div> --}}
                                                </div>

                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="icofont-calendar"></i>
                                                        Mulai:
                                                        {{ \Carbon\Carbon::parse($lelang->tgl_lelang)->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="icofont-clock-time display-1 text-muted"></i>
                        <h4 class="text-muted mt-3">Belum Ada Lelang Mendatang</h4>
                        <p class="text-muted">Tidak ada lelang yang akan segera dimulai. Pantau terus untuk update lelang
                            baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ===============//lelang coming soon section end here \\================= -->

    <!-- ===============//Riwayat Lelang Saya section start here \\================= -->
    <section class="ex-drop-section padding-bottom">
        <div class="container">
            <div class="section-header style-3">
                <div class="header-shape"><span></span></div>
                <h3>Riwayat Lelang Saya</h3>
            </div>
            <div class="section-wrapper">
                <div class="ex-drop-wrapper">
                    @if ($riwayatUser->count() > 0)
                        <div class="row justify-content-center gx-4 gy-3">
                            @foreach ($riwayatUser as $history)
                                @php
                                    $lelang = $history->lelang;
                                    $userHighestBid = $lelang->historyLelang
                                        ->where('id_user', Auth::guard('masyarakat')->id())
                                        ->max('penawaran_harga');
                                    $isWinner = $lelang->id_user == Auth::guard('masyarakat')->id();
                                    $isFinished = $lelang->id_user != null;
                                    $currentLeader = $lelang->historyLelang
                                        ->where('penawaran_harga', $lelang->harga_akhir)
                                        ->first();
                                @endphp
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <div class="nft-item light-version">
                                        <div class="nft-inner">
                                            <!-- nft top part -->
                                            <div class="nft-item-top d-flex justify-content-between align-items-center">
                                                <div class="author-part">
                                                    <ul class="author-list d-flex">
                                                        <li class="single-author d-flex align-items-center">
                                                            <a href="javascript:void(0)" class="veryfied">
                                                                <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}"
                                                                    alt="author-img">
                                                            </a>
                                                            <h6><a
                                                                    href="javascript:void(0)">{{ $lelang->petugas->nama_petugas }}</a>
                                                            </h6>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- nft-bottom part -->
                                            <div class="nft-item-bottom">
                                                <div class="nft-thumb position-relative">
                                                    @if ($lelang->barang->gambarPrimary)
                                                        <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                            alt="{{ $lelang->barang->nama_barang }}"
                                                            style="width: 100%; height: 200px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets-user/images/nft-item/01.gif') }}"
                                                            alt="nft-img"
                                                            style="width: 100%; height: 200px; object-fit: cover;">
                                                    @endif

                                                    <!-- Badge Status -->
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        @if ($isWinner && $isFinished)
                                                            <span class="badge bg-success">Menang</span>
                                                        @elseif($isFinished && !$isWinner)
                                                            <span class="badge bg-danger">Kalah</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Proses</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="nft-content">
                                                    <h5 class="mb-2">{{ Str::limit($lelang->barang->nama_barang, 20) }}
                                                    </h5>

                                                    <!-- Info Status -->
                                                    @if ($isWinner && $isFinished)
                                                        <div class="mb-2">
                                                            <small class="text-success">
                                                                <i class="icofont-trophy"></i>
                                                                Anda memenangkan lelang
                                                            </small>
                                                        </div>
                                                    @elseif($isFinished && !$isWinner)
                                                        <div class="mb-2">
                                                            <small class="text-muted">
                                                                <i class="icofont-close"></i>
                                                                Penawaran dikalahkan
                                                            </small>
                                                        </div>
                                                    @else
                                                        <div class="mb-2">
                                                            <small class="text-muted">
                                                                <i class="icofont-clock-time"></i>
                                                                Masih berlangsung
                                                            </small>
                                                        </div>
                                                    @endif

                                                    <div
                                                        class="price-like d-flex justify-content-between align-items-center">
                                                        <p class="nft-price mb-0">
                                                            <span class="yellow-color">Rp
                                                                {{ number_format($userHighestBid, 0, ',', '.') }}</span>
                                                        </p>
                                                        <div class="d-flex align-items-center">
                                                            <i class="icofont-handshake-deal me-1"></i>
                                                            <span>{{ $lelang->historyLelang->where('id_user', Auth::guard('masyarakat')->id())->count() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="icofont-history display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">Anda belum mengikuti lelang apapun</h4>
                            <p class="text-muted">Mulai ikuti lelang sekarang dan dapatkan barang-barang berkualitas dengan
                                harga terbaik.</p>
                            <a href="{{ route('masyarakat.lelang') }}" class="btn btn-primary mt-3"
                                style="color: aliceblue;">
                                <i class="icofont-handshake-deal me-2"></i>Mulai Lelang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- ===============//Riwayat Lelang Saya section end here \\================= -->

    <!-- ===============//top pelelang section start here \\================= -->
    <section class="seller-section pb-100">
        <div class="container">
            <div class="section-header light-version-3">
                <div class=" header-title">
                    <div>
                        <i class="icofont-crown" style="font-size: 24px;"></i>
                    </div>
                    <h3>Top Pelelang</h3>
                </div>
                <div class="header-content d-flex flex-wrap align-items-center">
                    <a href="javascript:void(0)" class="view-all-btn" data-blast="color" data-bs-toggle="modal"
                        data-bs-target="#topBidderModal">
                        Lihat Semua <span><i class="icofont-rounded-double-right"></i></span>
                    </a>
                </div>
            </div>
            <div class="section-wrapper">
                @if ($topPelelang->count() > 0)
                    <div class="seller-wrapper">
                        @foreach ($topPelelang as $index => $pelelang)
                            <div class="seller-item light-version-4">
                                <div class="seller-inner">
                                    <div class="seller-part">
                                        <p class="assets-number">{{ $index + 1 }}</p>
                                        <div class="assets-owner">
                                            <div class="owner-thumb veryfied">
                                                <a href="javascript:void(0)" class="">
                                                    <img src="{{ asset('assets/images/avatars/Roblox.jpg') }}"
                                                        alt="seller-img">
                                                </a>
                                            </div>
                                            <div class="owner-content">
                                                <h5><a href="javascript:void(0)">{{ $pelelang->nama_lengkap }}</a> </h5>
                                                <p>{{ $pelelang->total_bid }} Penawaran</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="icofont-users display-1 text-muted"></i>
                        <h4 class="text-muted mt-3">Belum Ada Data Top Pelelang</h4>
                        <p class="text-muted">Data top pelelang akan muncul setelah ada aktivitas lelang dari masyarakat.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ===============//top pelelang section end here \\================= -->

    <!-- Modal Top Pelelang -->
    @if ($topPelelang->count() > 0)
        <div class="modal fade" id="topBidderModal" tabindex="-1" aria-labelledby="topBidderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topBidderModalLabel">Daftar Top Pelelang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Nama</th>
                                        <th>Total Penawaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topPelelang as $index => $pelelang)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pelelang->nama_lengkap }}</td>
                                            <td>{{ $pelelang->total_bid }} Penawaran</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
