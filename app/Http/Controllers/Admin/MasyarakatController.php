<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MasyarakatController extends Controller
{
    // Menampilkan halaman index masyarakat
    public function index(Request $request)
    {
        // Batasi akses hanya untuk administrator
        if (auth()->guard('petugas')->user()->level->level !== 'administrator') {
            abort(403, 'Unauthorized.');
        }

        $query = Masyarakat::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $masyarakat = $query->get();

        return view('admin.pages.masyarakat.index', compact('masyarakat'));
    }


    // Menyimpan data masyarakat baru
    public function store(Request $request)
    {
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

        Masyarakat::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'status' => 'aktif',
        ]);

        return redirect()->route('admin.masyarakat.index')->with('success', 'Data masyarakat berhasil ditambahkan');
    }

    // Mengupdate data masyarakat
    public function update(Request $request, $id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

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

        $masyarakat->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6',
            ], [
                'password.min' => 'Password minimal 6 karakter',
            ]);

            $masyarakat->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.masyarakat.index')->with('success', 'Data masyarakat berhasil diupdate');
    }

    // Toggle status masyarakat (aktif/nonaktif)
    public function toggleStatus($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

        $newStatus = $masyarakat->status === 'aktif' ? 'nonaktif' : 'aktif';
        $masyarakat->update(['status' => $newStatus]);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'diblokir';
        return redirect()->route('admin.masyarakat.index')->with('success', "Akun {$masyarakat->nama_lengkap} berhasil {$statusText}");
    }

    // Menghapus data masyarakat
    public function destroy($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);
        $masyarakat->delete();

        return redirect()->route('admin.masyarakat.index')->with('success', 'Data masyarakat berhasil dihapus');
    }
}
