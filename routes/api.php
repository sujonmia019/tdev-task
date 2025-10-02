<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\SubscriptionController;


Route::post('register', [AuthApiController::class, 'register']);
Route::post('otp-verify', [AuthApiController::class, 'verifyOtp']);
Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('plans', [PlanController::class, 'index']);
    Route::post('subscribe/{id}/pay', [SubscriptionController::class, 'pay']);
});

Route::get('payment/success', [SubscriptionController::class, 'success'])->name('api.payment.success');
Route::get('payment/cancel', [SubscriptionController::class, 'cancel'])->name('api.payment.cancel');