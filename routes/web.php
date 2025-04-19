<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WalletController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

// Rute utama setelah login
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CRUD untuk User dan Bank menggunakan resource controller
Route::resource('user', UserController::class);
// Route::resource('bank', BankController::class);

Route::get('/bank/create', [BankController::class, 'create'])->name('bank.create');

// Rute wallet (TopUp, Withdraw, Transfer)
Route::post('/TopUp', [WalletController::class, 'TopUp'])->name('TopUp');
Route::post('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
Route::post('/transfer', [WalletController::class, 'transfer'])->name('transfer');
Route::post('/acceptRequest', [WalletController::class, 'acceptRequest'])->name('acceptRequest');
Route::get('/export-pdf/user/{id}', [ReportController::class, 'exportPDFByUser'])->name('export.pdf.user');

Route::get('/export-pdf', [ReportController::class, 'exportPDF'])->name('export.pdf');
Route::post('/topup-user', [WalletController::class, 'topUpToUser'])->name('TopUpToUser');
Route::post('/withdraw-user', [WalletController::class, 'withdrawFromUser'])->name('WithdrawFromUser');

Route::get('/bank/history', [BankController::class, 'transaksi'])->name('bank.transaksi');

Route::get('/export/transactions/per-date', [ReportController::class, 'exportAllPDFByDate'])->name('export.pdf.date');