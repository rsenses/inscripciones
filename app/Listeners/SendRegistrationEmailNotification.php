<?php

namespace App\Listeners;

use App\Events\RegistrationPaid;
use App\Mail\RegistrationPaid as MailRegistrationPaid;
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
     * @param  RegistrationPaid  $event
     * @return void
     */
    public function handle(RegistrationPaid $event)
    {
        // DynamicMailer::send($event->registration->user, new MailRegistrationPaid($event->registration));
    }
}
