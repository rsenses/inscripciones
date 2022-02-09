<?php

namespace App\Listeners;

use App\Events\CheckoutDenied;
use App\Mail\CheckoutDenied as MailCheckoutDenied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendDeniedEmailNotification implements ShouldQueue
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
     * @param  CheckoutDenied  $event
     * @return void
     */
    public function handle(CheckoutDenied $event)
    {
        Mail::mailer($event->checkout->campaign->mailer)
            ->to($event->checkout->user)
            ->queue(new MailCheckoutDenied($event->checkout));
    }
}
