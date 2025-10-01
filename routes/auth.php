<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OTPController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Guest routes (no login)
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisterController::class, 'showRegister']);
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    // OTP verification
    Route::get('otp-verify', [OTPController::class, 'showOtpForm'])->name('otp.form');
    Route::post('otp-verify', [OTPController::class, 'verifyOtp'])->name('otp-verify');

    // Email verification
    Route::get('verify-email/{id}', [VerificationController::class, 'verifyEmail'])->name('user.email-verify');

    // Login
    Route::get('login', [LoginController::class, 'showLogin']);
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Forget Route
    Route::get('password/forgot', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Verified routes (logged in)
Route::middleware(['auth.check','userRole'])->name('user.')->group(function() {
    Route::get('dashboard/verified', [DashboardController::class, 'verifiedUser'])->name('verified');
    Route::post('dashboard/resend-verification', [VerificationController::class, 'resendVerification'])->name('resend');
});

// Logout route
Route::middleware('auth.check')->group(function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
