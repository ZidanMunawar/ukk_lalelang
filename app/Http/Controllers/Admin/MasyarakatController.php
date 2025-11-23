<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MasyarakatController extends Controller
{
    // Menampilkan halaman daftar masyarakat
    public function index(Request $request)
    {
        // Cek apakah user yang login adalah administrator
        // Jika bukan, tampilkan error akses ditolak
        if (auth()->guard('petugas')->user()->level->level !== 'administrator') {
            abort(403, 'Unauthorized.');
        }

        // Siapkan query untuk mengambil data masyarakat
        $query = Masyarakat::latest();

        // Cek jika ada pencarian dari user
        if ($request->filled('search')) {
            $search = $request->input('search');
            // Cari berdasarkan nama lengkap atau NIK
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Ambil semua data masyarakat yang sudah difilter
        $masyarakat = $query->get();

        // Tampilkan halaman index dengan data masyarakat
        return view('admin.pages.masyarakat.index', compact('masyarakat'));
    }

    // Menyimpan data masyarakat baru ke database
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'nik' => 'required|string|digits:16|unique:tb_masyarakat,nik',
            'telp' => 'required|string|max:25',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'telp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Simpan data masyarakat baru
        Masyarakat::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password), // Enkripsi password sebelum disimpan
            'status' => 'aktif', // Status default aktif
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.masyarakat.index')->with('success', 'Data masyarakat berhasil ditambahkan');
    }

    // Mengupdate data masyarakat yang sudah ada
    public function update(Request $request, $id)
    {
        // Cari data masyarakat berdasarkan ID
        $masyarakat = Masyarakat::findOrFail($id);

        // Validasi data input dari form
        $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'nik' => 'required|string|digits:16|unique:tb_masyarakat,nik,' . $id . ',id_user',
            'telp' => 'required|string|max:25',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'telp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        // Update data masyarakat
        $masyarakat->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'status' => $request->status,
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
            $masyarakat->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.masyarakat.index')->with('success', 'Data masyarakat berhasil diupdate');
    }

    // Mengubah status masyarakat (aktif/nonaktif)
    public function toggleStatus($id)
    {
        // Cari data masyarakat berdasarkan ID
        $masyarakat = Masyarakat::findOrFail($id);

        // Tentukan status baru: jika aktif jadi nonaktif, jika nonaktif jadi aktif
        $newStatus = $masyarakat->status === 'aktif' ? 'nonaktif' : 'aktif';

        // Update status masyarakat
        $masyarakat->update(['status' => $newStatus]);

        // Tentukan teks untuk pesan sukses
        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'diblokir';

        // Redirect dengan pesan sukses yang menyebutkan nama masyarakat
        return redirect()->route('admin.masyarakat.index')->with('success', "Akun {$masyarakat->nama_lengkap} berhasil {$statusText}");
    }

    // Menghapus data masyarakat dari database
    public function destroy($id)
    {
        // Cari data masyarakat berdasarkan ID
        $masyarakat = Masyarakat::findOrFail($id);

        // Hapus data masyarakat
        $masyarakat->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.masyarakat.index')->with('success', 'Data masyarakat berhasil dihapus');
    }
}
