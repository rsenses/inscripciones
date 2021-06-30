<?php

namespace App\Listeners;

use App\Events\CheckoutCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutCreated as MailCheckoutCreated;
use App\Models\Checkout;
use App\Services\DynamicMailer;

class SendCheckoutEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Checkout $checkout)
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
        if ($event->checkout->amount > 0) {
            DynamicMailer::send($event->checkout->user, new MailCheckoutCreated($event->checkout));
        }
    }
}
