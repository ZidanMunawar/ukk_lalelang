<!-- Modal Delete Masyarakat -->
<div class="modal fade" id="deleteModal{{ $masyarakat->id_user }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data masyarakat <strong>{{ $masyarakat->nama_lengkap }}</strong>?
                </p>
                <p class="text-danger"><small>Data yang sudah dihapus tidak dapat dikembalikan!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.masyarakat.delete', $masyarakat->id_user) }}" method="POST"
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
