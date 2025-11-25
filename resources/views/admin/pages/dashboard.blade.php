@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="javascript:;">
                            <ion-icon name="home-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sistem Lelang</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Welcome Card -->
    <div class="card radius-10 border-0 mb-4" style="background-color:#0d2fc4;">
        <div class="card-body text-white">
            <div class="d-flex align-items-center">
                <div>
                    <h4 class="mb-2">Selamat Datang, {{ Auth::guard('petugas')->user()->nama_petugas }}!</h4>
                    <p class="mb-0">
                        <ion-icon name="shield-checkmark-outline" class="me-1"></ion-icon>
                        Level: <strong>{{ ucfirst(Auth::guard('petugas')->user()->level->level) }}</strong>
                    </p>
                </div>
                <div class="ms-auto">
                    <ion-icon name="person-circle-outline" style="font-size: 80px; opacity: 0.3;"></ion-icon>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::guard('petugas')->user()->level->level === 'administrator')
        <!-- Admin Stats Cards -->
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Total Revenue</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-purple">
                                <ion-icon name="wallet-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Total Masyarakat</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">{{ $totalMasyarakat }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Total Penawaran</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-danger">
                                <ion-icon name="bag-handle-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">{{ $totalPenawaran }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Conversion Rate</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-success">
                                <ion-icon name="bar-chart-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">{{ number_format($conversionRate, 1) }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="row row-cols-1 row-cols-lg-3 mt-4">
            <div class="col">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Status Lelang</h6>
                        </div>
                        <div id="chartStatus"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Trend Lelang (6 Bulan)</h6>
                        </div>
                        <div id="chartTrend"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Top Barang Populer</h6>
                        </div>
                        <div id="chartTopBarang"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="row mt-4">
            <div class="col-12 col-xl-6 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Top Bidders</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    @forelse($topBidders as $index => $bidder)
                                        <tr>
                                            <td>
                                                <div class="country-icon">
                                                    <div class="widget-icon-small rounded bg-light-info text-info">
                                                        <ion-icon name="person-outline"></ion-icon>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="country-name h6 mb-0">{{ $bidder->nama_lengkap }}</div>
                                            </td>
                                            <td class="w-100">
                                                <div class="progress flex-grow-1" style="height: 5px;">
                                                    <div class="progress-bar bg-gradient-info" role="progressbar"
                                                        style="width: {{ ($bidder->history_lelang_count / max($topBidders->max('history_lelang_count'), 1)) * 100 }}%;">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="percent-data">{{ $bidder->history_lelang_count }} bid
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada data bidder
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Lelang Terbaru</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    @forelse($lelangTerbaru as $lelang)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($lelang->barang->gambarPrimary)
                                                        <div class="product-box border">
                                                            <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                                width="40" height="40" style="object-fit: cover;"
                                                                alt="">
                                                        </div>
                                                    @endif
                                                    <div class="product-info">
                                                        <h6 class="product-name mb-1">
                                                            {{ $lelang->barang->nama_barang }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($lelang->id_user != null)
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($lelang->status === 'dibuka')
                                                    <span class="badge bg-info">Dibuka</span>
                                                @else
                                                    <span class="badge bg-warning">Ditutup</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-muted small">
                                                    {{ $lelang->created_at->format('d M Y') }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada lelang
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    @else
        <!-- Petugas Stats Cards -->
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Total Revenue Saya</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-purple">
                                <ion-icon name="wallet-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">Rp {{ number_format($myRevenue, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Lelang Saya</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                                <ion-icon name="hammer-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">{{ $myLelang }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Lelang Aktif</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-danger">
                                <ion-icon name="flame-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">{{ $myLelangAktif }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                            <div>
                                <p class="mb-0 fs-6">Conversion Rate</p>
                            </div>
                            <div class="ms-auto widget-icon-small text-white bg-gradient-success">
                                <ion-icon name="bar-chart-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div>
                                <h4 class="mb-0">{{ number_format($myConversionRate, 1) }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="row row-cols-1 row-cols-lg-3 mt-4">
            <div class="col">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Status Lelang</h6>
                        </div>
                        <div id="chartStatus"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Trend Lelang</h6>
                        </div>
                        <div id="chartTrend"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Barang Populer</h6>
                        </div>
                        <div id="chartTopBarang"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="row mt-4">
            <div class="col-12">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Lelang yang Saya Kelola</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Barang</th>
                                        <th>Harga Akhir</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Pemenang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lelangSaya as $lelang)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($lelang->barang->gambarPrimary)
                                                        <div class="product-box border">
                                                            <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                                width="40" height="40" style="object-fit: cover;"
                                                                alt="">
                                                        </div>
                                                    @endif
                                                    <div class="product-info">
                                                        <h6 class="product-name mb-1">
                                                            {{ $lelang->barang->nama_barang }}</h6>
                                                        <p class="mb-0 text-muted">Rp
                                                            {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($lelang->id_user != null)
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($lelang->status === 'dibuka')
                                                    <span class="badge bg-info">Dibuka</span>
                                                @else
                                                    <span class="badge bg-warning">Ditutup</span>
                                                @endif
                                            </td>
                                            <td>{{ $lelang->created_at->format('d M Y') }}</td>
                                            <td>
                                                @if ($lelang->pemenang)
                                                    {{ $lelang->pemenang->nama_lengkap }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada lelang
                                                yang dikelola</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart Status Lelang (Pie Chart)
            var chartStatusOptions = {
                series: @json($chartStatusData),
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: @json($chartStatusLabels),
                colors: ['#0d6efd', '#6c757d'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chartStatus = new ApexCharts(document.querySelector("#chartStatus"), chartStatusOptions);
            chartStatus.render();

            // Chart Trend Lelang (Line Chart)
            var chartTrendOptions = {
                series: [{
                    name: 'Jumlah Lelang',
                    data: @json($chartLelangData)
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                colors: ['#0d6efd'],
                xaxis: {
                    categories: @json($chartLelangLabels)
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Lelang'
                    }
                }
            };

            var chartTrend = new ApexCharts(document.querySelector("#chartTrend"), chartTrendOptions);
            chartTrend.render();

            // Chart Top Barang (Bar Chart)
            var chartTopBarangOptions = {
                series: [{
                    name: 'Jumlah Bid',
                    data: @json($chartTopBarangData)
                }],
                chart: {
                    type: 'bar',
                    height: 300
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($chartTopBarangLabels),
                },
                colors: ['#0dcaf0']
            };

            var chartTopBarang = new ApexCharts(document.querySelector("#chartTopBarang"), chartTopBarangOptions);
            chartTopBarang.render();
        });
    </script>
@endpush
