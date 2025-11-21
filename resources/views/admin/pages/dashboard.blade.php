@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
    @include('admin.partials.breadcrumb', [
        'title' => 'Beranda',
        'subtitle' => 'Dashboard',
    ])

    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card radius-10 border-0" style="background-color:#0d2fc4;">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-2">Selamat Datang, {{ Auth::guard('petugas')->user()->nama_petugas }}!</h4>
                            <p class="mb-0">
                                <img src="{{ asset('assets/icons/shield-checkmark-outline.svg') }}" width="18"
                                    height="18" alt="Level" style="filter: invert(100%); margin-right: 5px;">
                                Level: <strong>{{ ucfirst(Auth::guard('petugas')->user()->level->level) }}</strong>
                            </p>
                        </div>
                        <div class="ms-auto">
                            <img src="{{ asset('assets/icons/person-circle-outline.svg') }}" width="80" height="80"
                                alt="User" style="filter: invert(100%); opacity: 0.3;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-0 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Total Barang</p>
                            <h3 class="mb-0 text-primary">{{ $totalBarang }}</h3>
                        </div>
                        <div class="ms-auto">
                            <img src="{{ asset('assets/icons/cube-outline.svg') }}" width="40" height="40"
                                alt="Barang" style="opacity: 0.5;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Total Masyarakat</p>
                            <h3 class="mb-0 text-success">{{ $totalMasyarakat }}</h3>
                        </div>
                        <div class="ms-auto">
                            <img src="{{ asset('assets/icons/people-outline.svg') }}" width="40" height="40"
                                alt="Masyarakat" style="opacity: 0.5;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Lelang Aktif</p>
                            <h3 class="mb-0 text-danger">{{ $lelangAktif }}</h3>
                        </div>
                        <div class="ms-auto">
                            <img src="{{ asset('assets/icons/flame-outline.svg') }}" width="40" height="40"
                                alt="Aktif" style="opacity: 0.5;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Lelang Selesai</p>
                            <h3 class="mb-0 text-warning">{{ $lelangSelesai }}</h3>
                        </div>
                        <div class="ms-auto">
                            <img src="{{ asset('assets/icons/checkmark-circle-outline.svg') }}" width="40"
                                height="40" alt="Selesai" style="opacity: 0.5;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::guard('petugas')->user()->level->level === 'administrator')
        <!-- Admin View -->
        <div class="row">
            <!-- Additional Stats for Admin -->
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="card radius-10 border-0 bg-info text-white">
                            <div class="card-body">
                                <p class="mb-1">Total Petugas</p>
                                <h4 class="mb-0">{{ $totalPetugas }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="card radius-10 border-0 bg-dark text-white">
                            <div class="card-body">
                                <p class="mb-1">Total Penawaran</p>
                                <h4 class="mb-0">{{ $totalPenawaran }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="card radius-10">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">
                            <img src="{{ asset('assets/icons/person-outline.svg') }}" width="20" height="20"
                                alt="Akun">
                            Informasi Akun
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>Nama</strong></td>
                                    <td>{{ Auth::guard('petugas')->user()->nama_petugas }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td>{{ Auth::guard('petugas')->user()->username }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Level</strong></td>
                                    <td><span
                                            class="badge bg-primary">{{ ucfirst(Auth::guard('petugas')->user()->level->level) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Terdaftar</strong></td>
                                    <td>{{ Auth::guard('petugas')->user()->created_at->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <!-- Top Bidders -->
                <div class="card radius-10">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">
                            <img src="{{ asset('assets/icons/trophy-outline.svg') }}" width="20" height="20"
                                alt="Top">
                            Top Bidders
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Total Bid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topBidders as $index => $bidder)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $bidder->nama_lengkap }}</td>
                                            <td><span class="badge bg-success">{{ $bidder->history_lelang_count }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lelang Terbaru -->
        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">
                            <img src="{{ asset('assets/icons/time-outline.svg') }}" width="20" height="20"
                                alt="Terbaru">
                            Lelang Terbaru
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Barang</th>
                                        <th>Petugas</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lelangTerbaru as $lelang)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($lelang->barang->gambarPrimary)
                                                        <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                            class="rounded" width="40" height="40"
                                                            style="object-fit: cover;" alt="">
                                                    @endif
                                                    <span>{{ $lelang->barang->nama_barang }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $lelang->petugas->nama_petugas }}</td>
                                            <td>
                                                @if ($lelang->id_user != null)
                                                    <span class="badge bg-info">Selesai</span>
                                                @elseif($lelang->status === 'dibuka')
                                                    <span class="badge bg-success">Dibuka</span>
                                                @else
                                                    <span class="badge bg-warning">Ditutup</span>
                                                @endif
                                            </td>
                                            <td>{{ $lelang->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada lelang</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Petugas View -->
        <div class="row">
            <!-- Stats Petugas -->
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="card radius-10 border-0 bg-primary text-white">
                            <div class="card-body">
                                <p class="mb-1">Lelang Saya</p>
                                <h4 class="mb-0">{{ $myLelang }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="card radius-10 border-0 bg-success text-white">
                            <div class="card-body">
                                <p class="mb-1">Sedang Aktif</p>
                                <h4 class="mb-0">{{ $myLelangAktif }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="card radius-10">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">
                            <img src="{{ asset('assets/icons/person-outline.svg') }}" width="20" height="20"
                                alt="Akun">
                            Informasi Akun
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>Nama</strong></td>
                                    <td>{{ Auth::guard('petugas')->user()->nama_petugas }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td>{{ Auth::guard('petugas')->user()->username }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Level</strong></td>
                                    <td><span
                                            class="badge bg-success">{{ ucfirst(Auth::guard('petugas')->user()->level->level) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Terdaftar</strong></td>
                                    <td>{{ Auth::guard('petugas')->user()->created_at->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <!-- Lelang yang Saya Kelola -->
                <div class="card radius-10">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">
                            <img src="{{ asset('assets/icons/hammer-outline.svg') }}" width="20" height="20"
                                alt="Lelang">
                            Lelang yang Saya Kelola
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($lelangSaya as $lelang)
                            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                                @if ($lelang->barang->gambarPrimary)
                                    <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                        class="rounded" width="50" height="50" style="object-fit: cover;"
                                        alt="">
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $lelang->barang->nama_barang }}</h6>
                                    <small class="text-muted">{{ $lelang->created_at->format('d M Y') }}</small>
                                </div>
                                <div>
                                    @if ($lelang->id_user != null)
                                        <span class="badge bg-info">Selesai</span>
                                    @elseif($lelang->status === 'dibuka')
                                        <span class="badge bg-success">Dibuka</span>
                                    @else
                                        <span class="badge bg-warning">Ditutup</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <img src="{{ asset('assets/icons/document-outline.svg') }}" width="50"
                                    height="50" alt="Empty" style="opacity: 0.3;">
                                <p class="mt-2 mb-0">Belum ada lelang yang dikelola</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
