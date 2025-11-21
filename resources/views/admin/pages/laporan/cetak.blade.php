<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Lelang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        .bg-success {
            background-color: #d4edda;
            color: #155724;
        }

        .bg-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .bg-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN LELANG</h2>
        <p>Sistem Lelang Online</p>
        @if ($tanggalDari || $tanggalSampai || $petugas)
            <p>
                @if ($tanggalDari && $tanggalSampai)
                    Periode: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}
                @elseif($tanggalDari)
                    Dari: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }}
                @elseif($tanggalSampai)
                    Sampai: {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}
                @endif
                @if ($petugas)
                    | Petugas: {{ $petugas->nama_petugas }}
                @endif
            </p>
        @endif
        <p>Dicetak oleh: {{ $user->nama_petugas }} | Tanggal: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Lelang</th>
                <th>Nama Petugas</th>
                <th>Tanggal Lelang</th>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Nama Bid</th>
                <th>Harga Bid</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lelang as $index => $item)
                @php
                    $pemenang = $item->pemenang;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id_lelang }}</td>
                    <td>{{ $item->petugas->nama_petugas }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_lelang)->format('d/m/Y') }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td class="text-right">Rp {{ number_format($item->barang->harga_awal, 0, ',', '.') }}</td>
                    <td>
                        @if ($pemenang)
                            {{ $pemenang->nama_lengkap }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($item->harga_akhir, 0, ',', '.') }}</td>
                    <td>
                        @if ($item->status == 'dibuka')
                            <span class="badge bg-info">Dibuka</span>
                        @elseif($item->status == 'ditutup')
                            @if ($item->harga_akhir > 0)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Ditutup</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data lelang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h4>Ringkasan</h4>
        <p>Total Lelang: <strong>{{ $totalLelang }}</strong></p>
        <p>Total Harga Akhir: <strong>Rp {{ number_format($totalHargaAkhir, 0, ',', '.') }}</strong></p>
    </div>
</body>

</html>
