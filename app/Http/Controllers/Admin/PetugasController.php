<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // Menampilkan halaman index petugas
    public function index(Request $request)
    {
        $query = Petugas::with('level')->latest();

        // Batasi akses untuk administrator saja
        if (auth()->guard('petugas')->user()->level->level !== 'administrator') {
            abort(403, 'Unauthorized');
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_petugas', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $petugas = $query->get();
        $levels = Level::all();

        return view('admin.pages.petugas.index', compact('petugas', 'levels'));
    }

    // Menyimpan data petugas baru
    public function store(Request $request)
    {
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

        Petugas::create([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'id_level' => $request->id_level,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil ditambahkan');
    }

    // Mengupdate data petugas
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

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

        $petugas->update([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'id_level' => $request->id_level,
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6',
            ], [
                'password.min' => 'Password minimal 6 karakter',
            ]);

            $petugas->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diupdate');
    }

    // Menghapus data petugas
    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        // Cek jika petugas yang akan dihapus adalah user yang sedang login
        if (auth()->guard('petugas')->user()->id_petugas == $id) {
            return redirect()->route('admin.petugas.index')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil dihapus');
    }
}
