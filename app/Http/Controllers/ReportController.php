<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function exportPDF()
    {
        $user = Auth::user();

        $transactions = Wallet::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $userAll = \App\Models\User::all(); // pastikan namespace User di atas ada
        $mutasi = Wallet::where('status', 'Selesai')->with('user')->orderBy('created_at', 'DESC')->get();

        $pdf = Pdf::loadView('exports.transactions_pdf', compact('transactions', 'user', 'userAll', 'mutasi'));

        return $pdf->download('transaksi_' . $user->name . '.pdf');
    }

    public function exportPDFByUser($id)
    {
        $user = User::findOrFail($id);

        // Ambil transaksi user tertentu yang statusnya selesai
        $transactions = Wallet::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.transactions_pdf_user', compact('transactions', 'user'));

        return $pdf->download('transaksi_' . $user->name . '.pdf');
    }

    public function exportAllPDFByDate()
    {
        $transactions = Wallet::where('status', 'Selesai')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedTransactions = $transactions->groupBy(function ($item) {
            return $item->created_at->toDateString();
        });

        $pdf = Pdf::loadView('exports.transactions_pdf_date', [
            'groupedTransactions' => $groupedTransactions
        ]);

        return $pdf->download('semua_transaksi_per_hari.pdf');
    }
}
