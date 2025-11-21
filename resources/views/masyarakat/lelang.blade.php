@extends('masyarakat.layouts.main')

@section('title', 'Penawaran Pelelangan')
@section('page_title', 'Lelang')
@section('breadcrumb_active', 'Lelang')
@section('content')

    <!-- ==========Auction Section start Here========== -->
    <section class="explore-section padding-top padding-bottom">
        <div class="container">
            <div class="section-header light-version">
                <div class="nft-filter d-flex flex-wrap align-items-center justify-content-center gap-15">
                    <h3><i class="icofont-network-tower theme-color"></i> Lelang Aktif</h3>
                    <div class="form-floating">
                        <form method="GET" action="{{ route('masyarakat.lelang') }}" class="d-flex gap-2">
                            <select class="form-select" name="status" id="statusSelect" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="dibuka" {{ request('status') == 'dibuka' ? 'selected' : '' }}>Sedang
                                    Berlangsung</option>
                                <option value="coming" {{ request('status') == 'coming' ? 'selected' : '' }}>Segera Dimulai
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="nft-search">
                    <form method="GET" action="{{ route('masyarakat.lelang') }}">
                        <div class="form-floating nft-search-input">
                            <input type="text" class="form-control" name="search" id="nftSearch"
                                placeholder="Cari barang lelang" value="{{ request('search') }}">
                            <label for="nftSearch">Cari Barang Lelang</label>
                            <button type="submit"> <i class="icofont-search-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="section-wrapper">
                <div class="explore-wrapper">
                    <div class="row justify-content-center gx-4 gy-3">
                        @forelse($lelangs as $lelang)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="nft-item light-version">
                                    <div class="nft-inner">
                                        <!-- nft top part -->
                                        <div class="nft-item-top d-flex justify-content-between align-items-center">
                                            <div class="author-part">
                                                <ul class="author-list d-flex">
                                                    <li class="single-author d-flex align-items-center">
                                                        <a href="javascript:void(0)" class="veryfied">
                                                            <img loading="lazy"
                                                                src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}"
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
                                            <div class="nft-thumb">
                                                @if ($lelang->barang->gambarPrimary)
                                                    <img loading="lazy"
                                                        src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                        alt="nft-img" class="img-fluid"
                                                        style="height: 200px; object-fit: cover;">
                                                @else
                                                    <img loading="lazy"
                                                        src="{{ asset('assets-user/images/nft-item/01.gif') }}"
                                                        alt="nft-img" class="img-fluid"
                                                        style="height: 200px; object-fit: cover;">
                                                @endif

                                                @if ($lelang->status === 'ditutup')
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="badge bg-warning text-dark">Segera Dimulai</span>
                                                    </div>
                                                @else
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="badge bg-success">Sedang Berlangsung</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="nft-content">
                                                <h5 class="mb-2">{{ $lelang->barang->nama_barang }}</h5>

                                                <!-- Status Penawaran User -->
                                                @auth('masyarakat')
                                                    @php
                                                        $userBid = $lelang->historyLelang
                                                            ->where('id_user', Auth::guard('masyarakat')->id())
                                                            ->sortByDesc('penawaran_harga')
                                                            ->first();
                                                        $currentLeader = $lelang->historyLelang
                                                            ->where('penawaran_harga', $lelang->harga_akhir)
                                                            ->first();
                                                        $isLeading =
                                                            $lelang->harga_akhir > 0 &&
                                                            $currentLeader &&
                                                            $currentLeader->id_user == Auth::guard('masyarakat')->id();
                                                    @endphp

                                                    @if ($isLeading)
                                                        <div class="mb-2">
                                                            <span class="badge bg-success"><i class="icofont-crown"></i> Anda
                                                                Sedang Memimpin</span>
                                                        </div>
                                                    @elseif($userBid)
                                                        <div class="mb-2">
                                                            <span class="badge bg-warning text-dark"><i
                                                                    class="icofont-arrow-down"></i> Anda Tertinggal</span>
                                                        </div>
                                                    @else
                                                        <div class="mb-2">
                                                            <span class="badge bg-secondary"><i class="icofont-info-circle"></i>
                                                                Belum ada penawaran</span>
                                                        </div>
                                                    @endif
                                                @endauth

                                                <div
                                                    class="price-like d-flex justify-content-between align-items-center mb-2">
                                                    <p class="nft-price mb-0">
                                                        @if ($lelang->harga_akhir > 0)
                                                            <span class="yellow-color">Rp
                                                                {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</span>
                                                        @else
                                                            <span class="yellow-color">Rp
                                                                {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}</span>
                                                        @endif
                                                    </p>
                                                </div>

                                                <!-- Info Pemenang Saat Ini -->
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        @if ($lelang->harga_akhir > 0 && $currentLeader)
                                                            <i class="icofont-crown"></i>
                                                            Pemenang sementara:
                                                            <strong>
                                                                @if ($currentLeader->user->id_user == Auth::guard('masyarakat')->id())
                                                                    Anda
                                                                @else
                                                                    {{ $currentLeader->user->nama_lengkap }}
                                                                @endif
                                                            </strong>
                                                        @else
                                                            <i class="icofont-users"></i>
                                                            Pemenang sementara: <strong>-</strong>
                                                        @endif
                                                    </small>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <small class="text-muted">
                                                        <i class="icofont-users"></i> {{ $lelang->historyLelang->count() }}
                                                        penawar
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="icofont-calendar"></i>
                                                        {{ \Carbon\Carbon::parse($lelang->tgl_lelang)->format('d/m/Y') }}
                                                    </small>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    @if ($lelang->status === 'dibuka')
                                                        <button class="btn btn-primary btn-sm flex-fill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#bidModal{{ $lelang->id_lelang }}">
                                                            <i class="icofont-handshake-deal"></i> Tawar
                                                        </button>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-sm flex-fill"
                                                            disabled>
                                                            <i class="icofont-clock-time"></i> Menunggu
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-outline-secondary btn-sm flex-fill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $lelang->id_lelang }}">
                                                        <i class="icofont-info-circle"></i> Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Include Modals -->
                            @include('masyarakat.modals.detail-lelang', ['lelang' => $lelang])
                            @include('masyarakat.modals.bid-lelang', ['lelang' => $lelang])

                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="icofont-search-1 display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">Tidak ada lelang yang ditemukan</h4>
                                <p class="text-muted">Coba ubah filter pencarian Anda</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Auction Section ends Here========== -->

@endsection
