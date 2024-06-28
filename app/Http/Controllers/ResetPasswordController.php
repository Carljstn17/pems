<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.reset-email');
    }

    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('reset-password')->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        // Send OTP via email
        $user->notify(new ResetPasswordNotification($otp));

        return redirect()->route('reset-password.form', $user->id)->with('success', 'An OTP has been sent to your email.');
    }

    public function showResetForm($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->password_reset_at) {
            return redirect()->route('login');
        }

        return view('auth.reset-password', compact('user'));
    }
    
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($request->user_id);

        // Reset password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/')->with('success', 'Password has been reset successfully. Please login with your new password.');
    }
}
