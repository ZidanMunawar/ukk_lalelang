<!-- Modal Edit Masyarakat -->
<div class="modal fade" id="editModal{{ $masyarakat->id_user }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Masyarakat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.masyarakat.update', $masyarakat->id_user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_lengkap_edit{{ $masyarakat->id_user }}" class="form-label">Nama
                                Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap_edit{{ $masyarakat->id_user }}"
                                name="nama_lengkap" value="{{ $masyarakat->nama_lengkap }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nik_edit{{ $masyarakat->id_user }}" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik_edit{{ $masyarakat->id_user }}"
                                name="nik" value="{{ $masyarakat->nik }}" maxlength="16" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telp_edit{{ $masyarakat->id_user }}" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="telp_edit{{ $masyarakat->id_user }}"
                                name="telp" value="{{ $masyarakat->telp }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status_edit{{ $masyarakat->id_user }}" class="form-label">Status</label>
                            <select class="form-select" id="status_edit{{ $masyarakat->id_user }}" name="status"
                                required>
                                <option value="aktif" {{ $masyarakat->status === 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="nonaktif" {{ $masyarakat->status === 'nonaktif' ? 'selected' : '' }}>
                                    Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="alamat_edit{{ $masyarakat->id_user }}" class="form-label">Alamat
                                Lengkap</label>
                            <textarea class="form-control" id="alamat_edit{{ $masyarakat->id_user }}" name="alamat" rows="3" required>{{ $masyarakat->alamat }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="password_edit{{ $masyarakat->id_user }}" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_edit{{ $masyarakat->id_user }}"
                                name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
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
