<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;


Route::post('register', [AuthApiController::class, 'register']);
Route::post('otp-verify', [AuthApiController::class, 'verifyOtp']);
Route::post('login', [AuthApiController::class, 'login']);

