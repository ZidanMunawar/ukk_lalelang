<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login petugas/admin
    public function showLoginForm()
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::guard('petugas')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // Proses login petugas/admin
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // Ambil credentials dari request
        $credentials = $request->only('username', 'password');

        // Coba login menggunakan guard petugas
        if (Auth::guard('petugas')->attempt($credentials, $request->filled('remember'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard dengan pesan sukses
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::guard('petugas')->user()->nama_petugas);
        }

        // Jika login gagal, kembali ke halaman login dengan error
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput($request->only('username'));
    }

    // Proses logout petugas/admin
    public function logout(Request $request)
    {
        // Logout dari guard petugas
        Auth::guard('petugas')->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan
        return redirect()->route('admin.login')
            ->with('success', 'Logout berhasil');
    }
}
