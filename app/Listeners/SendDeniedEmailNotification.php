<?php

namespace App\Listeners;

use App\Events\CheckoutDenied;
use App\Mail\CheckoutDenied as MailCheckoutDenied;
use App\Services\DynamicMailer;
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
        DynamicMailer::send($event->checkout->user, new MailCheckoutDenied($event->checkout));
    }
}
