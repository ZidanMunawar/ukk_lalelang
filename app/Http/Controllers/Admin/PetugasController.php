<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // Menampilkan halaman daftar petugas
    public function index(Request $request)
    {
        // Siapkan query untuk mengambil data petugas dengan relasi level
        $query = Petugas::with('level')->latest();

        // Cek apakah user yang login adalah administrator
        // Jika bukan, tampilkan error akses ditolak
        if (auth()->guard('petugas')->user()->level->level !== 'administrator') {
            abort(403, 'Unauthorized');
        }

        // Cek jika ada pencarian dari user
        if ($request->filled('search')) {
            $search = $request->input('search');
            // Cari berdasarkan nama petugas atau username
            $query->where(function ($q) use ($search) {
                $q->where('nama_petugas', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Ambil semua data petugas yang sudah difilter
        $petugas = $query->get();
        // Ambil semua data level untuk dropdown form
        $levels = Level::all();

        // Tampilkan halaman index dengan data petugas dan level
        return view('admin.pages.petugas.index', compact('petugas', 'levels'));
    }

    // Menyimpan data petugas baru ke database
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'nama_petugas' => 'required|string|max:25',
            'username' => 'required|string|max:25|unique:tb_petugas,username',
            'password' => 'required|string|min:6',
            'id_level' => 'required|exists:tb_level,id_level',
        ], [
            'nama_petugas.required' => 'Nama petugas wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'id_level.required' => 'Level wajib dipilih',
        ]);

        // Simpan data petugas baru ke database
        Petugas::create([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password sebelum disimpan
            'id_level' => $request->id_level,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil ditambahkan');
    }

    // Mengupdate data petugas yang sudah ada
    public function update(Request $request, $id)
    {
        // Cari data petugas berdasarkan ID
        $petugas = Petugas::findOrFail($id);

        // Validasi data input dari form
        $request->validate([
            'nama_petugas' => 'required|string|max:25',
            'username' => 'required|string|max:25|unique:tb_petugas,username,' . $id . ',id_petugas',
            'id_level' => 'required|exists:tb_level,id_level',
        ], [
            'nama_petugas.required' => 'Nama petugas wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'id_level.required' => 'Level wajib dipilih',
        ]);

        // Update data petugas
        $petugas->update([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'id_level' => $request->id_level,
        ]);

        // Cek jika user ingin mengupdate password
        if ($request->filled('password')) {
            // Validasi password baru
            $request->validate([
                'password' => 'min:6',
            ], [
                'password.min' => 'Password minimal 6 karakter',
            ]);

            // Update password dengan yang baru (dienkripsi)
            $petugas->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diupdate');
    }

    // Menghapus data petugas dari database
    public function destroy($id)
    {
        // Cari data petugas berdasarkan ID
        $petugas = Petugas::findOrFail($id);

        // Cek jika petugas yang akan dihapus adalah user yang sedang login
        // Mencegah user menghapus akun sendiri
        if (auth()->guard('petugas')->user()->id_petugas == $id) {
            return redirect()->route('admin.petugas.index')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        // Hapus data petugas dari database
        $petugas->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil dihapus');
    }
}
