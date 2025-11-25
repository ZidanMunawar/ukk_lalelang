<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Lelang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 3px 2px;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 1px 3px;
            font-size: 8px;
            border-radius: 2px;
            white-space: nowrap;
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

        .summary {
            margin-top: 10px;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
            width: 150px;
            float: right;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 25px;
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2 style="margin: 0; font-size: 14px;">LAPORAN LELANG</h2>
        <p style="margin: 2px 0; font-size: 9px;">Sistem Lelang Online</p>
        @if ($tanggalDari || $tanggalSampai || $petugas)
            <p style="margin: 1px 0; font-size: 9px;">
                @if ($tanggalDari && $tanggalSampai)
                    Periode: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}
                @elseif($tanggalDari)
                    Dari: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }}
                @elseif($tanggalSampai)
                    Sampai: {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}
                @endif
                @if ($petugas && auth('petugas')->user()->id_level == 1)
                    | Petugas: {{ $petugas->nama_petugas }}
                @endif
            </p>
        @endif
        <p style="margin: 1px 0; font-size: 9px;">Dicetak: {{ $user->nama_petugas }} | {{ date('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 15px;">#</th>
                <th style="width: 30px;">ID</th>
                @if (auth('petugas')->user()->id_level == 1)
                    <th style="width: 60px;">Petugas</th>
                @endif
                <th style="width: 50px;">Tanggal</th>
                <th style="width: auto">Barang</th>
                <th style="width: auto;">Harga Awal</th>
                <th style="width: 70px;">Pemenang</th>
                <th style="width: auto;">Harga Akhir</th>
                <th style="width: 40px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $lelangArray = $lelang->toArray();
            @endphp
            @foreach ($lelangArray as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item['id_lelang'] }}</td>
                    @if (auth('petugas')->user()->id_level == 1)
                        <td>{{ $item['petugas']['nama_petugas'] ?? '-' }}</td>
                    @endif
                    <td>{{ \Carbon\Carbon::parse($item['tgl_lelang'])->format('d/m/Y') }}</td>
                    <td>{{ $item['barang']['nama_barang'] ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item['barang']['harga_awal'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $item['pemenang']['nama_lengkap'] ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga_akhir'], 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if ($item['status'] == 'dibuka')
                            <span class="badge bg-info">Dibuka</span>
                        @elseif($item['status'] == 'ditutup')
                            @if ($item['harga_akhir'] > 0)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Ditutup</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            @if (count($lelangArray) === 0)
                <tr>
                    <td colspan="{{ auth('petugas')->user()->id_level == 1 ? 9 : 8 }}" class="text-center">Tidak ada
                        data lelang</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="summary" style="font-size: 9px;">
        <strong>Ringkasan:</strong><br>
        Total Lelang: {{ $totalLelang }} |
        Total Harga: Rp {{ number_format($totalHargaAkhir, 0, ',', '.') }}
    </div>

    <div class="signature">
        <div class="signature-line"></div>
        <div style="font-size: 9px;">{{ $user->nama_petugas }}</div>
    </div>
</body>

</html>
