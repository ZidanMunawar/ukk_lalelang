<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // Menampilkan halaman laporan lelang
    public function index(Request $request)
    {
        // Ambil daftar petugas untuk filter (hanya petugas biasa, bukan admin)
        $petugasList = Petugas::where('id_level', 2)->get();

        // Siapkan query dasar untuk mengambil data lelang
        $query = Lelang::with([
            'barang',           // Data barang yang dilelang
            'petugas',          // Petugas yang menangani lelang
            'pemenang',         // Masyarakat yang memenangkan lelang
            'historyLelang' => function ($q) {
                $q->orderBy('penawaran_harga', 'desc'); // Urutkan history penawaran dari harga tertinggi
            }
        ]);

        // Filter berdasarkan petugas yang menangani lelang
        // Jika user adalah admin dan memilih filter petugas tertentu
        if (auth('petugas')->user()->id_level == 1 && $request->has('id_petugas') && $request->id_petugas != '') {
            $query->where('id_petugas', $request->id_petugas);
        } else if (auth('petugas')->user()->id_level == 2) {
            // Jika user adalah petugas biasa, hanya tampilkan lelang yang dia tangani
            $query->where('id_petugas', auth('petugas')->id());
        }

        // Filter berdasarkan tanggal mulai lelang
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tgl_lelang', '>=', $request->tanggal_dari);
        }

        // Filter berdasarkan tanggal akhir lelang
        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tgl_lelang', '<=', $request->tanggal_sampai);
        }

        // Eksekusi query dan ambil data, urutkan berdasarkan tanggal lelang terbaru
        $lelang = $query->orderBy('tgl_lelang', 'desc')->get();

        // Hitung total harga akhir dari semua lelang
        $totalHargaAkhir = $lelang->sum('harga_akhir');
        // Hitung total jumlah lelang
        $totalLelang = $lelang->count();

        // Tampilkan halaman laporan dengan data yang sudah diproses
        return view('admin.pages.laporan.index', compact(
            'lelang',
            'petugasList',
            'totalHargaAkhir',
            'totalLelang'
        ));
    }

    // Fungsi untuk mencetak laporan dalam format PDF
    public function cetak(Request $request)
    {
        // Siapkan query yang sama seperti di index untuk konsistensi data
        $query = Lelang::with([
            'barang',
            'petugas',
            'pemenang',
            'historyLelang' => function ($q) {
                $q->orderBy('penawaran_harga', 'desc');
            }
        ]);

        // Filter petugas sama seperti di halaman index
        if (auth('petugas')->user()->id_level == 1 && $request->has('id_petugas') && $request->id_petugas != '') {
            $query->where('id_petugas', $request->id_petugas);
        } else if (auth('petugas')->user()->id_level == 2) {
            $query->where('id_petugas', auth('petugas')->id());
        }

        // Filter tanggal sama seperti di halaman index
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tgl_lelang', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tgl_lelang', '<=', $request->tanggal_sampai);
        }

        // Ambil data lelang yang sudah difilter
        $lelang = $query->orderBy('tgl_lelang', 'desc')->get();

        // Siapkan data yang akan dikirim ke view PDF
        $data = [
            'lelang' => $lelang,
            'totalHargaAkhir' => $lelang->sum('harga_akhir'), // Total semua harga akhir lelang
            'totalLelang' => $lelang->count(), // Jumlah total lelang
            'tanggalDari' => $request->tanggal_dari, // Tanggal mulai filter
            'tanggalSampai' => $request->tanggal_sampai, // Tanggal akhir filter
            'petugas' => $request->has('id_petugas') && $request->id_petugas != '' ?
                Petugas::find($request->id_petugas) : null, // Data petugas jika difilter
            'user' => auth('petugas')->user() // Data user yang mencetak
        ];

        // Load view PDF dengan data yang sudah disiapkan
        $pdf = PDF::loadView('admin.pages.laporan.cetak', $data);

        // Buat nama file PDF dengan format tanggal
        $filename = 'laporan-lelang-' . date('Y-m-d') . '.pdf';

        // Download file PDF
        return $pdf->download($filename);
    }
}
