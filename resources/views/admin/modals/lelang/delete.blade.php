<!-- Modal Delete Lelang -->
<div class="modal fade" id="deleteModal{{ $lelang->id_lelang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    @if ($lelang->barang->gambarPrimary)
                        <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                            class="rounded" style="width: 150px; height: 150px; object-fit: cover;"
                            alt="{{ $lelang->barang->nama_barang }}">
                    @endif
                </div>
                <p>Apakah Anda yakin ingin menghapus lelang untuk barang
                    <strong>{{ $lelang->barang->nama_barang }}</strong>?</p>
                <p class="text-danger"><small>Data lelang dan semua riwayat penawaran akan dihapus permanen!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.lelang.delete', $lelang->id_lelang) }}" method="POST"
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
