<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showOwnerLoginForm()
    {
        return view('auth.owner-login');
    }

    public function ownerLogin(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'password' => 'required|string',
        ];
    
        // Custom error messages
        $messages = [
            'name.required' => 'Incorrect Username',
            'password.required' => 'Incorrect Password',
        ];
    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);
    
        // Check if the validation fails
        if ($validator->fails()) {
            return redirect('/owner-login')
                ->withErrors($validator)
                ->withInput();
        }
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role == 'admin') {
                return redirect()->intended('/owner/dashboard');
            }
        }

        return redirect('/owner-login')->withErrors(['name' => 'Invalid credentials']);
    }
    public function showOwnerPanel()
    {
        return view('owner.panel');
    }

    public function registerStaff(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);


        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'staff',
        ]);

        return redirect('/owner/accounts')->with('success', 'Employee registered successfully.');
    }

    public function showAdminRegister()
    {
        $users = User::all();

        return view('owner.register', ['users' => $users]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('/');
    }

    public function displayUser()
    {
        $account = User::where('user_id', Auth::id())->latest->get();
    }


    //staff auth
    public function showStaffLoginForm()
    {
        return view('auth.staff-login');
    }

    public function staffLogin(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'password' => 'required|string',
        ];
    
        // Custom error messages
        $messages = [
            'name.required' => 'Incorrect Username',
            'password.required' => 'Incorrect Password',
        ];
    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);
    
        // Check if the validation fails
        if ($validator->fails()) {
            return redirect('/staff-login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role == 'staff') {
                return redirect()->intended('/staff/dashboard');
            }
        }

        return redirect('/staff-login')->withErrors(['name' => 'Invalid credentials']);
    }
    public function showStaffPanel()
    {
        return view('staff.dashboard');
    }
}
