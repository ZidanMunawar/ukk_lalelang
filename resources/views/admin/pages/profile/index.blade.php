@extends('admin.layouts.main')

@section('title', 'Profile')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Profile',
        'subtitle' => 'Profile Saya',
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
            <img src="{{ asset('assets/icons/close-circle-outline.svg') }}" width="20" height="20" alt="Error">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Card Profile -->
        <div class="col-lg-4">
            <div class="card radius-10">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ asset('assets/images/avatars/klein moretti.jpeg') }}" class="rounded-circle"
                            width="120" height="120" alt="Avatar">
                    </div>
                    <h5 class="mb-1">{{ $petugas->nama_petugas }}</h5>
                    <p class="text-muted mb-3">
                        <img src="{{ asset('assets/icons/shield-checkmark-outline.svg') }}" width="16" height="16"
                            alt="Level">
                        {{ ucfirst($petugas->level->level) }}
                    </p>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            <img src="{{ asset('assets/icons/create-outline.svg') }}" width="18" height="18"
                                alt="Edit" style="filter: invert(100%);">
                            Edit Profile
                        </button>
                        <button type="button" class="btn btn-warning px-4" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            <img src="{{ asset('assets/icons/key-outline.svg') }}" width="18" height="18"
                                alt="Password" style="filter: invert(100%);">
                            Ubah Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Informasi -->
        <div class="col-lg-8">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="mb-0">
                            <img src="{{ asset('assets/icons/person-outline.svg') }}" width="24" height="24"
                                alt="Profile">
                            Informasi Profile
                        </h5>
                    </div>
                    <div class="my-3 border-top"></div>

                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <p class="mb-0 fw-bold">Nama Lengkap</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $petugas->nama_petugas }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <p class="mb-0 fw-bold">Username</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $petugas->username }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <p class="mb-0 fw-bold">Level Akses</p>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-primary">{{ ucfirst($petugas->level->level) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <p class="mb-0 fw-bold">Terdaftar Sejak</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $petugas->created_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <p class="mb-0 fw-bold">Terakhir Update</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $petugas->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Card Keamanan -->
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="mb-0">
                            <img src="{{ asset('assets/icons/shield-outline.svg') }}" width="24" height="24"
                                alt="Keamanan">
                            Keamanan Akun
                        </h5>
                    </div>
                    <div class="my-3 border-top"></div>
                    <p class="text-muted mb-3">
                        <img src="{{ asset('assets/icons/information-circle-outline.svg') }}" width="18"
                            height="18" alt="Info">
                        Untuk keamanan akun, disarankan untuk mengganti password secara berkala.
                    </p>
                    <button type="button" class="btn btn-warning px-4 rounded-0" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">
                        <img src="{{ asset('assets/icons/key-outline.svg') }}" width="18" height="18"
                            alt="Password" style="filter: invert(100%);">
                        Ganti Password
                    </button>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.profile.edit')
    @include('admin.modals.profile.password')
@endsection
