<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan halaman profile
    public function index()
    {
        $petugas = auth()->guard('petugas')->user();
        return view('admin.pages.profile.index', compact('petugas'));
    }

    // Update profile
    public function update(Request $request)
    {
        $petugas = auth()->guard('petugas')->user();

        $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_petugas,username,' . $petugas->id_petugas . ',id_petugas',
        ], [
            'nama_petugas.required' => 'Nama petugas wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
        ]);

        $petugas->update([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile berhasil diperbarui');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $petugas = auth()->guard('petugas')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // Validasi password lama
        if (!Hash::check($request->current_password, $petugas->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        $petugas->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.profile')->with('success', 'Password berhasil diperbarui');
    }
}
