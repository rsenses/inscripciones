<?php

namespace App\Listeners;

use App\Events\RegistrationDenied;
use App\Mail\RegistrationDenied as MailRegistrationDenied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendDeniedEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationDenied  $event
     * @return void
     */
    public function handle(RegistrationDenied $event)
    {
        Mail::to($event->registration->user)->send(new MailRegistrationDenied($event->registration));
    }
}
