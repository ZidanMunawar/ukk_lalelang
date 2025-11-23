<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan halaman profile petugas
    public function index()
    {
        // Ambil data petugas yang sedang login
        $petugas = auth()->guard('petugas')->user();

        // Tampilkan halaman profile dengan data petugas
        return view('admin.pages.profile.index', compact('petugas'));
    }

    // Mengupdate data profile petugas
    public function update(Request $request)
    {
        // Ambil data petugas yang sedang login
        $petugas = auth()->guard('petugas')->user();

        // Validasi data yang diinput dari form
        $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_petugas,username,' . $petugas->id_petugas . ',id_petugas',
        ], [
            'nama_petugas.required' => 'Nama petugas wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
        ]);

        // Update data profile petugas
        $petugas->update([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
        ]);

        // Redirect kembali ke halaman profile dengan pesan sukses
        return redirect()->route('admin.profile')->with('success', 'Profile berhasil diperbarui');
    }

    // Mengupdate password petugas
    public function updatePassword(Request $request)
    {
        // Ambil data petugas yang sedang login
        $petugas = auth()->guard('petugas')->user();

        // Validasi data password yang diinput
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // Cek apakah password lama yang diinput sesuai dengan password di database
        if (!Hash::check($request->current_password, $petugas->password)) {
            // Jika tidak sesuai, kembali dengan pesan error
            return back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password dengan password baru yang sudah dienkripsi
        $petugas->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Redirect kembali ke halaman profile dengan pesan sukses
        return redirect()->route('admin.profile')->with('success', 'Password berhasil diperbarui');
    }
}
