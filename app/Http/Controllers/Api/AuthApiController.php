<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\SendRegisterOTP;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\RegisterRequest;

class AuthApiController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create($request->validated());

        $otp = rand(100000, 999999);
        $user->forceFill([
            'otp_code'       => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ])->save();

        event(new SendRegisterOTP($user, $otp));

        $data = new UserResource($user);
        return $this->responseJson('success', 'User registered successfully. Check your email for OTP.', $data);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->only('otp'),[
            'otp' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->responseJson(false,'Form Validator', $validator->errors());
        }

        $user = User::where('otp_code', $request->otp)->firstOrFail();

        if ($user->otp_code != $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return $this->responseJson('error','Invalid or expired OTP');
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
        ])->save();

        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'token' => $token,
            'user'  => new UserResource($user)
        ];

        return $this->responseJson('success','Your account has been successfully verified.',$data);
    }

    public function login(LoginRequest $request)
    {
        $field = filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field     => $request->email_or_username,
            'password' => $request->password,
        ];

        if (! Auth::attempt($credentials)) {
            return $this->responseJson('error','The provided credentials do not match our records.', null, 401);
        }

        $user = Auth::user();

        if (is_null($user->email_verified_at)) {
            return $this->responseJson('error','Please verify your email first.', null, 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'token' => $token,
            'user'  => new UserResource($user)
        ];
        
        return $this->responseJson('success','Login successful.', $data);
    }
}
