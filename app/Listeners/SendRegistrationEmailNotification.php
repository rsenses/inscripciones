<?php

namespace App\Listeners;

use App\Events\RegistrationAccepted;
use App\Mail\RegistrationAccepted as MailRegistrationAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Services\DynamicMailer;

class SendRegistrationEmailNotification implements ShouldQueue
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
    public function handle(RegistrationAccepted $event)
    {
        DynamicMailer::send($event->registration->user, new MailRegistrationAccepted($event->registration));
    }
}
