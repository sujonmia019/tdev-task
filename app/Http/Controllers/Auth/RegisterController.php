<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Events\SendRegisterOTP;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $otp = rand(100000, 999999);
        $user->forceFill([
            'otp_code'       => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ])->save();

        event(new SendRegisterOTP($user, $otp));
        session(['otp_email' => $user->email]);

        return redirect()->route('otp.form')
                         ->with('success', 'Registration successful! A verification code has been sent to your email.');
    }
}
