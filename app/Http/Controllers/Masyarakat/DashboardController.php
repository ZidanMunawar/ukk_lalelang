<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\HistoryLelang;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data masyarakat yang sedang login
        $user = Auth::guard('masyarakat')->user();

        // Ambil data lelang yang sedang aktif
        // Status dibuka dan belum ada pemenang
        $lelangAktif = Lelang::with(['barang.gambarPrimary', 'petugas'])
            ->where('status', 'dibuka')
            ->whereNull('id_user')
            ->orderBy('tgl_lelang', 'desc')
            ->limit(8)
            ->get();

        // Ambil data lelang yang akan datang
        // Status masih ditutup dan belum ada pemenang
        $lelangComingSoon = Lelang::with(['barang.gambarPrimary', 'petugas'])
            ->where('status', 'ditutup')
            ->whereNull('id_user')
            ->orderBy('tgl_lelang', 'desc')
            ->limit(4)
            ->get();

        // Ambil data top pelelang berdasarkan jumlah lelang yang diikuti
        // Hanya hitung masyarakat yang pernah melakukan bid
        $topPelelang = Masyarakat::whereHas('historyLelang')
            ->withCount([
                'historyLelang as total_bid' => function ($query) {
                    // Hitung jumlah lelang unik yang diikuti, bukan total bid
                    $query->select(DB::raw('count(distinct id_lelang)'));
                }
            ])
            ->orderBy('total_bid', 'desc')
            ->limit(5)
            ->get();

        // Ambil riwayat lelang user yang sedang login
        // Tampilkan 3-4 lelang terakhir yang pernah diikuti
        $riwayatUser = HistoryLelang::with(['lelang.barang.gambarPrimary', 'lelang.petugas'])
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('id_lelang') // Hanya ambil satu riwayat per lelang
            ->take(4); // Ambil 4 data teratas

        // Tampilkan halaman dashboard dengan semua data yang sudah diambil
        return view('masyarakat.dashboard', compact(
            'lelangAktif',
            'lelangComingSoon',
            'topPelelang',
            'riwayatUser'
        ));
    }
}
