<?php

namespace App\Listeners;

use App\Events\CheckoutAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\CheckoutAccepted as MailCheckoutAccepted;
use App\Services\DynamicMailer;

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
            DynamicMailer::send($event->checkout->user, new MailCheckoutAccepted($event->checkout));
        }
    }
}
