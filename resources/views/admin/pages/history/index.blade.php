@extends('admin.layouts.main')

@section('title', 'History Lelang')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Lelang',
        'subtitle' => 'History Lelang',
    ])

    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                <h5 class="mb-0">Riwayat Lelang</h5>
                <form method="GET" action="{{ route('admin.history.index') }}" class="d-flex gap-2 ms-auto"
                    style="min-width: 360px;">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="barang / pemenang"
                        value="{{ request('search') }}">
                    <input type="date" name="tanggal_dari" class="form-control form-control-sm"
                        placeholder="Dari tanggal" value="{{ request('tanggal_dari') }}">
                    <input type="date" name="tanggal_sampai" class="form-control form-control-sm"
                        placeholder="Sampai tanggal" value="{{ request('tanggal_sampai') }}">
                    <button type="submit" class="btn btn-primary btn-sm px-3" title="Filter">
                        <img src="{{ asset('assets/icons/filter-outline.svg') }}" width="18" height="18"
                            alt="Filter" style="filter: invert(100%);">
                    </button>
                    <a href="{{ route('admin.history.index') }}" class="btn btn-warning btn-sm px-3" title="Reset Filter">
                        <img src="{{ asset('assets/icons/refresh-outline.svg') }}" width="18" height="18"
                            alt="Reset" style="filter: invert(100%);">
                    </a>
                </form>
                <div>
                    <span class="badge bg-info">Total: {{ $historyLelang->count() }} lelang</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Barang</th>
                            <th>Tanggal Lelang</th>
                            <th>Harga Awal</th>
                            <th>Harga Akhir</th>
                            <th>Pemenang</th>
                            <th>Petugas</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historyLelang as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($item->barang->gambarPrimary)
                                        <img src="{{ asset('storage/barang/' . $item->barang->gambarPrimary->gambar) }}"
                                            class="rounded" width="60" height="60" style="object-fit: cover;"
                                            alt="{{ $item->barang->nama_barang }}">
                                    @else
                                        <img src="{{ asset('assets/images/no-image.png') }}" class="rounded" width="60"
                                            height="60" style="object-fit: cover;" alt="No Image">
                                    @endif
                                </td>
                                <td>{{ $item->barang->nama_barang }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_lelang)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($item->barang->harga_awal, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-success">Rp
                                        {{ number_format($item->harga_akhir, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    {{ $item->pemenang->nama_lengkap }}
                                    <br><small class="text-muted">{{ $item->pemenang->telp }}</small>
                                </td>
                                <td>{{ $item->petugas->nama_petugas }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <!-- Detail Button -->
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->id_lelang }}" title="Detail">
                                            <img src="{{ asset('assets/icons/eye-outline.svg') }}" width="20"
                                                height="20" alt="Detail">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <img src="{{ asset('assets/icons/folder-open-outline.svg') }}" width="60"
                                        height="60" alt="Empty" style="opacity: 0.3;">
                                    <p class="text-muted mt-2">Belum ada history lelang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @foreach ($historyLelang as $item)
        @include('admin.modals.history.detail', ['lelang' => $item])
    @endforeach
@endsection
