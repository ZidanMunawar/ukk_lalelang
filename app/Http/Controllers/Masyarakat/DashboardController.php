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
        $user = Auth::guard('masyarakat')->user();

        // Lelang aktif (status dibuka)
        $lelangAktif = Lelang::with(['barang.gambarPrimary', 'petugas'])
            ->where('status', 'dibuka')
            ->whereNull('id_user')
            ->orderBy('tgl_lelang', 'desc')
            ->limit(8)
            ->get();

        // Lelang coming soon (status ditutup)
        $lelangComingSoon = Lelang::with(['barang.gambarPrimary', 'petugas'])
            ->where('status', 'ditutup')
            ->whereNull('id_user')
            ->orderBy('tgl_lelang', 'desc')
            ->limit(4)
            ->get();

        // Top pelelang (minimal 1 bid)
        $topPelelang = Masyarakat::whereHas('historyLelang')
            ->withCount(['historyLelang as total_bid' => function($query) {
                $query->select(DB::raw('count(distinct id_lelang)'));
            }])
            ->orderBy('total_bid', 'desc')
            ->limit(5)
            ->get();

        // Riwayat lelang user (3-4 terakhir)
        $riwayatUser = HistoryLelang::with(['lelang.barang.gambarPrimary', 'lelang.petugas'])
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('id_lelang')
            ->take(4);

        return view('masyarakat.dashboard', compact(
            'lelangAktif',
            'lelangComingSoon',
            'topPelelang',
            'riwayatUser'
        ));
    }
}
