<?php

namespace App\Listeners;

use App\Events\CheckoutCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\CheckoutCreated as MailCheckoutCreated;
use Illuminate\Support\Facades\Mail;

class SendCreatedEmailNotification implements ShouldQueue
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
    public function handle(CheckoutCreated $event)
    {
        Mail::mailer($event->checkout->campaign()->mailer)
            ->to($event->checkout->user)
            ->queue(new MailCheckoutCreated($event->checkout));
    }
}
