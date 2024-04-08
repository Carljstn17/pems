<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('auth.verify-email');
    }

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return back()->with('info', 'Your email is already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function verify(Request $request, $id, $hash)
    {
        if ($id == $request->user()->getKey() &&
            hash_equals((string) $hash, sha1($request->user()->getEmailForVerification()))) {
            $request->user()->markEmailAsVerified();
            event(new Verified($request->user()));
            return redirect('/home')->with('verified', true);
        }

        return redirect('/home')->with('verified', false);
    }
}

