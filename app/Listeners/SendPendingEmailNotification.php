<?php

namespace App\Listeners;

use App\Events\CheckoutPending;
use App\Mail\CheckoutPending as MailCheckoutPending;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPendingEmailNotification implements ShouldQueue
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
     * @param  CheckoutPending  $event
     * @return void
     */
    public function handle(CheckoutPending $event)
    {
        Mail::mailer($event->checkout->campaign->mailer)
            ->to($event->checkout->user)
            ->queue(new MailCheckoutPending($event->checkout));
    }
}
