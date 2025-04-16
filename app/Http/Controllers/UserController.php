<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('admin.create');
    }

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
            'password' => Hash::make($validated['password']), // ✅ Enkripsi password
            'role' => $validated['role'],
        ]);

        if ($user) {
            return redirect('home')->with('status', 'Success add User');
        }

        return redirect()->back()->with('status', 'Failed add User');
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
        $user->update($request->all());
        if($user){
            return redirect('home')->with('status', 'Success Update ');
        }
        return redirect ()->back()->with('status', 'Failed Update ');
    }

    public function destroy(User $user)
    {
        $user->delete();
        if($user){
            return redirect('home')->with('status', 'Success Delete User');
        }
        return redirect ()->back()->with('status', 'Failed Delete User');
    }
}
