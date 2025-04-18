<!DOCTYPE html>
<html>
<head>
    <title>Transaksi {{ $user->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>

    <h3>Riwayat Transaksi: {{ $user->name }}</h3>
    <p>Email: {{ $user->email }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $i => $trx)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $trx->credit ? 'Credit' : 'Debit' }}</td>
                    <td>Rp{{ number_format($trx->credit ?: $trx->debit, 0, ',', '.') }}</td>
                    <td>{{ $trx->description }}</td>
                    <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
