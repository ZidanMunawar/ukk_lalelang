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
    public function index()
    {
        $user = auth()->guard('petugas')->user();

        // Data statistik
        $totalBarang = Barang::count();
        $totalMasyarakat = Masyarakat::count();
        $lelangAktif = Lelang::where('status', 'dibuka')->count();
        $lelangSelesai = Lelang::whereNotNull('id_user')->where('status', 'ditutup')->count();

        // Data khusus admin
        if ($user->level->level === 'administrator') {
            $totalPetugas = Petugas::count();
            $totalPenawaran = HistoryLelang::count();

            // Lelang terbaru
            $lelangTerbaru = Lelang::with(['barang.gambarPrimary', 'petugas'])
                ->latest()
                ->take(5)
                ->get();

            // Top bidders
            $topBidders = Masyarakat::withCount('historyLelang')
                ->orderBy('history_lelang_count', 'desc')
                ->take(5)
                ->get();

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

        // Data khusus petugas
        $myLelang = Lelang::where('id_petugas', $user->id_petugas)->count();
        $myLelangAktif = Lelang::where('id_petugas', $user->id_petugas)
            ->where('status', 'dibuka')
            ->count();

        // Lelang yang saya kelola
        $lelangSaya = Lelang::with(['barang.gambarPrimary', 'pemenang'])
            ->where('id_petugas', $user->id_petugas)
            ->latest()
            ->take(5)
            ->get();

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
