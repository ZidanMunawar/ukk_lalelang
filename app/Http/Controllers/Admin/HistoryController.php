<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lelang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    // Menampilkan halaman history lelang
    public function index(Request $request)
    {
        // Ambil data petugas yang sedang login
        $user = auth()->guard('petugas')->user();

        // Buat query dasar untuk mengambil data lelang yang sudah selesai
        // Hanya ambil lelang yang dikelola oleh petugas yang login
        $query = Lelang::with(['barang.gambarPrimary', 'pemenang', 'petugas', 'historyLelang.user'])
            ->where('id_petugas', $user->id_petugas) // filter hanya lelang milik petugas ini
            ->whereNotNull('id_user') // sudah ada pemenang
            ->where('status', 'ditutup'); // status sudah ditutup

        // Cek jika ada input pencarian dari user
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

        // Filter berdasarkan tanggal mulai lelang
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tgl_lelang', '>=', $request->input('tanggal_dari'));
        }

        // Filter berdasarkan tanggal akhir lelang
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tgl_lelang', '<=', $request->input('tanggal_sampai'));
        }

        // Eksekusi query dan ambil data, urutkan dari yang terbaru
        $historyLelang = $query->latest()->get();

        // Tampilkan halaman history dengan data yang sudah difilter
        return view('admin.pages.history.index', compact('historyLelang'));
    }
}
