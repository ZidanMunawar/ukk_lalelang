<!-- Modal Detail Barang -->
<div class="modal fade" id="detailModal{{ $barang->id_barang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <!-- Gambar Utama -->
                        <div id="mainImage{{ $barang->id_barang }}" class="mb-3">
                            @if ($barang->gambarPrimary)
                                <img src="{{ asset('storage/barang/' . $barang->gambarPrimary->gambar) }}"
                                    class="img-fluid rounded" style="width: 100%; height: 300px; object-fit: cover;"
                                    alt="{{ $barang->nama_barang }}">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}" class="img-fluid rounded"
                                    style="width: 100%; height: 300px; object-fit: cover;" alt="No Image">
                            @endif
                        </div>

                        <!-- Gambar Lainnya -->
                        @if ($barang->gambar->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($barang->gambar as $img)
                                    <img src="{{ asset('storage/barang/' . $img->gambar) }}"
                                        class="rounded gallery-thumb-{{ $barang->id_barang }} {{ $img->is_primary ? 'border border-primary border-3' : 'border border-secondary' }}"
                                        style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                                        onclick="changeMainImage{{ $barang->id_barang }}('{{ asset('storage/barang/' . $img->gambar) }}', this)"
                                        alt="{{ $barang->nama_barang }}">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>Nama Barang</strong></td>
                                    <td>{{ $barang->nama_barang }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Awal</strong></td>
                                    <td><span class="badge bg-success">Rp
                                            {{ number_format($barang->harga_awal, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Terdaftar</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($barang->tgl)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Gambar</strong></td>
                                    <td>{{ $barang->gambar->count() }} gambar</td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi</strong></td>
                                    <td>{{ $barang->deskripsi_barang }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat</strong></td>
                                    <td>{{ $barang->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diubah</strong></td>
                                    <td>{{ $barang->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage{{ $barang->id_barang }}(src, element) {
        // Ganti gambar utama
        document.querySelector('#mainImage{{ $barang->id_barang }} img').src = src;

        // Reset semua border
        document.querySelectorAll('.gallery-thumb-{{ $barang->id_barang }}').forEach(function(img) {
            img.classList.remove('border-primary', 'border-3');
            img.classList.add('border-secondary');
        });

        // Set border pada gambar yang diklik
        element.classList.remove('border-secondary');
        element.classList.add('border-primary', 'border-3');
    }
</script>
