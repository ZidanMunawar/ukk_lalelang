@extends('admin.layouts.main')

@section('title', 'Laporan Lelang')

@section('content')
    <!-- Breadcrumb -->
    @include('admin.partials.breadcrumb', [
        'title' => 'Laporan',
        'subtitle' => 'Laporan Lelang',
    ])

    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                <h5 class="mb-0">Data Laporan Lelang</h5>
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex gap-2 ms-auto"
                    style="min-width: 500px;">
                    @if (auth('petugas')->user()->id_level == 1) <!-- Hanya untuk admin -->
                        <select class="form-control form-control-sm" name="id_petugas">
                            <option value="">Semua Petugas</option>
                            @foreach ($petugasList as $petugas)
                                <option value="{{ $petugas->id_petugas }}"
                                    {{ request('id_petugas') == $petugas->id_petugas ? 'selected' : '' }}>
                                    {{ $petugas->nama_petugas }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    <input type="date" name="tanggal_dari" class="form-control form-control-sm"
                        placeholder="Dari tanggal" value="{{ request('tanggal_dari') }}">
                    <input type="date" name="tanggal_sampai" class="form-control form-control-sm"
                        placeholder="Sampai tanggal" value="{{ request('tanggal_sampai') }}">
                    <button type="submit" class="btn btn-primary btn-sm px-3" title="Filter">
                        <img src="{{ asset('assets/icons/filter-outline.svg') }}" width="18" height="18"
                            alt="Filter" style="filter: invert(100%);">
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-warning btn-sm px-3" title="Reset Filter">
                        <img src="{{ asset('assets/icons/refresh-outline.svg') }}" width="18" height="18"
                            alt="Reset" style="filter: invert(100%);">
                    </a>
                    <button type="button" class="btn btn-success btn-sm px-3" onclick="cetakLaporan()" title="Cetak">
                        <img src="{{ asset('assets/icons/print-outline.svg') }}" width="18" height="18"
                            alt="Cetak" style="filter: invert(100%);">
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                <span class="badge bg-info">Total: {{ $totalLelang }} lelang</span>
                <span class="badge bg-success">Total Harga: Rp {{ number_format($totalHargaAkhir, 0, ',', '.') }}</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>ID Lelang</th>
                            <th>Nama Petugas</th>
                            <th>Tanggal Lelang</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Nama Bid</th>
                            <th>Harga Bid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lelang as $index => $item)
                            @php
                                $pemenang = $item->pemenang;
                                $hargaTertinggi = $item->historyLelang->first();
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->id_lelang }}</td>
                                <td>{{ $item->petugas->nama_petugas }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_lelang)->format('d M Y') }}</td>
                                <td>{{ $item->barang->nama_barang }}</td>
                                <td>Rp {{ number_format($item->barang->harga_awal, 0, ',', '.') }}</td>
                                <td>
                                    @if ($pemenang)
                                        {{ $pemenang->nama_lengkap }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->harga_akhir > 0)
                                        <span class="badge bg-success">Rp
                                            {{ number_format($item->harga_akhir, 0, ',', '.') }}</span>
                                    @else
                                        <span class="badge bg-secondary">Rp 0</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == 'dibuka')
                                        <span class="badge bg-info">Dibuka</span>
                                    @elseif($item->status == 'ditutup')
                                        @if ($item->harga_akhir > 0)
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">Ditutup</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <img src="{{ asset('assets/icons/folder-open-outline.svg') }}" width="60"
                                        height="60" alt="Empty" style="opacity: 0.3;">
                                    <p class="text-muted mt-2">Tidak ada data lelang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function cetakLaporan() {
            // Ambil nilai filter dari form
            const idPetugas = document.querySelector('select[name="id_petugas"]') ? document.querySelector(
                'select[name="id_petugas"]').value : '';
            const tanggalDari = document.querySelector('input[name="tanggal_dari"]').value;
            const tanggalSampai = document.querySelector('input[name="tanggal_sampai"]').value;

            // Buat URL untuk cetak dengan parameter filter
            let url = "{{ route('admin.laporan.cetak') }}?";

            if (idPetugas) {
                url += `id_petugas=${idPetugas}&`;
            }
            if (tanggalDari) {
                url += `tanggal_dari=${tanggalDari}&`;
            }
            if (tanggalSampai) {
                url += `tanggal_sampai=${tanggalSampai}&`;
            }

            // Redirect ke URL cetak
            window.location.href = url;
        }
    </script>
@endpush
