<?php

namespace App\Listeners;

use App\Mail\UserVerifyMail;
use Illuminate\Support\Facades\Mail;
use App\Events\ResendVerificationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationEmailListener
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
    public function handle(ResendVerificationEmail $event): void
    {
        Mail::to($event->user->email)->send(new UserVerifyMail($event->user));
    }
}
