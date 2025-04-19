<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi </title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>

<h2>Riwayat Semua Transaksi (Status: Selesai)</h2>

@foreach ($groupedTransactions as $date => $transactions)
    <h4>{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h4>
    <ul>
        @foreach ($transactions as $transaction)
            <li>
                @if ($transaction->credit)
                    <strong class="text-success">Credit:</strong> {{ $transaction->credit }}
                @else
                    <strong class="text-danger">Debit:</strong> {{ $transaction->debit }}
                @endif
                — {{ $transaction->user->name }} — {{ $transaction->description }}
                ({{ $transaction->created_at->format('H:i') }})
            </li>
        @endforeach
    </ul>
    <hr>
@endforeach
</body>
</html>