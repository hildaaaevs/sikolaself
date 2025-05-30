<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Reservasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }
        .period {
            margin-top: 5px;
            font-size: 11px;
            color: #666;
        }
        .summary {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Data Reservasi</h1>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
        <p class="period">Periode: {{ \Carbon\Carbon::parse($start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Paket Foto</th>
                <th>Total</th>
                <th>Tipe Pembayaran</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHarga = 0;
            @endphp
            @foreach($reservasis as $index => $reservasi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $reservasi->nama }}</td>
                <td>{{ $reservasi->tanggal->format('d F Y') }}</td>
                <td>{{ $reservasi->waktu }}</td>
                <td>
                    @foreach($reservasi->detail as $detail)
                        {{ $detail->paketFoto->nama_paket_foto }}<br>
                    @endforeach
                </td>
                <td>Rp {{ number_format($reservasi->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($reservasi->tipe_pembayaran) }}</td>
                <td>{{ ucfirst($reservasi->metode_pembayaran) }}</td>
            </tr>
            @php
                $totalHarga += $reservasi->total;
            @endphp
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="total">
            Total Reservasi: {{ $reservasis->count() }}
        </div>
        <div class="total">
            Total Pendapatan: Rp {{ number_format($totalHarga, 0, ',', '.') }}
        </div>
    </div>
</body>
</html> 