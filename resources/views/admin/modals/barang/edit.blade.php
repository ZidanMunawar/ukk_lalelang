<!-- Modal Edit Barang -->
<div class="modal fade" id="editModal{{ $barang->id_barang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.barang.update', $barang->id_barang) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_barang_edit{{ $barang->id_barang }}" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang_edit{{ $barang->id_barang }}"
                                name="nama_barang" value="{{ $barang->nama_barang }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tgl_edit{{ $barang->id_barang }}" class="form-label">Tanggal Terdaftar</label>
                            <input type="text" class="form-control" id="tgl_edit{{ $barang->id_barang }}"
                                value="{{ \Carbon\Carbon::parse($barang->tgl)->format('d F Y') }}" readonly
                                style="background-color: #e9ecef;">
                            {{-- <small class="text-muted">Tanggal tidak dapat diubah</small> --}}
                        </div>

                        <div class="col-12 mb-3">
                            <label for="harga_awal_edit{{ $barang->id_barang }}" class="form-label">Harga Awal</label>
                            <input type="number" class="form-control" id="harga_awal_edit{{ $barang->id_barang }}"
                                name="harga_awal" value="{{ $barang->harga_awal }}" min="0" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="deskripsi_barang_edit{{ $barang->id_barang }}" class="form-label">Deskripsi
                                Barang</label>
                            <textarea class="form-control" id="deskripsi_barang_edit{{ $barang->id_barang }}" name="deskripsi_barang"
                                rows="3" required>{{ $barang->deskripsi_barang }}</textarea>
                        </div>

                        <!-- Gambar yang sudah ada -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($barang->gambar as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/barang/' . $img->gambar) }}"
                                            class="rounded {{ $img->is_primary ? 'border border-primary border-3' : '' }}"
                                            style="width: 100px; height: 100px; object-fit: cover;"
                                            alt="{{ $barang->nama_barang }}">

                                        @if ($img->is_primary)
                                            <span class="badge bg-primary position-absolute top-0 end-0 m-1"
                                                style="font-size: 0.65rem;">Utama</span>
                                        @else
                                            <button type="button"
                                                class="btn btn-sm btn-info position-absolute top-0 start-0 m-1 p-1"
                                                style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;"
                                                onclick="setPrimaryImage{{ $barang->id_barang }}({{ $img->id_gambar }})"
                                                title="Jadikan Utama">
                                                <img src="{{ asset('assets/icons/star-outline.svg') }}" width="14"
                                                    height="14" alt="Primary" style="filter: invert(100%);">
                                            </button>
                                        @endif

                                        @if ($barang->gambar->count() > 1)
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-1 p-1"
                                                style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteImageModal{{ $img->id_gambar }}"
                                                title="Hapus Gambar">
                                                <img src="{{ asset('assets/icons/trash-outline.svg') }}" width="14"
                                                    height="14" alt="Delete" style="filter: invert(100%);">
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Upload gambar baru -->
                        <div class="col-12 mb-3">
                            <label for="gambar_edit{{ $barang->id_barang }}" class="form-label">Tambah Gambar Baru
                                (Opsional)</label>
                            <input type="file" class="form-control" id="gambar_edit{{ $barang->id_barang }}"
                                name="gambar[]" multiple accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, JPEG. Max 3MB per gambar.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form Hidden untuk Set Primary -->
<form id="setPrimaryForm{{ $barang->id_barang }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    function setPrimaryImage{{ $barang->id_barang }}(imageId) {
        if (confirm('Jadikan gambar ini sebagai gambar utama?')) {
            const form = document.getElementById('setPrimaryForm{{ $barang->id_barang }}');
            form.action = '/admin/barang/set-primary/' + imageId;
            form.submit();
        }
    }
</script>

<!-- Modal Konfirmasi Hapus Gambar (untuk setiap gambar) -->
@foreach ($barang->gambar as $img)
    @if (!$img->is_primary && $barang->gambar->count() > 1)
        <div class="modal fade" id="deleteImageModal{{ $img->id_gambar }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Gambar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/barang/' . $img->gambar) }}" class="img-fluid rounded mb-3"
                            style="max-height: 150px;" alt="{{ $barang->nama_barang }}">
                        <p>Hapus gambar ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.barang.delete.image', $img->id_gambar) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <img src="{{ asset('assets/icons/trash-outline.svg') }}" width="14"
                                    height="14" alt="Delete" style="filter: invert(100%); margin-right: 3px;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
