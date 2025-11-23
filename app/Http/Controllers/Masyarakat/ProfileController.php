<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Menampilkan halaman profile masyarakat
    public function index()
    {
        // Ambil data user masyarakat yang sedang login
        $user = Auth::guard('masyarakat')->user();

        // Tampilkan halaman profile dengan data user
        return view('masyarakat.profile', compact('user'));
    }

    // Mengupdate data profile masyarakat
    public function update(Request $request)
    {
        // Ambil data user yang sedang login
        $user = Auth::guard('masyarakat')->user();

        // Validasi data yang diinput dari form
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:50',
            'telp' => 'required|string|max:25',
            'alamat' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            // Kembali ke halaman sebelumnya dengan error dan data input lama
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Proses update data
        try {
            // Siapkan data yang akan diupdate
            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
            ];

            // Cek jika user ingin mengubah password
            if ($request->filled('password')) {
                // Tambahkan password baru yang sudah dienkripsi ke data update
                $data['password'] = Hash::make($request->password);
            }

            // Update data user di database
            $user->update($data);

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Profile berhasil diperbarui!');

        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
