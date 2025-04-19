<body>

    <h3>Riwayat Transaksi: {{ $user->name }}</h3>
    <p>Email: {{ $user->email }}</p>

    <hr>

    <h4>Mutasi Transaksi (Selesai)</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mutasi as $i => $trx)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $trx->user->name ?? '-' }}</td>
                    <td>{{ $trx->credit ? 'Credit' : 'Debit' }}</td>
                    <td>Rp{{ number_format($trx->credit ?: $trx->debit, 0, ',', '.') }}</td>
                    <td>{{ $trx->description }}</td>
                    <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr>

</body>
