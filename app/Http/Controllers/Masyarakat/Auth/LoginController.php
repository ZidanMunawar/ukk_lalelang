<?php

namespace App\Http\Controllers\Masyarakat\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login masyarakat
    public function showLoginForm()
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::guard('masyarakat')->check()) {
            return redirect()->route('masyarakat.dashboard');
        }

        return view('masyarakat.auth.login');
    }

    // Proses login masyarakat
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'nik' => 'required|string|digits:16',
            'password' => 'required|string',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'password.required' => 'Password wajib diisi',
        ]);

        // Ambil credentials dari request
        $credentials = $request->only('nik', 'password');

        // Cek status akun masyarakat
        $masyarakat = \App\Models\Masyarakat::where('nik', $request->nik)->first();

        if ($masyarakat && $masyarakat->status === 'nonaktif') {
            return back()->withErrors([
                'nik' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ])->withInput($request->only('nik'));
        }

        // Coba login menggunakan guard masyarakat
        if (Auth::guard('masyarakat')->attempt($credentials, $request->filled('remember'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard dengan pesan sukses
            return redirect()->intended(route('masyarakat.dashboard'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::guard('masyarakat')->user()->nama_lengkap);
        }

        // Jika login gagal, kembali ke halaman login dengan error
        return back()->withErrors([
            'nik' => 'NIK atau password salah',
        ])->withInput($request->only('nik'));
    }

    // Proses logout masyarakat
    public function logout(Request $request)
    {
        // Logout dari guard masyarakat
        Auth::guard('masyarakat')->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan
        return redirect()->route('masyarakat.login')
            ->with('success', 'Logout berhasil');
    }
}
