<!-- Modal Detail Masyarakat -->
<div class="modal fade" id="detailModal{{ $masyarakat->id_user }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Masyarakat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="40%"><strong>Nama Lengkap</strong></td>
                                <td>{{ $masyarakat->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>{{ $masyarakat->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Telepon</strong></td>
                                <td>{{ $masyarakat->telp }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>{{ $masyarakat->alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    <span class="badge bg-{{ $masyarakat->status === 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($masyarakat->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Terdaftar</strong></td>
                                <td>{{ $masyarakat->created_at->format('d F Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
