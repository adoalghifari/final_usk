<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Export ke PDF
    public function exportPDF()
    {
        $transactions = Wallet::with('user')->where('status', 'Selesai')->get();
        $pdf = Pdf::loadView('exports.transactions_pdf', compact('transactions'));
        return $pdf->download('transactions.pdf');
    }
}
