<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lelang;

class NoSeenHistory extends Controller
{
    // Menampilkan halaman history lelang
    public function index()
    {
        // Hanya lelang yang sudah selesai (ada pemenang)
        $historyLelang = Lelang::with(['barang.gambarPrimary', 'pemenang', 'petugas', 'historyLelang.user'])
            ->whereNotNull('id_user')
            ->where('status', 'ditutup')
            ->latest()
            ->get();

        return view('admin.pages.history.index', compact('historyLelang'));
    }
}

