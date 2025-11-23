<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Masyarakat;
use App\Models\Lelang;
use App\Models\Petugas;
use App\Models\HistoryLelang;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard admin/petugas
    public function index()
    {
        // Ambil data user yang sedang login (petugas/admin)
        $user = auth()->guard('petugas')->user();

        // Hitung data statistik umum untuk semua user
        $totalBarang = Barang::count();
        $totalMasyarakat = Masyarakat::count();
        $lelangAktif = Lelang::where('status', 'dibuka')->count();
        $lelangSelesai = Lelang::whereNotNull('id_user')->where('status', 'ditutup')->count();

        // Cek jika user adalah administrator
        if ($user->level->level === 'administrator') {
            // Data khusus admin
            $totalPetugas = Petugas::count();
            $totalPenawaran = HistoryLelang::count();

            // Ambil 5 data lelang terbaru untuk ditampilkan
            $lelangTerbaru = Lelang::with(['barang.gambarPrimary', 'petugas'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil 5 masyarakat dengan penawaran terbanyak
            $topBidders = Masyarakat::withCount('historyLelang')
                ->orderBy('history_lelang_count', 'desc')
                ->take(5)
                ->get();

            // Tampilkan view dashboard dengan data admin
            return view('admin.pages.dashboard', compact(
                'totalBarang',
                'totalMasyarakat',
                'lelangAktif',
                'lelangSelesai',
                'totalPetugas',
                'totalPenawaran',
                'lelangTerbaru',
                'topBidders'
            ));
        }

        // Data khusus petugas (bukan admin)
        $myLelang = Lelang::where('id_petugas', $user->id_petugas)->count();
        $myLelangAktif = Lelang::where('id_petugas', $user->id_petugas)
            ->where('status', 'dibuka')
            ->count();

        // Ambil 5 lelang yang dikelola oleh petugas ini
        $lelangSaya = Lelang::with(['barang.gambarPrimary', 'pemenang'])
            ->where('id_petugas', $user->id_petugas)
            ->latest()
            ->take(5)
            ->get();

        // Tampilkan view dashboard dengan data petugas
        return view('admin.pages.dashboard', compact(
            'totalBarang',
            'totalMasyarakat',
            'lelangAktif',
            'lelangSelesai',
            'myLelang',
            'myLelangAktif',
            'lelangSaya'
        ));
    }
}
