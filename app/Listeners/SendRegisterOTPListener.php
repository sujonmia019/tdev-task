<?php

namespace App\Listeners;

use App\Mail\RegisterOTPMail;
use App\Events\SendRegisterOTP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRegisterOTPListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendRegisterOTP $event): void
    {
        Mail::to($event->user->email)
            ->send(new RegisterOTPMail($event->user, $event->otp));
    }
}
