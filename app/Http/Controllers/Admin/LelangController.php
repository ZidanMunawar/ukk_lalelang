<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\Barang;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;

class LelangController extends Controller
{
    // Menampilkan halaman index lelang
    public function index(Request $request)
    {
        $user = auth()->guard('petugas')->user();

        $query = Lelang::with(['barang.gambarPrimary', 'pemenang', 'petugas'])
            ->where('id_petugas', $user->id_petugas); // Batasi hanya milik petugas ini

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($q2) use ($search) {
                    $q2->where('nama_barang', 'like', "%{$search}%");
                })->orWhereHas('pemenang', function ($q3) use ($search) {
                    $q3->where('nama_lengkap', 'like', "%{$search}%");
                });
            });
        }

        $lelang = $query->latest()->get();

        // Semua barang tetap lengkap untuk modal create
        $barangTersedia = Barang::all();

        return view('admin.pages.lelang.index', compact('lelang', 'barangTersedia'));
    }





    // Menyimpan data lelang baru (status ditutup dulu)
    public function store(Request $request)
    {
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

        Lelang::create([
            'id_barang' => $request->id_barang,
            'tgl_lelang' => $request->tgl_lelang,
            'harga_akhir' => 0,
            'id_user' => null, // Belum ada pemenang
            'id_petugas' => auth()->guard('petugas')->user()->id_petugas,
            'status' => 'ditutup', // Default ditutup dulu
        ]);

        return redirect()->route('admin.lelang.index')->with('success', 'Lelang berhasil dibuat. Silakan buka lelang untuk memulai penawaran');
    }


    // Toggle status lelang (buka/tutup)
    public function toggleStatus($id)
    {
        $user = auth()->guard('petugas')->user();
        $lelang = Lelang::findOrFail($id);

        // Petugas hanya bisa toggle lelang miliknya sendiri
        if ($user->level->level !== 'administrator' && $lelang->id_petugas != $user->id_petugas) {
            return redirect()->route('admin.lelang.index')->with('error', 'Anda tidak memiliki akses untuk mengubah lelang ini');
        }

        // Jika ada pemenang, status jadi "selesai" (tidak bisa dibuka lagi)
        if ($lelang->id_user != null) {
            return redirect()->route('admin.lelang.index')->with('error', 'Lelang sudah selesai, tidak dapat diubah');
        }

        $newStatus = $lelang->status === 'dibuka' ? 'ditutup' : 'dibuka';

        // Jika ditutup, tentukan pemenang dari bid tertinggi
        if ($newStatus === 'ditutup' && $lelang->harga_akhir > 0) {
            // Cari bid tertinggi
            $highestBid = HistoryLelang::where('id_lelang', $lelang->id_lelang)
                ->orderBy('penawaran_harga', 'desc')
                ->first();

            if ($highestBid) {
                // Set pemenang
                $lelang->update([
                    'status' => $newStatus,
                    'id_user' => $highestBid->id_user,
                ]);

                return redirect()->route('admin.lelang.index')
                    ->with('success', "Lelang ditutup! Pemenang: {$highestBid->user->nama_lengkap} dengan bid Rp " . number_format($highestBid->penawaran_harga, 0, ',', '.'));
            }
        }

        // Jika buka atau tidak ada bid
        $lelang->update(['status' => $newStatus]);

        $statusText = $newStatus === 'dibuka' ? 'dibuka' : 'ditutup';
        return redirect()->route('admin.lelang.index')->with('success', "Lelang berhasil {$statusText}");
    }

    // Menghapus data lelang
    public function destroy($id)
    {
        $user = auth()->guard('petugas')->user();
        $lelang = Lelang::findOrFail($id);

        // Petugas hanya bisa hapus lelang miliknya sendiri
        if ($user->level->level !== 'administrator' && $lelang->id_petugas != $user->id_petugas) {
            return redirect()->route('admin.lelang.index')->with('error', 'Anda tidak memiliki akses untuk menghapus lelang ini');
        }

        // Hapus lelang (tidak ada validasi pemenang lagi, bisa dihapus kapan saja)
        $lelang->delete();

        return redirect()->route('admin.lelang.index')->with('success', 'Data lelang berhasil dihapus');
    }
}
