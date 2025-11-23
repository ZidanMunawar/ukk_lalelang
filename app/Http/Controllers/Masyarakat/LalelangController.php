<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LalelangController extends Controller
{
    // Menampilkan halaman daftar lelang untuk masyarakat
    public function index(Request $request)
    {
        // Ambil parameter filter dari URL
        $status = $request->get('status');
        $search = $request->get('search');

        // Siapkan query dasar untuk mengambil data lelang
        // Hanya tampilkan lelang yang belum ada pemenangnya
        $query = Lelang::with(['barang.gambarPrimary', 'barang.gambar', 'historyLelang.user'])
            ->whereNull('id_user');

        // Filter berdasarkan status lelang
        if ($status === 'coming') {
            // Lelang yang akan datang: status masih ditutup
            $query->where('status', 'ditutup');
        } elseif ($status === 'dibuka') {
            // Lelang yang sedang berlangsung: status sudah dibuka
            $query->where('status', 'dibuka');
        }

        // Filter berdasarkan kata kunci pencarian
        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                // Cari berdasarkan nama barang atau deskripsi barang
                $q->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi_barang', 'like', '%' . $search . '%');
            });
        }

        // Ambil data lelang dan urutkan berdasarkan tanggal terbaru
        $lelangs = $query->orderBy('tgl_lelang', 'desc')->get();

        // Tampilkan halaman lelang dengan data yang sudah difilter
        return view('masyarakat.lelang', compact('lelangs', 'status', 'search'));
    }

    // Fungsi untuk melakukan penawaran pada lelang
    public function bid(Request $request, $id_lelang)
    {
        // Validasi input harga penawaran
        $request->validate([
            'penawaran_harga' => 'required|integer|min:1'
        ]);

        // Cari data lelang berdasarkan ID
        $lelang = Lelang::findOrFail($id_lelang);
        // Ambil data user yang sedang login
        $user = Auth::guard('masyarakat')->user();
        // Ambil harga penawaran dari input form
        $penawaran_harga = $request->penawaran_harga;

        // Cek apakah lelang masih terbuka untuk penawaran
        if ($lelang->status !== 'dibuka') {
            return redirect()->back()->with('error', 'Lelang sudah ditutup.');
        }

        // Cek apakah harga penawaran lebih tinggi dari harga saat ini
        if ($penawaran_harga <= $lelang->harga_akhir) {
            return redirect()->back()->with('error', 'Penawaran harus lebih tinggi dari harga saat ini.');
        }

        // Hitung kenaikan minimal yang diperbolehkan
        $increment = $this->calculateIncrement($lelang->harga_akhir);
        // Cek apakah penawaran memenuhi syarat kenaikan minimal
        if ($penawaran_harga < $lelang->harga_akhir + $increment) {
            $minimal_penawaran = number_format($lelang->harga_akhir + $increment, 0, ',', '.');
            return redirect()->back()->with('error', 'Penawaran minimal harus Rp ' . $minimal_penawaran);
        }

        // Proses penyimpanan penawaran
        try {
            // Simpan history penawaran ke database
            HistoryLelang::create([
                'id_lelang' => $lelang->id_lelang,
                'id_barang' => $lelang->id_barang,
                'id_user' => $user->id_user,
                'penawaran_harga' => $penawaran_harga,
            ]);

            // Update harga akhir lelang dengan penawaran terbaru
            // Belum menentukan pemenang, hanya update harga
            $lelang->update([
                'harga_akhir' => $penawaran_harga
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Penawaran berhasil diajukan!');

        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi untuk menghitung kenaikan harga minimal berdasarkan harga saat ini
    private function calculateIncrement($currentPrice)
    {
        // Aturan kenaikan harga berdasarkan range harga
        if ($currentPrice <= 500000) {
            return 10000; // Untuk harga <= 500rb, kenaikan minimal 10rb
        } elseif ($currentPrice <= 2000000) {
            return 50000; // Untuk harga <= 2jt, kenaikan minimal 50rb
        } elseif ($currentPrice <= 10000000) {
            return 100000; // Untuk harga <= 10jt, kenaikan minimal 100rb
        } elseif ($currentPrice <= 50000000) {
            return 500000; // Untuk harga <= 50jt, kenaikan minimal 500rb
        } else {
            return 1000000; // Untuk harga di atas 50jt, kenaikan minimal 1jt
        }
    }
}
