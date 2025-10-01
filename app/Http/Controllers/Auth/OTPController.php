<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterOTPRequest;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function verifyOtp(RegisterOTPRequest $request)
    {
        $user = User::where('email', session('otp_email'))->firstOrFail();

        if ($user->otp_code != $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
        ])->save();

        session()->forget('otp_email');
        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Your account has been successfully verified.');
    }

}
