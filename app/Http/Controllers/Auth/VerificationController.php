<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\ResendVerificationEmail;

class VerificationController extends Controller
{
    public function verifyEmail(Request $request, $id)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->with('error', 'Invalid or expired verification link.');
        }

        $user = User::findOrFail($id);
        $user->forceFill(['email_verified_at' => now()])->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Your account has been successfully verified.');
    }

    public function resendVerification()
    {
        $user = auth()->user();
        if ($user->email_verified_at) {
            return redirect()->route('user.dashboard');
        }

        event(new ResendVerificationEmail($user));

        return back()->with('success', 'Your email verification link has been resent. Please check your inbox.');
    }
}
