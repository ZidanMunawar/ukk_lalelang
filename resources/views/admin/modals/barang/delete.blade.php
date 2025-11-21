<!-- Modal Delete Barang -->
<div class="modal fade" id="deleteModal{{ $barang->id_barang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    @if ($barang->gambarPrimary)
                        <img src="{{ asset('storage/barang/' . $barang->gambarPrimary->gambar) }}" class="rounded"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="{{ $barang->nama_barang }}">
                    @endif
                </div>
                <p>Apakah Anda yakin ingin menghapus barang <strong>{{ $barang->nama_barang }}</strong>?</p>
                <p class="text-danger"><small>Semua gambar dan data terkait akan dihapus permanen!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.barang.delete', $barang->id_barang) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <img src="{{ asset('assets/icons/trash-outline.svg') }}" width="18" height="18"
                            alt="Delete" style="filter: invert(100%); margin-right: 5px;">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
