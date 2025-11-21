@extends('masyarakat.layouts.main')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')
@section('breadcrumb_active', 'Profil')

@section('content')

    <!-- ==========Profile Section start Here========== -->
    <section class="login-section light-version padding-top padding-bottom">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-4">
                    <div class="account-img text-center">
                        <div class="profile-avatar mb-4">
                            <img src="{{ asset('assets/images/avatars/Roblox.jpg') }}" alt="Profile Avatar"
                                class="rounded-circle"
                                style="width: 200px; height: 200px; object-fit: cover; border: 5px solid var(--theme-color);">
                        </div>
                        <h3 class="mb-2">{{ Auth::guard('masyarakat')->user()->nama_lengkap }}</h3>
                        <p class="text-muted mb-3">Anggota Masyarakat</p>

                        <!-- Statistik Profile -->
                        <div class="profile-stats row text-center">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h5 class="mb-1 text-primary">
                                        {{ Auth::guard('masyarakat')->user()->historyLelang->count() }}</h5>
                                    <small class="text-muted">Total Bid</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h5 class="mb-1 text-success">{{ Auth::guard('masyarakat')->user()->lelang->count() }}
                                    </h5>
                                    <small class="text-muted">Menang</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h5 class="mb-1 text-warning">
                                        {{ Auth::guard('masyarakat')->user()->historyLelang->groupBy('id_lelang')->count() }}
                                    </h5>
                                    <small class="text-muted">Ikut Lelang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="account-wrapper">
                        <h3 class="title mb-4">Informasi Profil</h3>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="account-form" method="POST" action="{{ route('masyarakat.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                            placeholder="Nama Lengkap"
                                            value="{{ old('nama_lengkap', Auth::guard('masyarakat')->user()->nama_lengkap) }}"
                                            required />
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nik" name="nik"
                                            placeholder="NIK" value="{{ Auth::guard('masyarakat')->user()->nik }}" readonly
                                            style="background-color: #f8f9fa;" />
                                        <label for="nik">NIK</label>
                                        <small class="form-text text-muted">NIK tidak dapat diubah</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" id="telp" name="telp"
                                            placeholder="Nomor Telepon"
                                            value="{{ old('telp', Auth::guard('masyarakat')->user()->telp) }}" required />
                                        <label for="telp">Nomor Telepon</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat Lengkap" style="height: 100px;"
                                    required>{{ old('alamat', Auth::guard('masyarakat')->user()->alamat) }}</textarea>
                                <label for="alamat">Alamat Lengkap</label>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">Ubah Password</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password Baru" />
                                        <label for="password">Password Baru</label>
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                            password</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Konfirmasi Password" />
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="d-block default-btn move-top w-100">
                                    <span>Perbarui Profil</span>
                                </button>
                            </div>
                        </form>

                        <!-- Info Tambahan -->
                        <div class="account-bottom mt-4 pt-4 border-top">
                            <div class="additional-info">
                                <h6 class="mb-3">Informasi Tambahan</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="icofont-calendar me-2"></i>
                                            <strong>Terdaftar Sejak:</strong><br>
                                            {{ Auth::guard('masyarakat')->user()->created_at->format('d F Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="icofont-refresh me-2"></i>
                                            <strong>Terakhir Diupdate:</strong><br>
                                            {{ Auth::guard('masyarakat')->user()->updated_at->format('d F Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Profile Section ends Here========== -->

    <style>
        .profile-stats {
            background: rgba(var(--theme-rgb), 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .stat-item {
            padding: 10px;
        }

        .profile-avatar {
            position: relative;
            display: inline-block;
        }

        .profile-avatar::after {
            content: '';
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            background: var(--success-color);
            border: 3px solid white;
            border-radius: 50%;
        }

        .additional-info {
            background: rgba(var(--theme-rgb), 0.03);
            padding: 20px;
            border-radius: 10px;
        }

        .form-control:read-only {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
        }
    </style>

@endsection
