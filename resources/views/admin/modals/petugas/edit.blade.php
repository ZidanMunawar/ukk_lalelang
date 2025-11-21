<!-- Modal Edit Petugas -->
<div class="modal fade" id="editModal{{ $petugas->id_petugas }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.petugas.update', $petugas->id_petugas) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_petugas_edit{{ $petugas->id_petugas }}" class="form-label">Nama Petugas</label>
                        <input type="text" class="form-control" id="nama_petugas_edit{{ $petugas->id_petugas }}"
                            name="nama_petugas" value="{{ $petugas->nama_petugas }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="username_edit{{ $petugas->id_petugas }}" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username_edit{{ $petugas->id_petugas }}"
                            name="username" value="{{ $petugas->username }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_edit{{ $petugas->id_petugas }}" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password_edit{{ $petugas->id_petugas }}"
                            name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label for="id_level_edit{{ $petugas->id_petugas }}" class="form-label">Level</label>
                        <select class="form-select" id="id_level_edit{{ $petugas->id_petugas }}" name="id_level"
                            required>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id_level }}"
                                    {{ $petugas->id_level == $level->id_level ? 'selected' : '' }}>
                                    {{ ucfirst($level->level) }}
                                </option>
                            @endforeach
                        </select>
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
