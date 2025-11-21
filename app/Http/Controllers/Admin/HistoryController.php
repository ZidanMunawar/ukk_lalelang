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
        $user = auth()->guard('petugas')->user();

        $query = Lelang::with(['barang.gambarPrimary', 'pemenang', 'petugas', 'historyLelang.user'])
            ->where('id_petugas', $user->id_petugas) // filter hanya milik petugas
            ->whereNotNull('id_user')
            ->where('status', 'ditutup');

        // Filter pencarian nama barang / pemenang
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

        // Filter rentang tanggal lelang (tgl_lelang)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tgl_lelang', '>=', $request->input('tanggal_dari'));
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tgl_lelang', '<=', $request->input('tanggal_sampai'));
        }

        $historyLelang = $query->latest()->get();

        return view('admin.pages.history.index', compact('historyLelang'));
    }


}
