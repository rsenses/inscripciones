<?php

namespace App\Listeners;

use App\Events\CheckoutCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\CheckoutCreated as MailCheckoutCreated;
use App\Services\DynamicMailer;

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
        DynamicMailer::send($event->checkout->user, new MailCheckoutCreated($event->checkout));
    }
}
