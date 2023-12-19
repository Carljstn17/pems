<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function softDelete(User $user)
    {
        $user->delete();
        return redirect()->route('owner.register'); // Redirect to the user list page after soft deletion
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('owner.register', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'contact' => 'required|string|max:20',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);

        return redirect('/users')->with('success', 'User information updated successfully.');
    }
}
