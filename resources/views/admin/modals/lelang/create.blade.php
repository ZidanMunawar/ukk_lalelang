<!-- Modal Create Lelang -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Lelang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.lelang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_barang" class="form-label">Pilih Barang</label>
                        <select class="form-select @error('id_barang') is-invalid @enderror" id="id_barang"
                            name="id_barang" required onchange="previewBarang(this)">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barangTersedia as $brg)
                                <option value="{{ $brg->id_barang }}"
                                    data-img="{{ $brg->gambarPrimary ? asset('storage/barang/' . $brg->gambarPrimary->gambar) : asset('assets/images/no-image.png') }}"
                                    data-harga="{{ $brg->harga_awal }}" data-desc="{{ $brg->deskripsi_barang }}"
                                    data-jumlah-foto="{{ $brg->gambar->count() ?? 0 }}">
                                    {{ $brg->nama_barang }}
                                </option>
                            @endforeach

                        </select>
                        @error('id_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Tanggal Lelang -->
                    <div class="mb-3">
                        <label for="tgl_lelang" class="form-label">Tanggal Lelang</label>
                        <input type="date" class="form-control @error('tgl_lelang') is-invalid @enderror"
                            id="tgl_lelang" name="tgl_lelang" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                            required>
                        <small class="text-muted">Tanggal lelang minimal hari ini</small>
                        @error('tgl_lelang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <!-- Preview Barang -->
                    <div id="preview-barang" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <img id="preview-img" src="" class="img-fluid rounded" alt="Preview">
                                    </div>
                                    <div class="col-7">
                                        <p class="mb-1"><strong>Harga Awal:</strong></p>
                                        <p id="preview-harga" class="text-success fw-bold mb-2"></p>
                                        <p class="mb-1"><strong>Deskripsi:</strong></p>
                                        <p id="preview-desc" class="text-muted small mb-0"></p>
                                        <p><strong>Jumlah Foto:</strong> <span id="preview-jumlah-foto">0</span></p>
                                        <p><strong>ID Barang:</strong> <span id="preview-id-barang">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="alert alert-warning mt-3" role="alert">
                        <small>
                            <img src="{{ asset('assets/icons/information-circle-outline.svg') }}" width="16"
                                height="16" alt="Info">
                            Lelang akan dibuat dengan status <strong>DITUTUP</strong>. Silakan buka lelang secara manual
                            untuk memulai penawaran.
                        </small>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <small>
                            <img src="{{ asset('assets/icons/checkmark-circle-outline.svg') }}" width="16"
                                height="16" alt="Info">
                            Barang yang sama dapat dilelang berkali-kali
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Lelang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewBarang(select) {
        const option = select.options[select.selectedIndex];
        const preview = document.getElementById('preview-barang');

        if (option.value) {
            document.getElementById('preview-img').src = option.dataset.img;
            document.getElementById('preview-harga').textContent = 'Rp ' + parseInt(option.dataset.harga)
                .toLocaleString('id-ID');
            document.getElementById('preview-desc').textContent = option.dataset.desc;

            // Update Jumlah Foto dan ID Barang
            document.getElementById('preview-jumlah-foto').textContent = option.dataset.jumlahFoto || '0';
            document.getElementById('preview-id-barang').textContent = option.value;

            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
            document.getElementById('preview-jumlah-foto').textContent = '0';
            document.getElementById('preview-id-barang').textContent = '-';
        }
    }
</script>
