<?php

namespace App\Listeners;

use App\Events\RegistrationPaid;
use App\Events\RegistrationAsigned;
use App\Mail\RegistrationPaid as MailRegistrationPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegistrationEmailNotification implements ShouldQueue
{
    /**
     * Handle user login events.
     */
    public function onRegistrationPaid(RegistrationPaid $event)
    {
        // Mail::mailer($event->registration->campaign->mailer)
        //     ->to($event->registration->user)
        //     ->queue(new MailRegistrationPaid($event->registration));
    }

    /**
     * Handle user logout events.
     */
    public function onRegistrationAsigned(RegistrationAsigned $event)
    {
        Mail::mailer($event->registration->campaign->mailer)
            ->to($event->registration->user)
            ->queue(new MailRegistrationPaid($event->registration));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            RegistrationPaid::class,
            [SendRegistrationEmailNotification::class, 'onRegistrationPaid']
        );

        $events->listen(
            RegistrationAsigned::class,
            [SendRegistrationEmailNotification::class, 'onRegistrationAsigned']
        );
    }
}
