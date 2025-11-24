<!-- Modal Detail Lelang -->
<div class="modal fade" id="detailModal{{ $lelang->id_lelang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Lelang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <!-- Gambar Utama -->
                        <div id="mainImageLelang{{ $lelang->id_lelang }}" class="mb-3">
                            @if ($lelang->barang->gambarPrimary)
                                <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                    class="img-fluid rounded" style="width: 100%; height: 300px; object-fit: cover;"
                                    alt="{{ $lelang->barang->nama_barang }}">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}" class="img-fluid rounded"
                                    style="width: 100%; height: 300px; object-fit: cover;" alt="No Image">
                            @endif
                        </div>

                        <!-- Gambar Lainnya -->
                        @if ($lelang->barang->gambar->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($lelang->barang->gambar as $img)
                                    <img src="{{ asset('storage/barang/' . $img->gambar) }}"
                                        class="rounded gallery-thumb-lelang-{{ $lelang->id_lelang }} {{ $img->is_primary ? 'border border-primary border-3' : 'border border-secondary' }}"
                                        style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                                        onclick="changeMainImageLelang{{ $lelang->id_lelang }}('{{ asset('storage/barang/' . $img->gambar) }}', this)"
                                        alt="{{ $lelang->barang->nama_barang }}">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <h5>{{ $lelang->barang->nama_barang }}</h5>
                        <hr>
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>Status Lelang</strong></td>
                                    <td>
                                        @if ($lelang->id_user != null)
                                            <span class="badge bg-info">Selesai</span>
                                        @elseif($lelang->status === 'dibuka')
                                            <span class="badge bg-success">Dibuka</span>
                                        @else
                                            <span class="badge bg-warning">Ditutup</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Lelang</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($lelang->tgl_lelang)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Awal</strong></td>
                                    <td>Rp {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Akhir</strong></td>
                                    <td>
                                        @if ($lelang->harga_akhir > 0)
                                            <span class="badge bg-success">Rp
                                                {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">Belum ada penawaran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pemenang</strong></td>
                                    <td>
                                        @if ($lelang->id_user != null && $lelang->pemenang)
                                            {{ $lelang->pemenang->nama_lengkap }}
                                            <br><small class="text-muted">NIK: {{ $lelang->pemenang->nik }}</small>
                                            <br><small class="text-muted">Telp: {{ $lelang->pemenang->telp }}</small>
                                            <br><small class="text-muted">Alamat:
                                                {{ $lelang->pemenang->alamat }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Petugas</strong></td>
                                    <td>{{ $lelang->petugas->nama_petugas }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Penawaran</strong></td>
                                    <td>{{ $lelang->historyLelang->count() }} penawaran</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- History Penawaran -->
                @if ($lelang->historyLelang->count() > 0)
                    <hr>
                    <h6>Riwayat Penawaran</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Pembid</th>
                                    <th>Penawaran</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lelang->historyLelang->sortByDesc('created_at') as $history)
                                    <tr>
                                        <td>{{ $history->user->nama_lengkap }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $history->penawaran_harga == $lelang->harga_akhir ? 'success' : 'secondary' }}">
                                                Rp {{ number_format($history->penawaran_harga, 0, ',', '.') }}
                                            </span>
                                            @if ($history->penawaran_harga == $lelang->harga_akhir && $lelang->harga_akhir > 0)
                                                <small class="text-success">✓ Tertinggi</small>
                                            @endif
                                        </td>
                                        <td><small>{{ $history->created_at->format('d/m/Y H:i') }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImageLelang{{ $lelang->id_lelang }}(src, element) {
        // Ganti gambar utama
        document.querySelector('#mainImageLelang{{ $lelang->id_lelang }} img').src = src;

        // Reset semua border
        document.querySelectorAll('.gallery-thumb-lelang-{{ $lelang->id_lelang }}').forEach(function(img) {
            img.classList.remove('border-primary', 'border-3');
            img.classList.add('border-secondary');
        });

        // Set border pada gambar yang diklik
        element.classList.remove('border-secondary');
        element.classList.add('border-primary', 'border-3');
    }
</script>
