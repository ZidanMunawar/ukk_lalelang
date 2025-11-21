<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $petugasList = Petugas::where('id_level', 2)->get(); // Hanya petugas (bukan admin)

        $query = Lelang::with([
            'barang',
            'petugas',
            'pemenang',
            'historyLelang' => function ($q) {
                $q->orderBy('penawaran_harga', 'desc');
            }
        ]);

        // Filter petugas (hanya untuk admin)
        if (auth('petugas')->user()->id_level == 1 && $request->has('id_petugas') && $request->id_petugas != '') {
            $query->where('id_petugas', $request->id_petugas);
        } else if (auth('petugas')->user()->id_level == 2) {
            // Untuk petugas, hanya tampilkan lelang yang dibuat oleh petugas tersebut
            $query->where('id_petugas', auth('petugas')->id());
        }

        // Filter tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tgl_lelang', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tgl_lelang', '<=', $request->tanggal_sampai);
        }

        $lelang = $query->orderBy('tgl_lelang', 'desc')->get();

        // Hitung total
        $totalHargaAkhir = $lelang->sum('harga_akhir');
        $totalLelang = $lelang->count();

        return view('admin.pages.laporan.index', compact(
            'lelang',
            'petugasList',
            'totalHargaAkhir',
            'totalLelang'
        ));
    }

    public function cetak(Request $request)
    {
        $query = Lelang::with([
            'barang',
            'petugas',
            'pemenang',
            'historyLelang' => function ($q) {
                $q->orderBy('penawaran_harga', 'desc');
            }
        ]);

        // Filter petugas (hanya untuk admin)
        if (auth('petugas')->user()->id_level == 1 && $request->has('id_petugas') && $request->id_petugas != '') {
            $query->where('id_petugas', $request->id_petugas);
        } else if (auth('petugas')->user()->id_level == 2) {
            // Untuk petugas, hanya tampilkan lelang yang dibuat oleh petugas tersebut
            $query->where('id_petugas', auth('petugas')->id());
        }

        // Filter tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tgl_lelang', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tgl_lelang', '<=', $request->tanggal_sampai);
        }

        $lelang = $query->orderBy('tgl_lelang', 'desc')->get();

        // Data untuk PDF
        $data = [
            'lelang' => $lelang,
            'totalHargaAkhir' => $lelang->sum('harga_akhir'),
            'totalLelang' => $lelang->count(),
            'tanggalDari' => $request->tanggal_dari,
            'tanggalSampai' => $request->tanggal_sampai,
            'petugas' => $request->has('id_petugas') && $request->id_petugas != '' ?
                Petugas::find($request->id_petugas) : null,
            'user' => auth('petugas')->user()
        ];

        $pdf = PDF::loadView('admin.pages.laporan.cetak', $data);

        $filename = 'laporan-lelang-' . date('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
