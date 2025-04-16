<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-top: 0; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $i => $trx)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $trx->user->name }}</td>
                    <td>
                        @if ($trx->credit)
                            <span style="color: green;">Top Up</span>
                        @elseif ($trx->debit)
                            <span style="color: red;">Withdraw</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($trx->credit)
                            {{ number_format($trx->credit, 0, ',', '.') }}
                        @elseif ($trx->debit)
                            {{ number_format($trx->debit, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>{{ $trx->description ?? '-' }}</td>
                    <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
