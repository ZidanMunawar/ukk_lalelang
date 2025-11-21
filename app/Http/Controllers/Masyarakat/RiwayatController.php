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
        $status = $request->get('status', 'semua');
        $user = Auth::guard('masyarakat')->user();

        // Ambil semua history lelang user
        $query = HistoryLelang::with(['lelang.barang.gambarPrimary', 'lelang.petugas', 'lelang.pemenang'])
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($status === 'menang') {
            $query->whereHas('lelang', function ($q) use ($user) {
                $q->where('id_user', $user->id_user);
            });
        } elseif ($status === 'kalah') {
            $query->whereHas('lelang', function ($q) use ($user) {
                $q->where('id_user', '!=', $user->id_user)
                    ->orWhereNull('id_user');
            });
        } elseif ($status === 'proses') {
            $query->whereHas('lelang', function ($q) {
                $q->where('status', 'dibuka')
                    ->whereNull('id_user');
            });
        }

        $histories = $query->get()->unique('id_lelang');

        return view('masyarakat.history', compact('histories', 'status'));
    }
}
