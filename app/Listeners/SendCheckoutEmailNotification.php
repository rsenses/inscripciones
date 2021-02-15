<?php

namespace App\Listeners;

use App\Events\CheckoutCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutCreated as MailCheckoutCreated;

class SendCheckoutEmailNotification
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
     * @param  CheckoutCreated  $event
     * @return void
     */
    public function handle(CheckoutCreated $event)
    {
        Mail::to($event->checkout->user)->send(new MailCheckoutCreated($event->checkout));
    }
}
