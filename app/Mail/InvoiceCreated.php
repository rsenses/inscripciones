<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;
use App\Services\DynamicMailer;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $folder = $this->checkout->campaign()->folder;
        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Aquí tiene su factura')
            ->from($from['address'], $from['name'])
            ->view('emails.' . $folder . '.invoices.created')
            ->text('emails.' . $folder . '.invoices.created_plain');
    }
}
