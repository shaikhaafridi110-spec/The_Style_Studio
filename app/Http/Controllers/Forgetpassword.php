<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class Forgetpassword extends Controller
{
    //

    public function forgotPassword()
    {
        return view('forgot-password');
    }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expire_at = Carbon::now()->addMinutes(5);
        $user->save();

        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset OTP');
        });

        session(['reset_email' => $user->email]);

        return redirect('verify-otp')->with('success', 'OTP sent to email');
    }
    public function verifyOtpPage()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = User::where('email', session('reset_email'))
            ->where('otp', $request->otp)
            ->where('otp_expire_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid or Expired OTP');
        }

        return redirect('reset-password');
    }
    public function resetPasswordPage()
{
    return view('reset-password');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::where('email', session('reset_email'))->first();

    $user->password =$request->password;
    $user->otp = null;
    $user->otp_expire_at = null;
    $user->save();

    return redirect('/')->with('success', 'Password reset successfully');
}
}
