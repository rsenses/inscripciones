<?php

namespace App\Listeners;

use App\Events\RegistrationCreated;
use App\Mail\RegistrationCreated as MailRegistrationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Services\DynamicMailer;

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
        DynamicMailer::send($event->registration->user, new MailRegistrationCreated($event->registration));
    }
}
