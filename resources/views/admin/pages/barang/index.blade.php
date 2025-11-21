@extends('admin.layouts.main')

@section('title', 'Data Barang')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Data',
        'subtitle' => 'Barang',
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

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <img src="{{ asset('assets/icons/alert-circle.svg') }}" width="20" height="20" alt="Error"
                style="filter: invert(100%); margin-right: 8px;">
            <div class="flex-grow-1">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3 gap-3 flex-wrap">
                <h5 class="mb-0">Data Barang Lelang</h5>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.barang.index') }}" class="d-flex ms-auto"
                    style="gap: 10px; min-width: 280px;">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama barang"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center">
                        <img src="{{ asset('assets/icons/search-outline.svg') }}" width="18" height="18"
                            alt="Search" style="filter: invert(100%);">
                    </button>
                </form>

                <!-- Tombol Tambah -->
                <button type=" type="data-bs-toggle="modal" data-bs-target="#createModal""
                    class="btn btn-primary btn-sm d-flex align-items-center ">
                    <img src="{{ asset('assets/icons/add-outline.svg') }}" width="18" height="18" alt="Add"
                        style="filter: invert(100%); margin-right: 5px;">
                    Tambah Barang
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Harga Awal</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($item->gambarPrimary)
                                        <img src="{{ asset('storage/barang/' . $item->gambarPrimary->gambar) }}"
                                            class="rounded" width="60" height="60" style="object-fit: cover;"
                                            alt="{{ $item->nama_barang }}">
                                    @else
                                        <img src="{{ asset('assets/images/no-image.png') }}" class="rounded" width="60"
                                            height="60" style="object-fit: cover;" alt="No Image">
                                    @endif
                                </td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl)->format('d M Y') }}</td>
                                <td>{{ Str::limit($item->deskripsi_barang, 50) }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->id_barang }}" title="Detail">
                                            <img src="{{ asset('assets/icons/eye-outline.svg') }}" width="20"
                                                height="20" alt="Detail">
                                        </a>
                                        <a href="javascript:;" class="text-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id_barang }}" title="Edit">
                                            <img src="{{ asset('assets/icons/create-outline.svg') }}" width="20"
                                                height="20" alt="Edit">
                                        </a>
                                        <a href="javascript:;" class="text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $item->id_barang }}" title="Delete">
                                            <img src="{{ asset('assets/icons/trash-outline.svg') }}" width="20"
                                                height="20" alt="Delete">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <img src="{{ asset('assets/icons/folder-open-outline.svg') }}" width="60"
                                        height="60" alt="Empty" style="opacity: 0.3;">
                                    <p class="text-muted mt-2">Tidak ada data barang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.barang.create')
    @foreach ($barang as $item)
        @include('admin.modals.barang.detail', ['barang' => $item])
        @include('admin.modals.barang.edit', ['barang' => $item])
        @include('admin.modals.barang.delete', ['barang' => $item])
    @endforeach
@endsection
