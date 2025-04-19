<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function TopUp(Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric|min:1000'
        ]);

        Wallet::create([
            'user_id' => Auth::id(),
            'credit' => $request->credit,
            'debit' => 0,
            'status' => 'Proses',
            'description' => 'Top-Up Saldo'
        ]);

        return redirect()->back()->with('status', 'Top-Up request is Processed');
    }

    public function topUpToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'credit' => 'required|numeric|min:1000'
        ]);

        Wallet::create([
            'user_id' => $request->user_id,
            'credit' => $request->credit,
            'debit' => 0,
            'status' => 'Selesai',
            'description' => 'Top Up oleh Bank: ' . Auth::user()->name
        ]);

        return redirect()->back()->with('status', 'Top Up ke user berhasil!');
    }

    public function withdrawFromUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'debit' => 'required|numeric|min:1000'
        ]);

        $user = User::findOrFail($request->user_id);
        $totalSaldo = Wallet::where('user_id', $user->id)->where('status', 'Selesai')->sum(DB::raw('credit - debit'));

        if ($totalSaldo < $request->debit) {
            return redirect()->back()->with('status', 'Saldo user tidak mencukupi untuk withdraw!');
        }

        Wallet::create([
            'user_id' => $user->id,
            'credit' => 0,
            'debit' => $request->debit,
            'status' => 'Selesai',
            'description' => 'Withdraw oleh Bank: ' . Auth::user()->name
        ]);

        return redirect()->back()->with('status', 'Withdraw dari user berhasil!');
    }

   public function withdraw(Request $request)
    {
        $request->validate([
            'debit' => 'required|numeric|min:10000'
        ]);

        $user = Auth::user();

        // Mengambil total saldo yang sudah selesai
        $totalSaldo = Wallet::where('user_id', $user->id)->where('status', 'selesai')->sum(DB::raw('credit - debit'));

        // Mengecek apakah saldo mencukupi
        if ($totalSaldo < $request->debit) {
            return redirect()->back()->with('status', 'Saldo tidak cukup untuk withdraw!');
        }

        // Mulai transaksi DB
        DB::beginTransaction();
        try {
            // Simpan transaksi withdraw
            Wallet::create([
                'user_id' => $user->id,
                'credit' => 0,
                'debit' => $request->debit,
                'status' => 'Proses',
                'description' => 'Withdraw Saldo'
            ]);

            // Mengurangi saldo pengguna (update saldo utama)
            $userWallet = Wallet::where('user_id', $user->id)->where('status', 'Selesai')->first(); // mengambil wallet utama pengguna
            $userWallet->credit -= $request->debit;  // Mengurangi saldo
            $userWallet->save();  // Menyimpan perubahan saldo

            DB::commit(); // Menyelesaikan transaksi

            return redirect()->back()->with('status', 'Withdraw request is Processed');
        } catch (\Exception $e) {
            DB::rollBack(); // Mengembalikan transaksi jika gagal
            return redirect()->back()->with('status', 'Terjadi Kesalahan, withdraw gagal!');
        }
    }


    public function transfer(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000'
        ]);

        $user = Auth::user();
        $recipient = User::findOrFail($request->recipient_id);

        $totalSaldo = Wallet::where('user_id', $user->id)->where('status', 'Selesai')->sum(DB::raw('credit - debit'));

        if ($totalSaldo < $request->amount) {
            return redirect()->back()->with('status', 'Saldo tidak cukup untuk transfer');
        }

        DB::beginTransaction();
        try {
            // Kurangi saldo pengirim
            Wallet::create([
                'user_id' => $user->id,
                'credit' => 0,
                'debit' => $request->amount,
                'status' => 'Selesai',
                'description' => 'Transfer ke ' . $recipient->name
            ]);

            // Tambah saldo penerima
            Wallet::create([
                'user_id' => $recipient->id,
                'credit' => $request->amount,
                'debit' => 0,
                'status' => 'Selesai',
                'description' => 'Transfer dari ' . $user->name
            ]);

            DB::commit();
            return redirect()->back()->with('status', 'Transfer berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'Terjadi Kesalahan, transfer gagal!');
        }
    }

    public function acceptRequest(Request $request)
    {
        $wallet = Wallet::findOrfail($request->wallet_id);
        $wallet->update(['status' => 'Selesai']);

        return redirect()->back()->with('status', 'Permintaan berhasil disetujui');
    }

}
