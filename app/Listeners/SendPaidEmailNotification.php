<?php

namespace App\Listeners;

use App\Events\CheckoutPaid;
use App\Mail\CheckoutPaid as MailCheckoutPaid;
use App\Services\DynamicMailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPaidEmailNotification implements ShouldQueue
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
     * @param  CheckoutPaid  $event
     * @return void
     */
    public function handle(CheckoutPaid $event)
    {
        DynamicMailer::send($event->checkout->user, new MailCheckoutPaid($event->checkout, $event->registration));
    }
}
