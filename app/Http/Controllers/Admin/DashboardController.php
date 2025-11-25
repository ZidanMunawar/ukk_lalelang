<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Masyarakat;
use App\Models\Lelang;
use App\Models\Petugas;
use App\Models\HistoryLelang;
use Illuminate\Support\Facades\DB;

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

        // Data untuk charts - Lelang per bulan (6 bulan terakhir)
        $lelangPerBulan = Lelang::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        // Format data untuk chart
        $chartLelangLabels = [];
        $chartLelangData = [];

        foreach ($lelangPerBulan as $item) {
            $chartLelangLabels[] = date('M Y', mktime(0, 0, 0, $item->bulan, 1, $item->tahun));
            $chartLelangData[] = $item->total;
        }

        // Data untuk chart status lelang
        $statusLelang = Lelang::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $chartStatusLabels = $statusLelang->pluck('status')->map(function ($status) {
            return $status === 'dibuka' ? 'Dibuka' : 'Ditutup';
        })->toArray();
        $chartStatusData = $statusLelang->pluck('total')->toArray();

        // Data untuk chart top barang berdasarkan penawaran
        $topBarang = HistoryLelang::select('id_barang', DB::raw('COUNT(*) as total_bid'))
            ->with('barang')
            ->groupBy('id_barang')
            ->orderBy('total_bid', 'desc')
            ->take(5)
            ->get();

        $chartTopBarangLabels = $topBarang->pluck('barang.nama_barang')->toArray();
        $chartTopBarangData = $topBarang->pluck('total_bid')->toArray();

        // Cek jika user adalah administrator
        if ($user->level->level === 'administrator') {
            // Data khusus admin
            $totalPetugas = Petugas::count();
            $totalPenawaran = HistoryLelang::count();

            // Data total revenue dari lelang yang selesai
            $totalRevenue = Lelang::whereNotNull('id_user')
                ->where('status', 'ditutup')
                ->sum('harga_akhir');

            // Data conversion rate (lelang selesai vs total lelang)
            $totalLelang = Lelang::count();
            $conversionRate = $totalLelang > 0 ? ($lelangSelesai / $totalLelang) * 100 : 0;

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
                'totalRevenue',
                'conversionRate',
                'lelangTerbaru',
                'topBidders',
                'chartLelangLabels',
                'chartLelangData',
                'chartStatusLabels',
                'chartStatusData',
                'chartTopBarangLabels',
                'chartTopBarangData'
            ));
        }

        // Data khusus petugas (bukan admin)
        $myLelang = Lelang::where('id_petugas', $user->id_petugas)->count();
        $myLelangAktif = Lelang::where('id_petugas', $user->id_petugas)
            ->where('status', 'dibuka')
            ->count();

        // Revenue untuk petugas (lelang yang dikelola dan selesai)
        $myRevenue = Lelang::where('id_petugas', $user->id_petugas)
            ->whereNotNull('id_user')
            ->where('status', 'ditutup')
            ->sum('harga_akhir');

        // Conversion rate untuk petugas
        $myTotalLelang = Lelang::where('id_petugas', $user->id_petugas)->count();
        $myConversionRate = $myTotalLelang > 0 ? ($lelangSelesai / $myTotalLelang) * 100 : 0;

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
            'myRevenue',
            'myConversionRate',
            'lelangSaya',
            'chartLelangLabels',
            'chartLelangData',
            'chartStatusLabels',
            'chartStatusData',
            'chartTopBarangLabels',
            'chartTopBarangData'
        ));
    }
}
