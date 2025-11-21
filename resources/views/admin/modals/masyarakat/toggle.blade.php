<!-- Modal Toggle Status Masyarakat -->
<div class="modal fade" id="toggleModal{{ $masyarakat->id_user }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $masyarakat->status === 'aktif' ? 'Blokir Akun' : 'Aktifkan Akun' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($masyarakat->status === 'aktif')
                    <p>Apakah Anda yakin ingin <strong class="text-danger">memblokir</strong> akun
                        <strong>{{ $masyarakat->nama_lengkap }}</strong>?</p>
                    <p class="text-muted"><small>Akun yang diblokir tidak dapat login ke sistem.</small></p>
                @else
                    <p>Apakah Anda yakin ingin <strong class="text-success">mengaktifkan</strong> akun
                        <strong>{{ $masyarakat->nama_lengkap }}</strong>?</p>
                    <p class="text-muted"><small>Akun yang diaktifkan dapat login kembali ke sistem.</small></p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.masyarakat.toggle', $masyarakat->id_user) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @if ($masyarakat->status === 'aktif')
                        <button type="submit" class="btn btn-danger">
                            <img src="{{ asset('assets/icons/ban-outline.svg') }}" width="18" height="18"
                                alt="Blokir" style="filter: invert(100%); margin-right: 5px;">
                            Ya, Blokir
                        </button>
                    @else
                        <button type="submit" class="btn btn-success">
                            <img src="{{ asset('assets/icons/checkmark-circle-outline.svg') }}" width="18"
                                height="18" alt="Aktifkan" style="filter: invert(100%); margin-right: 5px;">
                            Ya, Aktifkan
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
