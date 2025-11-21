<!-- Modal Toggle Status Lelang -->
<div class="modal fade" id="toggleModal{{ $lelang->id_lelang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $lelang->status === 'dibuka' ? 'Tutup Lelang' : 'Buka Lelang' }}
                </h5>
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

                @if ($lelang->status === 'dibuka')
                    <p>Apakah Anda yakin ingin <strong class="text-danger">menutup</strong> lelang untuk barang
                        <strong>{{ $lelang->barang->nama_barang }}</strong>?
                    </p>
                    <p class="text-muted"><small>Lelang yang ditutup tidak dapat menerima penawaran baru.</small></p>
                @else
                    <p>Apakah Anda yakin ingin <strong class="text-success">membuka kembali</strong> lelang untuk barang
                        <strong>{{ $lelang->barang->nama_barang }}</strong>?
                    </p>
                    <p class="text-muted"><small>Lelang yang dibuka dapat menerima penawaran dari masyarakat.</small>
                    </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.lelang.toggle', $lelang->id_lelang) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @if ($lelang->status === 'dibuka')
                        <button type="submit" class="btn btn-danger">
                            <img src="{{ asset('assets/icons/lock-closed-outline.svg') }}" width="18" height="18"
                                alt="Tutup" style="filter: invert(100%); margin-right: 5px;">
                            Ya, Tutup Lelang
                        </button>
                    @else
                        <button type="submit" class="btn btn-success">
                            <img src="{{ asset('assets/icons/lock-open-outline.svg') }}" width="18" height="18"
                                alt="Buka" style="filter: invert(100%); margin-right: 5px;">
                            Ya, Buka Lelang
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
