<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
    {
        if(Auth::user()->role=='admin'){
            $user = User::all()->count();
            $userAll = User::all();
            $mutasi = Wallet::where('status','Selesai')->orderBy('created_at','DESC')->get();

            return view('home', compact('user','userAll','mutasi'));
        }

        if(Auth::user()->role=='bank'){
            $userAll = User::all();
            $wallet = Wallet::where('status', 'Selesai')->get();
            $credit = 0;
            $debit  = 0;
            foreach($wallet as $item) {
                $credit += $item->credit;
                $debit += $item->debit;
            }
            $saldo = $credit - $debit;
            $nasabah = User::where('role', 'siswa')->get();
            $jumlahNasabah = $nasabah->count();
            $request_payment = Wallet::where('status', 'Proses')->orderBy('created_at', 'DESC')->get();
            $mutasi = Wallet::where('status','Selesai')->orderBy('created_at','DESC')->get();
            $allmutasi = Wallet::where('status','Selesai')->count();
            return view('home', [
                'allmutasi' => $allmutasi,
                'saldo' => $saldo,
                'nasabah' => $jumlahNasabah,
                'request_payment' => $request_payment,
                'mutasi' => $mutasi,
                'users' => $nasabah, // kirim ke view
                'userAll' => $userAll
            ]);
        }

        if(Auth::user()->role=='siswa'){
            $user = Auth::user();

            // Ganti status jadi 'Selesai' untuk perhitungan saldo
            $wallet = Wallet::where('user_id', $user->id)
                            ->where('status', 'Selesai')
                            ->get();

            $credit = 0;
            $debit = 0;

            foreach($wallet as $item){
                $credit += $item->credit;
                $debit += $item->debit;
            }

            $saldo = $credit - $debit;

            $mutasi = Wallet::where('user_id', $user->id)
                            ->orderBy('created_at', 'DESC')
                            ->get();

            // Mengambil semua user dengan role 'siswa' selain user yang sedang login
            $users = User::where('role', 'siswa')
                        ->where('id', '!=', $user->id)
                        ->get();

            return view('home', compact('saldo', 'mutasi', 'users'));
        }
    }
}
