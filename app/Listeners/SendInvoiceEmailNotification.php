<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Mail\InvoiceCreated as MailInvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmailNotification implements ShouldQueue
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
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        Mail::mailer($event->invoice->checkout->campaign->mailer)
            ->to($event->invoice->checkout->user)
            ->queue(new MailInvoiceCreated($event->invoice));
    }
}
