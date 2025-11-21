@extends('admin.layouts.main')

@section('title', 'Kelola Lelang')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Lelang',
        'subtitle' => 'Kelola Lelang',
    ])

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <img src="{{ asset('assets/icons/checkmark-circle.svg') }}" width="20" height="20" alt="Success"
                style="filter: invert(100%);">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <img src="{{ asset('assets/icons/alert-circle.svg') }}" width="20" height="20" alt="Error"
                style="filter: invert(100%);">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3 gap-3 flex-wrap">
                <h5 class="mb-0">Data Lelang</h5>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.lelang.index') }}" class="d-flex"
                    style="gap:10px; margin-left:auto; min-width: 320px;">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari nama barang atau pemenang" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center">
                        <img src="{{ asset('assets/icons/search-outline.svg') }}" width="18" height="18"
                            alt="Search" style="filter: invert(100%);">
                    </button>
                </form>

                <!-- Tombol Tambah -->
                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <img src="{{ asset('assets/icons/add-outline.svg') }}" width="18" height="18" alt="Add"
                        style="filter: invert(100%); margin-right: 5px;">
                    Buat Lelang Baru
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Barang</th>
                            <th>Tanggal Lelang</th>
                            <th>Harga Akhir</th>
                            <th>Pemenang</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lelang as $index => $item)
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
                                <td>
                                    @if ($item->harga_akhir > 0)
                                        <span class="badge bg-success">Rp
                                            {{ number_format($item->harga_akhir, 0, ',', '.') }}</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Ada</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->id_user != 0 && $item->pemenang)
                                        {{ $item->pemenang->nama_lengkap }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->petugas->nama_petugas }}</td>
                                <td>
                                    @if ($item->id_user != 0)
                                        <span class="badge bg-info">Selesai</span>
                                    @elseif($item->status === 'dibuka')
                                        <span class="badge bg-success">
                                            <img src="{{ asset('assets/icons/lock-open-outline.svg') }}" width="14"
                                                height="14" alt="Dibuka" style="filter: invert(100%);">
                                            Dibuka
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <img src="{{ asset('assets/icons/lock-closed-outline.svg') }}" width="14"
                                                height="14" alt="Ditutup" style="filter: invert(100%);">
                                            Ditutup
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <!-- Toggle Status Button -->
                                        @if ($item->id_user == 0)
                                            <a href="javascript:;"
                                                class="text-{{ $item->status === 'dibuka' ? 'danger' : 'success' }}"
                                                data-bs-toggle="modal" data-bs-target="#toggleModal{{ $item->id_lelang }}"
                                                title="{{ $item->status === 'dibuka' ? 'Tutup Lelang' : 'Buka Lelang' }}">
                                                <img src="{{ asset('assets/icons/' . ($item->status === 'dibuka' ? 'lock-closed-outline.svg' : 'lock-open-outline.svg')) }}"
                                                    width="20" height="20" alt="Toggle">
                                            </a>
                                        @else
                                            <span class="text-muted" title="Lelang Selesai">
                                                <img src="{{ asset('assets/icons/checkmark-done-outline.svg') }}"
                                                    width="20" height="20" alt="Selesai" style="opacity: 0.5;">
                                            </span>
                                        @endif

                                        <!-- Detail Button -->
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->id_lelang }}" title="Detail">
                                            <img src="{{ asset('assets/icons/eye-outline.svg') }}" width="20"
                                                height="20" alt="Detail">
                                        </a>

                                        <!-- Delete Button -->
                                        {{-- @if ($item->id_user == 0) --}}
                                        <a href="javascript:;" class="text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $item->id_lelang }}" title="Delete">
                                            <img src="{{ asset('assets/icons/trash-outline.svg') }}" width="20"
                                                height="20" alt="Delete">
                                        </a>
                                        {{-- @endif --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <img src="{{ asset('assets/icons/folder-open-outline.svg') }}" width="60"
                                        height="60" alt="Empty" style="opacity: 0.3;">
                                    <p class="text-muted mt-2">Belum ada lelang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.lelang.create')
    @foreach ($lelang as $item)
        @include('admin.modals.lelang.toggle', ['lelang' => $item])
        @include('admin.modals.lelang.detail', ['lelang' => $item])
        @include('admin.modals.lelang.delete', ['lelang' => $item])
    @endforeach
@endsection
