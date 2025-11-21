@extends('masyarakat.layouts.main')

@section('title', 'Aktivitas Saya')
@section('page_title', 'Aktivitas Saya')
@section('breadcrumb_active', 'Aktivitas')

@section('content')

    <!-- ==========Activity Section start Here========== -->
    <section class="activity-section padding-top padding-bottom">
        <div class="container">
            <div class="section-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="section-header light-version">
                            <h3>Aktivitas Lelang Saya</h3>
                            <div class="nft-filter d-flex flex-wrap justify-content-center gap-15">
                                <form method="GET" action="{{ route('masyarakat.history') }}" class="d-flex gap-2">
                                    <div class="form-floating">
                                        <select class="form-select" name="status" id="statusSelect"
                                            onchange="this.form.submit()">
                                            <option value="semua"
                                                {{ request('status', 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                                            <option value="menang" {{ request('status') == 'menang' ? 'selected' : '' }}>
                                                Dimenangkan</option>
                                            <option value="kalah" {{ request('status') == 'kalah' ? 'selected' : '' }}>
                                                Kalah</option>
                                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>
                                                Dalam Proses</option>
                                        </select>
                                        <label for="statusSelect">Filter Status</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="activity-wrapper">
                            <div class="row gy-3">
                                @forelse($histories as $history)
                                    @php
                                        $lelang = $history->lelang;
                                        $isWinner = $lelang->id_user == Auth::guard('masyarakat')->id();
                                        $isFinished = $lelang->id_user != null;
                                        $isInProcess = $lelang->status === 'dibuka' && $lelang->id_user == null;
                                        $userHighestBid = $lelang->historyLelang
                                            ->where('id_user', Auth::guard('masyarakat')->id())
                                            ->max('penawaran_harga');
                                        $isUserHighest = $userHighestBid == $lelang->harga_akhir;
                                    @endphp

                                    <div class="col-12">
                                        <div class="activity-item light-version">
                                            <div class="lab-inner d-flex flex-wrap align-items-center p-3 p-md-4">
                                                <div class="lab-thumb me-3 me-md-4">
                                                    @if ($lelang->barang->gambarPrimary)
                                                        <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                            alt="{{ $lelang->barang->nama_barang }}"
                                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                    @else
                                                        <img src="{{ asset('assets-user/images/activity/01.gif') }}"
                                                            alt="img"
                                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                    @endif
                                                </div>
                                                <div class="lab-content flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h5 class="mb-0">{{ $lelang->barang->nama_barang }}</h5>
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailModal{{ $lelang->id_lelang }}">
                                                            <i class="icofont-eye"></i> Detail
                                                        </button>
                                                    </div>

                                                    @if ($isWinner && $isFinished)
                                                        <p class="mb-2">
                                                            Anda memenangkan lelang dengan penawaran akhir
                                                            <b>Rp
                                                                {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</b>
                                                            <span class="badge bg-success ms-2">Dimenangkan</span>
                                                        </p>
                                                    @elseif($isFinished && !$isWinner)
                                                        <p class="mb-2">
                                                            Penawaran Anda dikalahkan dengan harga akhir
                                                            <b>Rp
                                                                {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</b>
                                                            <span class="badge bg-danger ms-2">Kalah</span>
                                                        </p>
                                                    @elseif($isInProcess)
                                                        <p class="mb-2">
                                                            @if ($isUserHighest)
                                                                Anda memimpin dengan penawaran
                                                                <b>Rp {{ number_format($userHighestBid, 0, ',', '.') }}</b>
                                                                <span
                                                                    class="badge bg-warning ms-2 text-dark">Memimpin</span>
                                                            @else
                                                                Anda mengajukan penawaran sebesar
                                                                <b>Rp {{ number_format($userHighestBid, 0, ',', '.') }}</b>
                                                                <span class="badge bg-info ms-2">Dalam Proses</span>
                                                            @endif
                                                        </p>
                                                    @endif

                                                    <div class="d-flex flex-wrap gap-3 text-muted">
                                                        <small>
                                                            <i class="icofont-user"></i>
                                                            Petugas: {{ $lelang->petugas->nama_petugas }}
                                                        </small>
                                                        <small>
                                                            <i class="icofont-calendar"></i>
                                                            {{ $history->created_at->format('d/m/Y, H:i') }} WIB
                                                        </small>
                                                        <small>
                                                            <i class="icofont-handshake-deal"></i>
                                                            Total penawaran:
                                                            {{ $lelang->historyLelang->where('id_user', Auth::guard('masyarakat')->id())->count() }}x
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $lelang->id_lelang }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Lelang -
                                                        {{ $lelang->barang->nama_barang }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            @if ($lelang->barang->gambarPrimary)
                                                                <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                                                    class="img-fluid rounded"
                                                                    style="width: 100%; height: 200px; object-fit: cover;"
                                                                    alt="{{ $lelang->barang->nama_barang }}">
                                                            @else
                                                                <img src="{{ asset('assets/images/no-image.png') }}"
                                                                    class="img-fluid rounded"
                                                                    style="width: 100%; height: 200px; object-fit: cover;"
                                                                    alt="No Image">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h6>Deskripsi Barang</h6>
                                                            <p class="text-muted">{{ $lelang->barang->deskripsi_barang }}
                                                            </p>

                                                            <table class="table table-sm table-borderless">
                                                                <tr>
                                                                    <td width="40%"><strong>Status Lelang</strong></td>
                                                                    <td>
                                                                        @if ($isWinner && $isFinished)
                                                                            <span
                                                                                class="badge bg-success">Dimenangkan</span>
                                                                        @elseif($isFinished && !$isWinner)
                                                                            <span class="badge bg-danger">Kalah</span>
                                                                        @elseif($isInProcess)
                                                                            @if ($isUserHighest)
                                                                                <span
                                                                                    class="badge bg-warning text-dark">Sedang
                                                                                    Memimpin</span>
                                                                            @else
                                                                                <span class="badge bg-info">Dalam
                                                                                    Proses</span>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Harga Awal</strong></td>
                                                                    <td>Rp
                                                                        {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Harga Akhir</strong></td>
                                                                    <td>
                                                                        @if ($lelang->harga_akhir > 0)
                                                                            Rp
                                                                            {{ number_format($lelang->harga_akhir, 0, ',', '.') }}
                                                                        @else
                                                                            <span class="text-muted">Belum ada
                                                                                penawaran</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Penawaran Tertinggi Anda</strong></td>
                                                                    <td>
                                                                        <span class="badge bg-primary">
                                                                            Rp
                                                                            {{ number_format($userHighestBid, 0, ',', '.') }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Riwayat Penawaran Anda -->
                                                    <hr>
                                                    <h6>Riwayat Penawaran Anda</h6>
                                                    <div class="table-responsive"
                                                        style="max-height: 200px; overflow-y: auto;">
                                                        <table class="table table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Penawaran</th>
                                                                    <th>Waktu</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($lelang->historyLelang->where('id_user', Auth::guard('masyarakat')->id())->sortByDesc('created_at') as $bid)
                                                                    <tr>
                                                                        <td>Rp
                                                                            {{ number_format($bid->penawaran_harga, 0, ',', '.') }}
                                                                        </td>
                                                                        <td><small>{{ $bid->created_at->format('d/m/Y H:i') }}</small>
                                                                        </td>
                                                                        <td>
                                                                            @if ($bid->penawaran_harga == $lelang->harga_akhir && $lelang->harga_akhir > 0)
                                                                                <span
                                                                                    class="badge bg-success">Tertinggi</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-secondary">Dikalahkan</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-5">
                                        <i class="icofont-search-1 display-1 text-muted"></i>
                                        <h4 class="text-muted mt-3">Tidak ada riwayat lelang</h4>
                                        <p class="text-muted">Anda belum mengikuti lelang apapun</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Activity Section ends Here========== -->
@endsection
