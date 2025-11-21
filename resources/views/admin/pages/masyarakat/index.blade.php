@extends('admin.layouts.main')

@section('title', 'Data Masyarakat')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Data',
        'subtitle' => 'Masyarakat',
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
                <h5 class="mb-0">Data Masyarakat</h5>

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('admin.masyarakat.index') }}" class="d-flex ms-auto"
                    style="gap: 10px; min-width: 280px;">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari nama lengkap atau NIK" value="{{ request('search') }}">
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
                    Tambah Masyarakat
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($masyarakat as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('assets/images/avatars/Roblox.jpg') }}" class="rounded-circle"
                                            width="44" height="44" alt="">
                                        <div>
                                            <p class="mb-0">{{ $item->nama_lengkap }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->telp }}</td>
                                <td>{{ Str::limit($item->alamat, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status === 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <!-- Toggle Status Button -->
                                        <a href="javascript:;"
                                            class="text-{{ $item->status === 'aktif' ? 'danger' : 'success' }}"
                                            data-bs-toggle="modal" data-bs-target="#toggleModal{{ $item->id_user }}"
                                            title="{{ $item->status === 'aktif' ? 'Blokir' : 'Aktifkan' }}">
                                            <img src="{{ asset('assets/icons/' . ($item->status === 'aktif' ? 'ban-outline.svg' : 'checkmark-circle-outline.svg')) }}"
                                                width="20" height="20"
                                                alt="{{ $item->status === 'aktif' ? 'Blokir' : 'Aktifkan' }}">
                                        </a>

                                        <!-- Detail Button -->
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->id_user }}" title="Detail">
                                            <img src="{{ asset('assets/icons/eye-outline.svg') }}" width="20"
                                                height="20" alt="Detail">
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="javascript:;" class="text-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id_user }}" title="Edit">
                                            <img src="{{ asset('assets/icons/create-outline.svg') }}" width="20"
                                                height="20" alt="Edit">
                                        </a>

                                        <!-- Delete Button -->
                                        <a href="javascript:;" class="text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $item->id_user }}" title="Delete">
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
                                    <p class="text-muted mt-2">Tidak ada data masyarakat</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.masyarakat.create')
    @foreach ($masyarakat as $item)
        @include('admin.modals.masyarakat.toggle', ['masyarakat' => $item])
        @include('admin.modals.masyarakat.detail', ['masyarakat' => $item])
        @include('admin.modals.masyarakat.edit', ['masyarakat' => $item])
        @include('admin.modals.masyarakat.delete', ['masyarakat' => $item])
    @endforeach
@endsection
