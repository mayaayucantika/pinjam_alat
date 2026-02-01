<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stat-box {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Peminjaman Alat</h1>
        <p>Sistem Peminjaman Alat</p>
        <p>Periode: {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Semua' }} - {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : 'Semua' }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <strong>Total Transaksi</strong><br>
            {{ $stats['total_transactions'] }}
        </div>
        <div class="stat-box">
            <strong>Pending</strong><br>
            {{ $stats['pending'] }}
        </div>
        <div class="stat-box">
            <strong>Disetujui</strong><br>
            {{ $stats['approved'] }}
        </div>
        <div class="stat-box">
            <strong>Dikembalikan</strong><br>
            {{ $stats['returned'] }}
        </div>
        <div class="stat-box">
            <strong>Ditolak</strong><br>
            {{ $stats['rejected'] }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->tool->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->borrow_date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->return_date->format('d/m/Y') }}</td>
                    <td>
                        @if($transaction->status === 'pending')
                            Pending
                        @elseif($transaction->status === 'approved')
                            Disetujui
                        @elseif($transaction->status === 'rejected')
                            Ditolak
                        @else
                            Dikembalikan
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4F46E5; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Cetak
        </button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
