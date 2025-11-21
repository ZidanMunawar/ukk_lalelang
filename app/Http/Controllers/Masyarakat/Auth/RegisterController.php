<?php

namespace App\Http\Controllers\Masyarakat\Auth;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Menampilkan halaman register masyarakat
    public function showRegisterForm()
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::guard('masyarakat')->check()) {
            return redirect()->route('masyarakat.dashboard');
        }

        return view('masyarakat.auth.register');
    }

    // Proses registrasi masyarakat
    public function register(Request $request)
    {
        // Validasi input registrasi
        $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'nik' => 'required|string|digits:16|unique:tb_masyarakat,nik',
            'telp' => 'required|string|max:25',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 150 karakter',
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'telp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Buat akun masyarakat baru
        $masyarakat = Masyarakat::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'status' => 'aktif',
        ]);

        // Auto login setelah register
        Auth::guard('masyarakat')->login($masyarakat);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('masyarakat.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang ' . $masyarakat->nama_lengkap);
    }
}
