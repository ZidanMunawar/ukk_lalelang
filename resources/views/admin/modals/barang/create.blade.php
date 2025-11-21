<!-- Modal Create Barang -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Lelang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                                placeholder="Masukkan nama barang" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tgl" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tgl') is-invalid @enderror" id="tgl"
                                name="tgl" value="{{ date('Y-m-d') }}" readonly required>
                            @error('tgl')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="harga_awal" class="form-label">Harga Awal</label>
                            <input type="number" class="form-control @error('harga_awal') is-invalid @enderror"
                                id="harga_awal" name="harga_awal" value="{{ old('harga_awal') }}"
                                placeholder="Masukkan harga awal" min="0" required>
                            @error('harga_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="deskripsi_barang" class="form-label">Deskripsi Barang</label>
                            <textarea class="form-control @error('deskripsi_barang') is-invalid @enderror" id="deskripsi_barang"
                                name="deskripsi_barang" rows="3" placeholder="Masukkan deskripsi barang" required>{{ old('deskripsi_barang') }}</textarea>
                            @error('deskripsi_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="gambar" class="form-label">Gambar Barang (Multiple)</label>
                            <input type="file" class="form-control @error('gambar.*') is-invalid @enderror"
                                id="gambar" name="gambar[]" multiple accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, JPEG. Max 3MB per gambar. Gambar pertama akan
                                jadi gambar utama. Rekomendasi gambar 1:1. </small>
                            @error('gambar.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div id="preview-container" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('gambar').addEventListener('change', function(e) {
        const preview = document.getElementById('preview-container');
        preview.innerHTML = '';

        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'position-relative';
                div.innerHTML = `
                <img src="${e.target.result}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                ${i === 0 ? '<span class="badge bg-primary position-absolute top-0 end-0 m-1">Utama</span>' : ''}
            `;
                preview.appendChild(div);
            }

            reader.readAsDataURL(file);
        }
    });
</script>
