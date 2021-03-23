<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Mail\InvoiceCreated as MailInvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmailNotification
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
        Mail::to($event->invoice->checkout->user)->send(new MailInvoiceCreated($event->invoice));
    }
}
