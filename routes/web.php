<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\User\DashboardController AS UserDashboardController;

// Admin Portal Routes
Route::middleware(['auth.check','adminRole'])->name('admin.')->group(function() {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Payment Gateway Route
    Route::get('gateways', [PaymentGatewayController::class, 'index'])->name('gateways.index');
    Route::post('gateways/store', [PaymentGatewayController::class, 'store'])->name('gateways.store');
    Route::patch('gateways/{id}/default', [PaymentGatewayController::class, 'setDefault'])->name('gateways.default');

    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::resource('plans', PlanController::class)->except(['show','store','update']);
    Route::post('plans/update-or-create', [PlanController::class, 'updateOrCreate'])->name('plans.update-or-store');
});

// User Portal Routes
Route::middleware(['auth.check','userRole','auth.verify'])->name('user.')->group(function() {
    Route::get('dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('portal/')->group(function(){
        Route::get('plans', [UserDashboardController::class, 'planList'])->name('plans.index');
        Route::get('plans/{id}/subscribe', [PaymentController::class, 'pay'])->name('plans.subscribe');

        // Stripe Success & Cancel
        Route::get('payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    });
});
