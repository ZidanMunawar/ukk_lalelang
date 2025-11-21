<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('masyarakat')->user();
        return view('masyarakat.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('masyarakat')->user();

        $rules = [
            'nama_lengkap' => 'required|string|max:50',
            'telp' => 'required|string|max:25',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ];

        // Jika password diisi, validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        try {
            // Update data user
            $user->update([
                'nama_lengkap' => $validated['nama_lengkap'],
                'telp' => $validated['telp'],
                'alamat' => $validated['alamat'],
                'status' => $validated['status'],
            ]);

            // Update password jika diisi
            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($validated['password'])
                ]);
            }

            return redirect()->route('masyarakat.profile')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
