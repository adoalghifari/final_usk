<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BankController extends Controller
{
    // Tampilkan semua user ke home.blade.php
    public function index()
    {
        $userAll = User::all();
        return view('userAll', compact('userAll'));
    }

    // Tampilkan form tambah user
    public function create()
    {
        return view('bank.create');
    }

    // Simpan data user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if ($user) {
            return redirect()->route('home')->with('status', 'Success add User');
        }

        return redirect()->back()->with('status', 'Failed add User');
    }

    // Tampilkan form edit user
    public function edit(User $user)
    {
        return view('bank.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
        ]);

        // Cek apakah user ingin mengganti password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($user) {
            return redirect()->route('home')->with('status', 'Success Update');
        }

        return redirect()->back()->with('status', 'Failed Update');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();

        if ($user) {
            return redirect()->route('home')->with('status', 'Success Delete User');
        }

        return redirect()->back()->with('status', 'Failed Delete User');
    }

    public function show()
    {

    }

    public function transaksi()
    {
        
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
            
            return view('bank.transaksi', [
                'allmutasi' => $allmutasi,
                'saldo' => $saldo,
                'nasabah' => $jumlahNasabah,
                'request_payment' => $request_payment,
                'mutasi' => $mutasi,
                'users' => $nasabah, // kirim ke view
                'userAll' => $userAll
            ]);
        
    }
}
