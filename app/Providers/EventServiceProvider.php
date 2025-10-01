<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\SendRegisterOTP;
use App\Events\ResendVerificationEmail;
use App\Listeners\SendRegisterOTPListener;
use App\Listeners\SendVerificationEmailListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ResendVerificationEmail::class => [
            SendVerificationEmailListener::class,
        ],
        SendRegisterOTP::class => [
            SendRegisterOTPListener::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
