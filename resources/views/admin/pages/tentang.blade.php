@extends('admin.layouts.main')

@section('title', 'Tentang')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Informasi',
        'subtitle' => 'Tentang',
    ])

    <!-- Card Tentang Aplikasi -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/images/Lalelang.png') }}" width="120" height="120" alt="Logo">
                        <h4 class="logo-text" style="font-size: 30px; font-weight: bold; margin: 0; color: #0a6cff;">
                            UKK Sistem Lelang
                        </h4>
                        <small class="logo-text" style="font-size: 7px; margin-top: 5px;">Powered by Zean</small>
                    </div>

                    <hr>

                    <h5 class="mb-3">Tentang Lelang dan Aplikasi</h5>
                    <p>Lelang adalah proses penjualan barang atau jasa di mana harga ditentukan melalui penawaran terbuka.
                        Dalam lelang, peserta bersaing untuk membeli barang atau jasa dengan mengajukan tawaran harga yang
                        lebih tinggi, dan barang atau jasa tersebut akan diberikan kepada peserta yang menawarkan harga
                        tertinggi. Lelang biasanya dilakukan dalam waktu terbatas dan bisa dilakukan secara langsung atau
                        melalui platform online.
                    </p>

                    <p>
                        Sistem Lelang Online adalah platform digital yang memudahkan proses lelang barang secara online.
                        Aplikasi ini dikembangkan untuk memberikan transparansi dan kemudahan dalam proses penawaran lelang.
                    </p>

                    <h6 class="mt-4 mb-2">Fitur Utama:</h6>
                    <ul>
                        <li>Multi-role (Administrator, Petugas, Masyarakat)</li>
                        <li>Manajemen data barang lelang</li>
                        <li>Pengelolaan akun oleh Administrator</li>
                        <li>Sistem lelang oleh Petugas</li>
                        <li>Sistem penawaran oleh Masyarakat</li>
                        <li>History lelang</li>
                        <li>Laporan transaksi lelang</li>
                    </ul>

                    <hr>

                    <h5 class="mb-3">Pembuat</h5>
                    <div class="card bg-light">
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td width="30%"><strong>Nama</strong></td>
                                        <td>Zidan Ahmad Munawar</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas</strong></td>
                                        <td>XII RPL B</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sekolah</strong></td>
                                        <td>SMK TI Pembangunan</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jurusan</strong></td>
                                        <td>Rekayasa Perangkat Lunak (RPL)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asal</strong></td>
                                        <td>Bandung</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Domisili</strong></td>
                                        <td>Batujajar, Bandung Barat</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Teknologi yang Digunakan</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <h6>Laravel</h6>
                                    <small class="text-muted">Framework PHP</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <h6>Bootstrap</h6>
                                    <small class="text-muted">CSS Framework</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <h6>MySQL</h6>
                                    <small class="text-muted">Database</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            &copy; {{ date('Y') }} Sistem Lelang Online. All rights reserved.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
