<?php

namespace App\Listeners;

use App\Events\CheckoutCancelled;
use App\Mail\CheckoutCancelled as MailCheckoutCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCancelledEmailNotification implements ShouldQueue
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
     * @param  CheckoutCancelled  $event
     * @return void
     */
    public function handle(CheckoutCancelled $event)
    {
        Mail::mailer($event->checkout->campaign()->mailer)
            ->to($event->checkout->user)
            ->queue(new MailCheckoutCancelled($event->checkout));
    }
}
