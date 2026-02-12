<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peminjaman</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            color: #1f2937;
        }
        .header {
            text-align: center;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4f46e5;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #4f46e5;
            font-weight: 700;
        }
        .header .subtitle {
            margin: 6px 0;
            color: #6b7280;
            font-size: 14px;
        }
        .header .period {
            margin-top: 8px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border-radius: 8px;
            display: inline-block;
            font-size: 13px;
            color: #4338ca;
            font-weight: 500;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 24px;
        }
        .stat-box {
            text-align: center;
            padding: 14px 20px;
            border-radius: 12px;
            min-width: 100px;
            font-size: 13px;
        }
        .stat-box strong { display: block; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; }
        .stat-box .num { font-size: 22px; font-weight: 700; }
        .stat-total { background: linear-gradient(135deg, #eef2ff 0%, #c7d2fe 100%); color: #3730a3; }
        .stat-pending { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); color: #92400e; }
        .stat-approved { background: linear-gradient(135deg, #ecfdf5 0%, #a7f3d0 100%); color: #065f46; }
        .stat-returned { background: linear-gradient(135deg, #f0f9ff 0%, #bae6fd 100%); color: #0369a1; }
        .stat-rejected { background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%); color: #991b1b; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        th, td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: linear-gradient(180deg, #4338ca 0%, #4f46e5 100%);
            color: #000;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tbody tr:hover {
            background-color: #eef2ff;
        }
        .status-pending { color: #b45309; font-weight: 600; }
        .status-approved { color: #047857; font-weight: 600; }
        .status-returned { color: #0369a1; font-weight: 600; }
        .status-rejected { color: #b91c1c; font-weight: 600; }
        .no-print { display: block; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
            .header { border-bottom-color: #4f46e5; }
            tbody tr:hover { background-color: transparent; }
        }
        .print-btn {
            margin-top: 24px;
            text-align: center;
        }
        .print-btn button {
            padding: 12px 28px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
        }
        .print-btn button:hover {
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Peminjaman Alat</h1>
        <p class="subtitle">Sistem Peminjaman Alat</p>
        <div class="period">
            Periode: {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Semua' }}
            &nbsp;&ndash;&nbsp;
            {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : 'Semua' }}
            @if(request('status'))
                &nbsp;| Status: {{ request('status') === 'pending' ? 'Pending' : (request('status') === 'approved' ? 'Disetujui' : (request('status') === 'returned' ? 'Dikembalikan' : 'Ditolak')) }}
            @endif
        </div>
        <p class="subtitle" style="margin-top: 10px;">Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box stat-total">
            <strong>Total</strong>
            <span class="num">{{ $stats['total_transactions'] }}</span>
        </div>
        <div class="stat-box stat-pending">
            <strong>Pending</strong>
            <span class="num">{{ $stats['pending'] }}</span>
        </div>
        <div class="stat-box stat-approved">
            <strong>Disetujui</strong>
            <span class="num">{{ $stats['approved'] }}</span>
        </div>
        <div class="stat-box stat-returned">
            <strong>Dikembalikan</strong>
            <span class="num">{{ $stats['returned'] }}</span>
        </div>
        <div class="stat-box stat-rejected">
            <strong>Ditolak</strong>
            <span class="num">{{ $stats['rejected'] }}</span>
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
                            <span class="status-pending">Pending</span>
                        @elseif($transaction->status === 'approved')
                            <span class="status-approved">Disetujui</span>
                        @elseif($transaction->status === 'rejected')
                            <span class="status-rejected">Ditolak</span>
                        @else
                            <span class="status-returned">Dikembalikan</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 24px; color: #6b7280;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="no-print print-btn">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
