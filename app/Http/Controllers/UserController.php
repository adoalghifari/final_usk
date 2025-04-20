<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return $user
            ? redirect('home')->with('status', 'Success add User')
            : redirect()->back()->with('status', 'Failed add User');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->only(['name', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return $user
            ? redirect('home')->with('status', 'Success Update')
            : redirect()->back()->with('status', 'Failed Update');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $user
            ? redirect('home')->with('status', 'Success Delete User')
            : redirect()->back()->with('status', 'Failed Delete User');
    }

    public function transaksi()
    {
         $user = User::all()->count();
            $userAll = User::all();
            $mutasi = Wallet::where('status','Selesai')->orderBy('created_at','DESC')->get();

            return view('admin.transaksi', compact('user','userAll','mutasi'));
    }
}
