<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    

    public function ownerLogin(Request $request)
    {
        $remember = ($request->has('remember')) ? true : false;
        
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new RecaptchaRule()],
        ]);
    
        if ($validator->fails()) {
            return redirect('/')->withErrors(['g-recaptcha-response' => 'captcha required*'])->withInput();
        }
    
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials, $remember)) {
            $role = Auth::user()->role;
            if ($role == 'owner') {
                return redirect('/owner/dashboard');
            } 
            if ($role == 'staff') {
                return redirect('/staff/dashboard');
            } 
            if ($role == 'laborer') {
                return redirect('/laborer/dashboard');
            }
        }
        else {
            return redirect('/')->withErrors(['password' => 'invalid username or password'])->withInput();
        }
    
    }
    
    public function showOwnerPanel()
    {
        return view('owner.panel');
    }
    
    public function showRegisterForm()
    {
        $projects = Project::where('status', 'new')->latest()->get();
        
        return view('owner.registerAcc', compact('projects'));
    }

    public function registerStaff(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => ['required', 'unique:users', 'string', 'max:15', 'regex:/^[a-zA-Z0-9_ ]+$/'],
            'fname' => ['required','string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
            'lname' => ['required','string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
            'mname' => ['nullable', 'string', 'max:25', 'regex:/^[a-zA-Z\s_]+$/'],
            'email' => 'required|email|unique:users|max:50',
            'contact' => ['required', 'unique:users', 'regex:/^\d{11}$/'],
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,staff,laborer',
        ]);


        $user = User::create([
            'username' => $request->input('username'),
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'mname' => $request->input('mname'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'project_id' => $request->input('project_id'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);
        
        event(new VerifyEmailNotification($user));

        return redirect('/owner/accounts')->withErrors(['password' => 'Invalid Username, Email or Password'])->withInput();
    }

    public function registerLaborer(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => ['required', 'unique:users', 'string', 'max:15', 'regex:/^[a-zA-Z0-9_ ]+$/'],
            'fname' => ['required','string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
            'lname' => ['required','string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
            'mname' => ['nullable','max:25','regex:/^$|^[a-zA-Z_]+$/'],
            'email' => 'required|email|unique:users|max:50',
            'contact' => ['required', 'unique:users', 'regex:/^\d{11}$/'],
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,staff,laborer',
        ]);


        $user = User::create([
            'username' => $request->input('username'),
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'mname' => $request->input('mname'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'project_id' => $request->input('project_id'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);
        
        event(new VerifyEmailNotification($user));

        return redirect('/staff/laborer')->with('success', 'Employee registered successfully.');
    }

    public function showStaffLaborer()
    {
        $users = User::where('role', 'laborer')->latest()->get();
        $projects = Project::where('status', 'new')->latest()->get();

        return view('staff.laborer', compact('users', 'projects'));
    }


    public function showAdminRegister()
    {
        $users = User::orderByRaw("FIELD(role, 'owner', 'staff', 'laborer'), created_at DESC")->paginate(10);

        return view('owner.register', ['users' => $users]);
    }

    public function logout()
    {
        Auth::logout();

        Session::flush();

        return redirect('/');
    }

    public function displayUser()
    {
        $account = User::where('user_id', Auth::id())->latest->get();
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
    
    public function showProfile($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        
        return view('owner.profile', compact('user', 'id'));
    }
    
    public function showRegisterFormLaborer()
    {
        $projects = Project::where('status', 'new')->latest()->get();
        
        return view('staff.register', compact('projects'));
    }
    
    public function showLaborerProfile($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        
        return view('staff.profile', compact('user', 'id'));
    }
    
     public function showUserProfile()
    {
        $user = User::where('id', Auth::id())->first();
        
        return view('staff.user', compact('user'));
    }
    public function showUserLaborer()
    {
        $user = User::where('id', Auth::id())->first();
        
        return view('laborer.user', compact('user'));
    }
    public function showUserOwner()
    {
        $user = User::where('id', Auth::id())->first();
        
        return view('owner.user', compact('user'));
    }
}





