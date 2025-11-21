@extends('masyarakat.layouts.main')

@section('title', 'Tentang Aplikasi')
@section('page_title', 'Tentang Aplikasi')
@section('breadcrumb_active', 'Tentang')

@section('content')

    <!-- ==========About Section start Here========== -->
    <section class="about-section padding-top padding-bottom">
        <div class="container">
            <div class="section-wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- Header Section -->
                        <div class="text-center mb-5">
                            <div class="section-header style-3 mb-4">
                                <div class="header-shape"><span></span></div>
                                <h2>UKK Sistem Lelang</h2>
                                <p class="lead text-muted">Powered by Zean</p>
                            </div>
                        </div>

                        <!-- Tentang Lelang -->
                        <div class="about-card light-version mb-5">
                            <div class="lab-inner p-4 p-md-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Tentang Lelang dan Aplikasi</h3>
                                        <p class="mb-3">
                                            Lelang adalah proses penjualan barang atau jasa di mana harga ditentukan melalui
                                            penawaran terbuka.
                                            Dalam lelang, peserta bersaing untuk membeli barang atau jasa dengan mengajukan
                                            tawaran harga yang lebih tinggi,
                                            dan barang atau jasa tersebut akan diberikan kepada peserta yang menawarkan
                                            harga tertinggi.
                                        </p>
                                        <p class="mb-0">
                                            Lelang biasanya dilakukan dalam waktu terbatas dan bisa dilakukan secara
                                            langsung atau melalui platform online.
                                            Sistem Lelang Online adalah platform digital yang memudahkan proses lelang
                                            barang secara online.
                                            Aplikasi ini dikembangkan untuk memberikan transparansi dan kemudahan dalam
                                            proses penawaran lelang.
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="about-icon">
                                            <i class="icofont-handshake-deal display-1 theme-color"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fitur Utama -->
                        <div class="about-card light-version mb-5">
                            <div class="lab-inner p-4 p-md-5">
                                <h3 class="mb-4 text-center">Fitur Utama</h3>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-users-alt-2 theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Multi-role System</h5>
                                                <p class="mb-0">Administrator, Petugas, dan Masyarakat dengan akses
                                                    berbeda</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-box theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Manajemen Barang</h5>
                                                <p class="mb-0">Kelola data barang lelang dengan gambar dan deskripsi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-user theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Pengelolaan Akun</h5>
                                                <p class="mb-0">Administrator mengelola semua akun pengguna</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-hammer theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Sistem Lelang</h5>
                                                <p class="mb-0">Petugas mengelola proses lelang dari awal hingga akhir</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-computer theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Penawaran Online</h5>
                                                <p class="mb-0">Masyarakat dapat mengajukan penawaran secara real-time</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-history theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>History Lelang</h5>
                                                <p class="mb-0">Riwayat lengkap semua aktivitas lelang</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <div class="feature-icon me-3">
                                                <i class="icofont-chart-bar-graph theme-color"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Laporan Transaksi</h5>
                                                <p class="mb-0">Laporan detail transaksi lelang yang terjadi</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pembuat -->
                        <div class="about-card light-version mb-5">
                            <div class="lab-inner p-4 p-md-5">
                                <h3 class="mb-4 text-center">Pembuat</h3>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="creator-card text-center">
                                            <div class="creator-avatar mb-3">
                                                <img src="{{ asset('assets/images/avatars/Roblox.jpg') }}"
                                                    alt="Zidan Ahmad Munawar" class="rounded-circle"
                                                    style="width: 120px; height: 120px; object-fit: cover;">
                                            </div>
                                            <h4 class="mb-2">Zidan Ahmad Munawar</h4>
                                            <div class="creator-info">
                                                <p class="mb-1"><strong>Kelas:</strong> XII RPL B</p>
                                                <p class="mb-1"><strong>Sekolah:</strong> SMK TI Pembangunan</p>
                                                <p class="mb-1"><strong>Jurusan:</strong> Rekayasa Perangkat Lunak (RPL)
                                                </p>
                                                <p class="mb-1"><strong>Asal:</strong> Bandung</p>
                                                <p class="mb-0"><strong>Domisili:</strong> Batujajar, Bandung Barat</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Teknologi -->
                        <div class="about-card light-version mb-5">
                            <div class="lab-inner p-4 p-md-5">
                                <h3 class="mb-4 text-center">Teknologi yang Digunakan</h3>
                                <div class="row g-4 text-center">
                                    <div class="col-md-4">
                                        <div class="tech-item">
                                            <div class="tech-icon mb-3">
                                                <i class="icofont-code display-4 text-danger"></i>
                                            </div>
                                            <h5>Laravel</h5>
                                            <p class="text-muted mb-0">Framework PHP</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="tech-item">
                                            <div class="tech-icon mb-3">
                                                <i class="icofont-angry-monster display-4 text-primary"></i>
                                            </div>
                                            <h5>Bootstrap</h5>
                                            <p class="text-muted mb-0">CSS Framework</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="tech-item">
                                            <div class="tech-icon mb-3">
                                                <i class="icofont-database display-4 theme-color"></i>
                                            </div>
                                            <h5>MySQL</h5>
                                            <p class="text-muted mb-0">Database</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Copyright -->
                        <div class="text-center mt-5 pt-4 border-top">
                            <p class="text-muted mb-0">
                                © 2025 Sistem Lelang Online. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========About Section ends Here========== -->

    <style>
        .about-card {
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .about-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 24px;
            margin-top: 2px;
        }

        .tech-item {
            padding: 20px;
            border-radius: 10px;
            background: rgba(var(--theme-rgb), 0.05);
            transition: all 0.3s ease;
        }

        .tech-item:hover {
            background: rgba(var(--theme-rgb), 0.1);
            transform: scale(1.05);
        }

        .creator-card {
            padding: 30px;
            background: rgba(var(--theme-rgb), 0.05);
            border-radius: 15px;
            border: 2px solid rgba(var(--theme-rgb), 0.1);
        }

        .creator-info p {
            font-size: 0.95rem;
            color: var(--text-color);
        }
    </style>

@endsection
