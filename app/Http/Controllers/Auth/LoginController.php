<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redirect user based on role
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        return match ($user->role) {
            Role::ADMIN_ROLE => route('admin.dashboard'),
            Role::USER_ROLE  => route('user.dashboard'),
            default => '/',
        };
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $field = filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [$field => $request->email_or_username, 'password' => $request->password];

        if (! Auth::attempt($credentials, $request->remember)) {
            return back()->with('error', 'The provided credentials do not match our records.');
        }

        $request->session()->regenerate();
        return redirect()->intended($this->redirectTo())
                         ->with('success', 'Welcome! Login successful.');
    }
}
