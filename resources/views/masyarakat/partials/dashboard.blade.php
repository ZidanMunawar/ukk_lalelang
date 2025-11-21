<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Sistem Lelang</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0f1c3f;
            --secondary-color: #1e3a8a;
            --accent-color: #3b82f6;
            --light-color: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--light-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .banner-section {
            margin-bottom: 30px;
        }

        .banner-image img {

            height: 250px;
        }

        .card-lelang {
            transition: all 0.3s;
            height: 100%;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-lelang:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(15, 28, 63, 0.1);
            border-color: var(--accent-color);
        }

        .img-lelang {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .badge-leading {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .section-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--primary-color);
            border-color: var(--border-color);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 6px;
            font-weight: 500;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
        }

        .bid-indicator {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .bid-progress {
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 3px;
            flex-grow: 1;
            margin: 0 10px;
            overflow: hidden;
        }

        .bid-progress-fill {
            height: 100%;
            background-color: var(--accent-color);
            border-radius: 3px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .footer-custom {
            background-color: var(--primary-color);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('masyarakat.dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    style="margin-right: 10px;">
                    <path d="m6 9 6 6 6-6" />
                    <path d="M4 4h16" />
                    <path d="M4 16h16" />
                </svg>
                Sistem Lelang
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#lelangAktif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="margin-right: 5px;">
                                <path
                                    d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
                            </svg>
                            Lelang Aktif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#myHistory">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="margin-right: 5px;">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            History
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="margin-right: 5px;">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            {{ Auth::guard('masyarakat')->user()->nama_lengkap }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('masyarakat.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" y1="12" x2="9" y2="12" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Banner -->
        <div class="banner-section">
            <div class="banner-image">
                <img src="{{ asset('assets/images/banner-photo.png') }}" alt="Banner Lelang" class="img-fluid w-100">
            </div>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fw-bold mb-3">Selamat Datang di Sistem Lelang Online!</h2>
                        <p class="mb-0">Ikuti lelang, ajukan penawaran, dan menangkan barang impian Anda dengan harga
                            terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                        fill="none" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
                    </svg>
                    <div class="stat-number">{{ $lelangAktif->count() }}</div>
                    <div class="stat-label">Lelang Aktif</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                        fill="none" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                        <path d="M5 3v4" />
                        <path d="M19 17v4" />
                        <path d="M3 5h4" />
                        <path d="M17 19h4" />
                    </svg>
                    <div class="stat-number">{{ $myWins->count() }}</div>
                    <div class="stat-label">Lelang Dimenangkan</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                        fill="none" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <div class="stat-number">{{ $myBids->count() }}</div>
                    <div class="stat-label">Total Penawaran</div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" style="margin-right: 8px;">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" style="margin-right: 8px;">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Lelang Aktif -->
        <h4 class="section-title" id="lelangAktif">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" style="margin-right: 8px;">
                <path
                    d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
            </svg>
            Lelang Aktif
        </h4>
        <div class="row mb-5">
            @forelse($lelangAktif as $item)
                <div class="col-md-4 mb-4">
                    <div class="card card-lelang">
                        @if ($item->barang->gambarPrimary)
                            <img src="{{ asset('storage/barang/' . $item->barang->gambarPrimary->gambar) }}"
                                class="card-img-top img-lelang" alt="{{ $item->barang->nama_barang }}">
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" class="card-img-top img-lelang"
                                alt="No Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->barang->nama_barang }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($item->barang->deskripsi_barang, 80) }}</p>

                            <div class="mb-2">
                                <small class="text-muted">Harga Awal:</small>
                                <div class="fw-bold">Rp {{ number_format($item->barang->harga_awal, 0, ',', '.') }}
                                </div>
                            </div>

                            @if ($item->harga_akhir > 0)
                                <div class="mb-2">
                                    <small class="text-muted">Penawaran Tertinggi:</small>
                                    <div class="fw-bold text-success">Rp
                                        {{ number_format($item->harga_akhir, 0, ',', '.') }}</div>
                                    @php
                                        $highestBidder = \App\Models\HistoryLelang::where('id_lelang', $item->id_lelang)
                                            ->where('penawaran_harga', $item->harga_akhir)
                                            ->orderBy('created_at', 'asc')
                                            ->first();
                                    @endphp
                                    @if ($highestBidder && $highestBidder->id_user == auth()->guard('masyarakat')->user()->id_user)
                                        <span class="badge bg-success badge-leading">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                style="margin-right: 5px;">
                                                <path
                                                    d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
                                            </svg>
                                            Anda Memimpin!
                                        </span>
                                    @else
                                        <small class="text-danger">Anda tertinggal</small>
                                    @endif
                                </div>
                            @endif

                            <div class="bid-indicator">
                                <small class="text-muted">Penawaran:</small>
                                <div class="bid-progress">
                                    <div class="bid-progress-fill"
                                        style="width: {{ min(($item->historyLelang->count() / 10) * 100, 100) }}%">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $item->historyLelang->count() }}</small>
                            </div>

                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#bidModal{{ $item->id_lelang }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
                                    <line x1="12" y1="1" x2="12" y2="23" />
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                                Ajukan Penawaran
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Bid -->
                <div class="modal fade" id="bidModal{{ $item->id_lelang }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ajukan Penawaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('masyarakat.bid.submit', $item->id_lelang) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        @if ($item->barang->gambarPrimary)
                                            <img src="{{ asset('storage/barang/' . $item->barang->gambarPrimary->gambar) }}"
                                                class="rounded"
                                                style="width: 150px; height: 150px; object-fit: cover;"
                                                alt="{{ $item->barang->nama_barang }}">
                                        @endif
                                    </div>

                                    <h6>{{ $item->barang->nama_barang }}</h6>

                                    <div class="alert alert-info">
                                        <small>
                                            Minimal bid: <strong>Rp
                                                {{ number_format($item->harga_akhir > 0 ? $item->harga_akhir + 1 : $item->barang->harga_awal + 1, 0, ',', '.') }}</strong>
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="penawaran_harga{{ $item->id_lelang }}" class="form-label">Harga
                                            Penawaran</label>
                                        <input type="number" class="form-control"
                                            id="penawaran_harga{{ $item->id_lelang }}" name="penawaran_harga"
                                            min="{{ $item->harga_akhir > 0 ? $item->harga_akhir + 1 : $item->barang->harga_awal + 1 }}"
                                            placeholder="Masukkan penawaran Anda" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Ajukan Penawaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="16" x2="12" y2="12" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                        </svg>
                        <p class="mt-2 mb-0">Belum ada lelang yang dibuka saat ini</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- History Lelang -->
        <h4 class="section-title" id="myHistory">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" style="margin-right: 8px;">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
            History Lelang Saya
        </h4>

        <div class="accordion mb-4" id="accordionHistory">
            <!-- Lelang Dimenangkan -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseWins">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" style="margin-right: 10px;">
                            <path d="m8 12 2 2 4-4" />
                            <path d="M12 2a10 10 0 1 0 10 10 10 10 0 0 0-10-10z" />
                        </svg>
                        <strong>Lelang Dimenangkan</strong>
                        <span class="badge bg-success ms-2">{{ $myWins->count() }}</span>
                    </button>
                </h2>
                <div id="collapseWins" class="accordion-collapse collapse show" data-bs-parent="#accordionHistory">
                    <div class="accordion-body">
                        @forelse($myWins as $win)
                            <div class="row mb-3 pb-3 border-bottom align-items-center">
                                <div class="col-md-2">
                                    @if ($win->barang->gambarPrimary)
                                        <img src="{{ asset('storage/barang/' . $win->barang->gambarPrimary->gambar) }}"
                                            class="img-fluid rounded" alt="{{ $win->barang->nama_barang }}">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h6 class="mb-1">{{ $win->barang->nama_barang }}</h6>
                                    <p class="mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            style="margin-right: 5px;">
                                            <line x1="12" y1="1" x2="12" y2="23" />
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                        </svg>
                                        <small class="text-muted">Harga Kemenangan: </small>
                                        <strong class="text-success">Rp
                                            {{ number_format($win->harga_akhir, 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            style="margin-right: 5px;">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($win->tgl_lelang)->format('d F Y') }}</small>
                                    </p>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="badge bg-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            style="margin-right: 5px;">
                                            <path d="m8 12 2 2 4-4" />
                                            <path d="M12 2a10 10 0 1 0 10 10 10 10 0 0 0-10-10z" />
                                        </svg>
                                        Menang
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3;">
                                    <path d="m8 12 2 2 4-4" />
                                    <path d="M12 2a10 10 0 1 0 10 10 10 10 0 0 0-10-10z" />
                                </svg>
                                <p class="mt-2 mb-0">Anda belum memenangkan lelang</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Lelang Kalah -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseLost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" style="margin-right: 10px;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="15" y1="9" x2="9" y2="15" />
                            <line x1="9" y1="9" x2="15" y2="15" />
                        </svg>
                        <strong>Lelang Tidak Dimenangkan</strong>
                        @php
                            $myLost = $myBids->filter(function ($bids) {
                                $lelang = $bids->first()->lelang;
                                return $lelang->status == 'ditutup' &&
                                    $lelang->id_user != auth()->guard('masyarakat')->user()->id_user;
                            });
                        @endphp
                        <span class="badge bg-danger ms-2">{{ $myLost->count() }}</span>
                    </button>
                </h2>
                <div id="collapseLost" class="accordion-collapse collapse" data-bs-parent="#accordionHistory">
                    <div class="accordion-body">
                        @forelse($myLost as $lelangId => $bids)
                            @php
                                $lelang = $bids->first()->lelang;
                                $myHighestBid = $bids->sortByDesc('penawaran_harga')->first();
                            @endphp
                            <div class="row mb-3 pb-3 border-bottom align-items-center">
                                <div class="col-md-2">
                                    @if ($lelang->barang->gambarPrimary)
                                        <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                            class="img-fluid rounded" alt="{{ $lelang->barang->nama_barang }}">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h6 class="mb-1">{{ $lelang->barang->nama_barang }}</h6>
                                    <p class="mb-1">
                                        <small class="text-muted">Penawaran Anda: </small>
                                        <strong>Rp
                                            {{ number_format($myHighestBid->penawaran_harga, 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="mb-1">
                                        <small class="text-muted">Harga Akhir: </small>
                                        <strong class="text-success">Rp
                                            {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            style="margin-right: 5px;">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        </svg>
                                        <small class="text-muted">Pemenang:
                                            {{ $lelang->pemenang->nama_lengkap }}</small>
                                    </p>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="badge bg-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            style="margin-right: 5px;">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="15" y1="9" x2="9" y2="15" />
                                            <line x1="9" y1="9" x2="15" y2="15" />
                                        </svg>
                                        Kalah
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3;">
                                    <path d="M7 10v12" />
                                    <path
                                        d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z" />
                                </svg>
                                <p class="mt-2 mb-0">Belum ada lelang yang tidak dimenangkan</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Lelang Berlangsung -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOngoing">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" style="margin-right: 10px;">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        <strong>Lelang Masih Berlangsung</strong>
                        @php
                            $myOngoing = $myBids->filter(function ($bids) {
                                return $bids->first()->lelang->status == 'dibuka';
                            });
                        @endphp
                        <span class="badge bg-primary ms-2">{{ $myOngoing->count() }}</span>
                    </button>
                </h2>
                <div id="collapseOngoing" class="accordion-collapse collapse" data-bs-parent="#accordionHistory">
                    <div class="accordion-body">
                        @forelse($myOngoing as $lelangId => $bids)
                            @php
                                $lelang = $bids->first()->lelang;
                                $myHighestBid = $bids->sortByDesc('penawaran_harga')->first();
                                $currentHighest = \App\Models\HistoryLelang::where('id_lelang', $lelang->id_lelang)
                                    ->orderBy('penawaran_harga', 'desc')
                                    ->first();
                                $isLeading =
                                    $currentHighest &&
                                    $currentHighest->id_user == auth()->guard('masyarakat')->user()->id_user;
                            @endphp
                            <div class="row mb-3 pb-3 border-bottom align-items-center">
                                <div class="col-md-2">
                                    @if ($lelang->barang->gambarPrimary)
                                        <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                            class="img-fluid rounded" alt="{{ $lelang->barang->nama_barang }}">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h6 class="mb-1">{{ $lelang->barang->nama_barang }}</h6>
                                    <p class="mb-1">
                                        <small class="text-muted">Penawaran Anda: </small>
                                        <strong>Rp
                                            {{ number_format($myHighestBid->penawaran_harga, 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="mb-0">
                                        <small class="text-muted">Total penawaran: {{ $bids->count() }} kali</small>
                                    </p>
                                </div>
                                <div class="col-md-2 text-end">
                                    @if ($isLeading)
                                        <span class="badge bg-success badge-leading">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                style="margin-right: 5px;">
                                                <path
                                                    d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
                                            </svg>
                                            Memimpin
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                style="margin-right: 5px;">
                                                <circle cx="12" cy="12" r="10" />
                                                <polyline points="12 6 12 12 16 14" />
                                            </svg>
                                            Berlangsung
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3;">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <line x1="3" y1="9" x2="21" y2="9" />
                                    <line x1="9" y1="21" x2="9" y2="9" />
                                </svg>
                                <p class="mt-2 mb-0">Tidak ada lelang yang sedang berlangsung</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container text-center">
            <small>&copy; {{ date('Y') }} Sistem Lelang Online. All rights reserved.</small>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
