<?php

namespace App\Listeners;

use App\Events\CheckoutAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\CheckoutAccepted as MailCheckoutAccepted;
use Illuminate\Support\Facades\Mail;

class SendCheckoutEmailNotification implements ShouldQueue
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
     * @param  CheckoutAccepted  $event
     * @return void
     */
    public function handle(CheckoutAccepted $event)
    {
        if ($event->checkout->amount > 0) {
            Mail::mailer($event->checkout->campaign()->mailer)
            ->to($event->checkout->user)
            ->queue(new MailCheckoutAccepted($event->checkout));
        }
    }
}
