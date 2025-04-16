<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
