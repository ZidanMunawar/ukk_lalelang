<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\Barang;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;

class LelangController extends Controller
{
    // Menampilkan halaman utama daftar lelang
    public function index(Request $request)
    {
        // Ambil data petugas yang sedang login
        $user = auth()->guard('petugas')->user();

        // Siapkan query untuk mengambil data lelang
        // Hanya ambil lelang yang ditangani oleh petugas yang login
        $query = Lelang::with(['barang.gambarPrimary', 'pemenang', 'petugas'])
            ->where('id_petugas', $user->id_petugas);

        // Cek jika ada pencarian dari user
        if ($request->filled('search')) {
            $search = $request->input('search');
            // Cari berdasarkan nama barang atau nama pemenang
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($q2) use ($search) {
                    $q2->where('nama_barang', 'like', "%{$search}%");
                })->orWhereHas('pemenang', function ($q3) use ($search) {
                    $q3->where('nama_lengkap', 'like', "%{$search}%");
                });
            });
        }

        // Ambil data lelang dan urutkan dari yang terbaru
        $lelang = $query->latest()->get();

        // Ambil semua data barang untuk form tambah lelang
        $barangTersedia = Barang::all();

        // Tampilkan halaman index dengan data lelang dan barang
        return view('admin.pages.lelang.index', compact('lelang', 'barangTersedia'));
    }

    // Menyimpan data lelang baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_barang' => 'required|exists:tb_barang,id_barang',
            'tgl_lelang' => 'required|date|after_or_equal:today',
        ], [
            'id_barang.required' => 'Barang wajib dipilih',
            'id_barang.exists' => 'Barang tidak ditemukan',
            'tgl_lelang.required' => 'Tanggal lelang wajib diisi',
            'tgl_lelang.date' => 'Format tanggal tidak valid',
            'tgl_lelang.after_or_equal' => 'Tanggal lelang tidak boleh di masa lalu',
        ]);

        // Simpan data lelang baru ke database
        Lelang::create([
            'id_barang' => $request->id_barang,
            'tgl_lelang' => $request->tgl_lelang,
            'harga_akhir' => 0, // Harga awal masih 0
            'id_user' => null, // Belum ada pemenang
            'id_petugas' => auth()->guard('petugas')->user()->id_petugas,
            'status' => 'ditutup', // Status awal ditutup, nanti bisa dibuka
        ]);

        // Redirect ke halaman lelang dengan pesan sukses
        return redirect()->route('admin.lelang.index')->with('success', 'Lelang berhasil dibuat. Silakan buka lelang untuk memulai penawaran');
    }

    // Mengubah status lelang (buka/tutup)
    public function toggleStatus($id)
    {
        $user = auth()->guard('petugas')->user();
        $lelang = Lelang::findOrFail($id);

        // Cek akses: petugas hanya bisa mengubah lelang miliknya sendiri
        // Kecuali jika dia adalah administrator
        if ($user->level->level !== 'administrator' && $lelang->id_petugas != $user->id_petugas) {
            return redirect()->route('admin.lelang.index')->with('error', 'Anda tidak memiliki akses untuk mengubah lelang ini');
        }

        // Jika lelang sudah ada pemenang, tidak bisa diubah lagi
        if ($lelang->id_user != null) {
            return redirect()->route('admin.lelang.index')->with('error', 'Lelang sudah selesai, tidak dapat diubah');
        }

        // Tentukan status baru: jika sedang dibuka maka ditutup, dan sebaliknya
        $newStatus = $lelang->status === 'dibuka' ? 'ditutup' : 'dibuka';

        // Jika status berubah menjadi ditutup dan ada penawaran
        if ($newStatus === 'ditutup' && $lelang->harga_akhir > 0) {
            // Cari penawaran tertinggi dari history lelang
            $highestBid = HistoryLelang::where('id_lelang', $lelang->id_lelang)
                ->orderBy('penawaran_harga', 'desc')
                ->first();

            // Jika ditemukan penawaran tertinggi
            if ($highestBid) {
                // Update lelang dengan pemenang
                $lelang->update([
                    'status' => $newStatus,
                    'id_user' => $highestBid->id_user,
                ]);

                // Format harga untuk tampilan yang lebih rapi
                $formattedHarga = number_format($highestBid->penawaran_harga, 0, ',', '.');

                return redirect()->route('admin.lelang.index')
                    ->with('success', "Lelang ditutup! Pemenang: {$highestBid->user->nama_lengkap} dengan bid Rp {$formattedHarga}");
            }
        }

        // Jika membuka lelang atau tidak ada penawaran saat menutup
        $lelang->update(['status' => $newStatus]);

        // Tentukan teks status untuk pesan sukses
        $statusText = $newStatus === 'dibuka' ? 'dibuka' : 'ditutup';
        return redirect()->route('admin.lelang.index')->with('success', "Lelang berhasil {$statusText}");
    }

    // Menghapus data lelang dari database
    public function destroy($id)
    {
        $user = auth()->guard('petugas')->user();
        $lelang = Lelang::findOrFail($id);

        // Cek akses: petugas hanya bisa menghapus lelang miliknya sendiri
        // Kecuali jika dia adalah administrator
        if ($user->level->level !== 'administrator' && $lelang->id_petugas != $user->id_petugas) {
            return redirect()->route('admin.lelang.index')->with('error', 'Anda tidak memiliki akses untuk menghapus lelang ini');
        }

        // Hapus data lelang dari database
        $lelang->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.lelang.index')->with('success', 'Data lelang berhasil dihapus');
    }
}
