<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LalelangController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Lelang::with(['barang.gambarPrimary', 'barang.gambar', 'historyLelang.user'])
            ->whereNull('id_user'); // Hanya tampilkan yang belum ada pemenang (belum selesai)

        // Filter berdasarkan status
        if ($status === 'coming') {
            // Lelang yang akan datang: status ditutup
            $query->where('status', 'ditutup');
        } elseif ($status === 'dibuka') {
            // Lelang sedang berlangsung: status dibuka
            $query->where('status', 'dibuka');
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi_barang', 'like', '%' . $search . '%');
            });
        }

        $lelangs = $query->orderBy('tgl_lelang', 'desc')->get();

        return view('masyarakat.lelang', compact('lelangs', 'status', 'search'));
    }

    public function bid(Request $request, $id_lelang)
    {
        $request->validate([
            'penawaran_harga' => 'required|integer|min:1'
        ]);

        $lelang = Lelang::findOrFail($id_lelang);
        $user = Auth::guard('masyarakat')->user();
        $penawaran_harga = $request->penawaran_harga;

        // Validasi status lelang
        if ($lelang->status !== 'dibuka') {
            return redirect()->back()->with('error', 'Lelang sudah ditutup.');
        }

        // Validasi harga penawaran harus lebih tinggi dari harga akhir saat ini
        if ($penawaran_harga <= $lelang->harga_akhir) {
            return redirect()->back()->with('error', 'Penawaran harus lebih tinggi dari harga saat ini.');
        }

        // Validasi increment
        $increment = $this->calculateIncrement($lelang->harga_akhir);
        if ($penawaran_harga < $lelang->harga_akhir + $increment) {
            return redirect()->back()->with('error', 'Penawaran minimal harus ' . number_format($lelang->harga_akhir + $increment, 0, ',', '.'));
        }

        try {
            // Create history lelang
            HistoryLelang::create([
                'id_lelang' => $lelang->id_lelang,
                'id_barang' => $lelang->id_barang,
                'id_user' => $user->id_user,
                'penawaran_harga' => $penawaran_harga,
            ]);

            // Update harga akhir lelang saja, jangan set pemenang dulu
            $lelang->update([
                'harga_akhir' => $penawaran_harga
            ]);

            return redirect()->back()->with('success', 'Penawaran berhasil diajukan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function calculateIncrement($currentPrice)
    {
        if ($currentPrice <= 500000) {
            return 10000;
        } elseif ($currentPrice <= 2000000) {
            return 50000;
        } elseif ($currentPrice <= 10000000) {
            return 100000;
        } elseif ($currentPrice <= 50000000) {
            return 500000;
        } else {
            return 1000000;
        }
    }
}
