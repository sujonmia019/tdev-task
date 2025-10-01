<?php

namespace App\Providers;

use App\Models\User;
use App\Constants\Role;
use App\Events\SendRegisterOTP;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use App\Events\ResendVerificationEmail;
use Illuminate\Support\ServiceProvider;
use App\Listeners\SendRegisterOTPListener;
use App\Listeners\SendVerificationEmailListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        Event::listen(
            ResendVerificationEmail::class,
            SendVerificationEmailListener::class
        );

        Event::listen(
            SendRegisterOTP::class,
            SendRegisterOTPListener::class
        );

        Gate::define('admin', function () {
            $user = auth()->user();
            return $user && $user->role === Role::ADMIN_ROLE;
        });

        Gate::define('user', function () {
            $user = auth()->user();
            return $user && $user->role === Role::USER_ROLE;
        });
    }
}
