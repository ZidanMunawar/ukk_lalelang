@extends('admin.layouts.main')

@section('title', 'Data Petugas')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Data',
        'subtitle' => 'Petugas',
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
                <h5 class="mb-0">Data Petugas</h5>

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('admin.petugas.index') }}" class="d-flex ms-auto"
                    style="gap: 10px; min-width: 280px;">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari nama atau username" value="{{ request('search') }}">
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
                    Tambah Petugas
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Terdaftar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}"
                                            class="rounded-circle" width="44" height="44" alt="">
                                        <div>
                                            <p class="mb-0">{{ $item->nama_petugas }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->username }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $item->level->level === 'administrator' ? 'primary' : 'success' }}">
                                        {{ ucfirst($item->level->level) }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="javascript:;" class="text-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id_petugas }}" title="Edit">
                                            <img src="{{ asset('assets/icons/create-outline.svg') }}" width="20"
                                                height="20" alt="Edit">
                                        </a>
                                        <a href="javascript:;" class="text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $item->id_petugas }}" title="Delete">
                                            <img src="{{ asset('assets/icons/trash-outline.svg') }}" width="20"
                                                height="20" alt="Delete">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <img src="{{ asset('assets/icons/folder-open-outline.svg') }}" width="60"
                                        height="60" alt="Empty" style="opacity: 0.3;">
                                    <p class="text-muted mt-2">Tidak ada data petugas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.petugas.create')
    @foreach ($petugas as $item)
        @include('admin.modals.petugas.edit', ['petugas' => $item])
        @include('admin.modals.petugas.delete', ['petugas' => $item])
    @endforeach
@endsection
