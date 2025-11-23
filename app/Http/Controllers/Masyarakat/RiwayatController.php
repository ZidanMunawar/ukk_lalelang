<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\HistoryLelang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter status dari URL, default 'semua' jika tidak ada
        $status = $request->get('status', 'semua');
        // Ambil data user yang sedang login
        $user = Auth::guard('masyarakat')->user();

        // Siapkan query untuk mengambil history lelang user
        $query = HistoryLelang::with(['lelang.barang.gambarPrimary', 'lelang.petugas', 'lelang.pemenang'])
            ->where('id_user', $user->id_user) // Hanya ambil history milik user ini
            ->orderBy('created_at', 'desc'); // Urutkan dari yang terbaru

        // Filter history berdasarkan status yang dipilih
        if ($status === 'menang') {
            // Hanya tampilkan lelang yang dimenangkan oleh user ini
            $query->whereHas('lelang', function ($q) use ($user) {
                $q->where('id_user', $user->id_user);
            });
        } elseif ($status === 'kalah') {
            // Tampilkan lelang yang sudah selesai dan dimenangkan oleh orang lain
            $query->whereHas('lelang', function ($q) use ($user) {
                $q->whereNotNull('id_user') // Sudah ada pemenang
                    ->where('id_user', '!=', $user->id_user); // Tapi bukan user ini
            });
        } elseif ($status === 'proses') {
            // Tampilkan lelang yang masih berlangsung (belum ada pemenang)
            $query->whereHas('lelang', function ($q) {
                $q->where('status', 'dibuka')
                    ->whereNull('id_user'); // Belum ada pemenang
            });
        }

        // Ambil data history dan pastikan hanya satu entry per lelang
        $histories = $query->get()->unique('id_lelang');

        // Tampilkan halaman history dengan data yang sudah difilter
        return view('masyarakat.history', compact('histories', 'status'));
    }
}
