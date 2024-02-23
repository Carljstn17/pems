<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\RecaptchaRule;
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
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new RecaptchaRule()],
        ]);
    
        if ($validator->fails()) {
            return redirect('/owner-login')->withErrors($validator)->withInput();
        }
    
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;
    
            if ($role == 'owner') {
                return redirect()->intended('/owner/dashboard');
            }
        }
    
        return redirect('/owner-login')->withErrors(['password' => 'Incorrect Username or Password'])->withInput();
    }
    
    public function showOwnerPanel()
    {
        return view('owner.panel');
    }

    public function registerStaff(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:255',
            'contact' => 'required',
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,staff,laborer',
        ]);


        User::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        return redirect('/owner/accounts')->with('success', 'Employee registered successfully.');
    }

    public function registerLaborer(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:255',
            'contact' => 'required',
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,staff,laborer',
        ]);


        User::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        return view('staff.laborer')->with('success', 'Employee registered successfully.');
    }

    public function showStaffLaborer()
    {
        $users = User::where('role', 'laborer')->get();

        return view('staff.laborer', ['users' => $users]);
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
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new RecaptchaRule()],
        ]);
    
        if ($validator->fails()) {
            return redirect('/staff-login')->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role == 'staff') {
                return redirect()->intended('/staff/dashboard');
            }
        }

        return redirect('/staff-login')->withErrors(['password' => 'Incorrect Username or Password'])->withInput();
    }
    public function showStaffPanel()
    {
        return view('staff.dashboard');
    }


    //laborer auth    
    public function showLaborerLoginForm()
    {
        return view('auth.laborer-login');
    }

    public function laborerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new RecaptchaRule()],
        ]);
    
        if ($validator->fails()) {
            return redirect('/laborer-login')->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role == 'laborer') {
                return redirect()->intended('/laborer/profile');
            }
        }

        return redirect('/laborer-login')->withErrors(['password' => 'Incorrect Username or Password'])->withInput();
    }
    public function showLaborerPanel()
    {
        $laborers = User::where('id', Auth::id())->first();

        return view('laborer.dashboard', ['laborers' => $laborers]);
    }

    public function showLaborerInfo()
    {
        $laborers = User::where('id', Auth::id())->first();

        return view('laborer.profile', compact('laborers'));
    }
}
