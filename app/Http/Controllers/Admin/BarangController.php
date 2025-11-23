<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\GambarBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Menampilkan halaman index barang
    public function index(Request $request)
    {
        $query = Barang::with('gambar')->latest();

        // Filter pencarian nama barang jika ada input pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_barang', 'like', "%{$search}%");
        }

        $barang = $query->get();

        return view('admin.pages.barang.index', compact('barang'));
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        // Pre-process harga_awal untuk menghilangkan karakter non-numeric
        if ($request->has('harga_awal')) {
            $request->merge([
                'harga_awal' => (int) preg_replace('/[^0-9]/', '', $request->harga_awal)
            ]);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:50',
            'harga_awal' => 'required|numeric|min:0|max:999999999999999999', // 999 Kuadriliun
            'deskripsi_barang' => 'required|string',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'harga_awal.required' => 'Harga awal wajib diisi',
            'harga_awal.numeric' => 'Harga awal harus berupa angka',
            'harga_awal.min' => 'Harga awal tidak boleh negatif',
            'harga_awal.max' => 'Harga awal maksimal 999.999.999.999.999.999',
            'deskripsi_barang.required' => 'Deskripsi barang wajib diisi',
            'gambar.*.required' => 'Minimal upload 1 gambar',
            'gambar.*.image' => 'File harus berupa gambar',
            'gambar.*.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.*.max' => 'Ukuran gambar maksimal 3MB',
        ]);

        // Simpan data barang dengan tanggal otomatis hari ini
        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'tgl' => date('Y-m-d'),
            'harga_awal' => $request->harga_awal,
            'deskripsi_barang' => $request->deskripsi_barang,
        ]);

        // Simpan gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/barang', $filename);

                GambarBarang::create([
                    'id_barang' => $barang->id_barang,
                    'gambar' => $filename,
                    'is_primary' => $index === 0 ? true : false,
                ]);
            }
        }

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil ditambahkan');
    }

    // Mengupdate data barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        // Pre-process harga_awal untuk menghilangkan karakter non-numeric
        if ($request->has('harga_awal')) {
            $request->merge([
                'harga_awal' => (int) preg_replace('/[^0-9]/', '', $request->harga_awal)
            ]);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:50',
            'harga_awal' => 'required|numeric|min:0|max:999999999999999999', // 999 Kuadriliun
            'deskripsi_barang' => 'required|string',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'harga_awal.required' => 'Harga awal wajib diisi',
            'harga_awal.numeric' => 'Harga awal harus berupa angka',
            'harga_awal.min' => 'Harga awal tidak boleh negatif',
            'harga_awal.max' => 'Harga awal maksimal 999.999.999.999.999.999',
            'deskripsi_barang.required' => 'Deskripsi barang wajib diisi',
            'gambar.*.image' => 'File harus berupa gambar',
            'gambar.*.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.*.max' => 'Ukuran gambar maksimal 3MB',
        ]);

        // Update data barang tanpa mengubah tanggal
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'harga_awal' => $request->harga_awal,
            'deskripsi_barang' => $request->deskripsi_barang,
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/barang', $filename);

                GambarBarang::create([
                    'id_barang' => $barang->id_barang,
                    'gambar' => $filename,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil diupdate');
    }

    // Menghapus gambar barang
    public function deleteImage($id)
    {
        $gambar = GambarBarang::findOrFail($id);

        // Hapus file dari storage
        if (Storage::exists('public/barang/' . $gambar->gambar)) {
            Storage::delete('public/barang/' . $gambar->gambar);
        }

        $gambar->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }

    // Set gambar sebagai primary
    public function setPrimary($id)
    {
        $gambar = GambarBarang::findOrFail($id);

        // Reset semua gambar barang ini menjadi tidak primary
        GambarBarang::where('id_barang', $gambar->id_barang)->update(['is_primary' => false]);

        // Set gambar ini sebagai primary
        $gambar->update(['is_primary' => true]);

        return redirect()->back()->with('success', 'Gambar utama berhasil diubah');
    }

    // Menghapus data barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus semua gambar dari storage
        foreach ($barang->gambar as $gambar) {
            if (Storage::exists('public/barang/' . $gambar->gambar)) {
                Storage::delete('public/barang/' . $gambar->gambar);
            }
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil dihapus');
    }
}
