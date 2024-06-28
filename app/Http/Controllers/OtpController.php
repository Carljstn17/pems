<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Generate OTP
        $otp = mt_rand(100000, 999999);

        // Store OTP in session
        Session::put('otp', $otp);

        // Send OTP via Notification
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email not found.'])->withInput();
        }
        
        Session::put('reset_email', $email);

        Notification::route('mail', $email)
                    ->notify(new OtpNotification($otp));

        return redirect()->route('verify-otp')->with('success', 'OTP sent to your email!');
    }
    
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $otp = Session::get('otp');
        $email = Session::get('reset_email');
        
        $user = User::where('email', $email)->first();
 
        if ($otp == $request->otp) {
            // OTP is correct
            $userId = $user->id;
            return redirect()->route('reset-password.form', ['userId' => $userId]);
        }
        else {
            return redirect('/verify-otp')->withErrors(['otp' => 'The OTP entered is incorrect. Please try again.'])->withInput();
        }

    }
    
    public function showSendOtpForm()
    {
        return view('auth.send-otp');
    }

    public function resendOtp(Request $request)
    {
        $email = Session::get('reset_email');

        $otp = mt_rand(100000, 999999);
        Session::put('otp', $otp);

        Notification::route('mail', $email)
            ->notify(new OtpNotification($otp));

        return response()->json(['message' => 'OTP Resent!'], 200);
    }
    
}
