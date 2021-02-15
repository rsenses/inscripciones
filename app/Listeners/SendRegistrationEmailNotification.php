<?php

namespace App\Listeners;

use App\Events\RegistrationCreated;
use App\Mail\RegistrationCreated as MailRegistrationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegistrationEmailNotification
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
     * @param  RegistrationCreated  $event
     * @return void
     */
    public function handle(RegistrationCreated $event)
    {
        Mail::to($event->registration->user)->send(new MailRegistrationCreated($event->registration));
    }
}
