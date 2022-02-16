<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;
use Illuminate\Support\Facades\URL;

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
        $protocol = config('app.env') === 'production' ? 'https' : 'http';
        $local = config('app.env') === 'production' ? '' : '.localhost';
        URL::forceRootUrl("$protocol://inscripciones.{$this->invoice->checkout->campaign->partner->url}$local");

        $folder = $this->invoice->checkout->campaign->folder;
        $fromAddress = $this->invoice->checkout->campaign->from_address;
        $fromName = $this->invoice->checkout->campaign->from_name;

        return $this->subject('Aquí tiene su factura')
            ->from($fromAddress, $fromName)
            ->view('emails.' . $folder . '.invoices.created')
            ->text('emails.' . $folder . '.invoices.created_plain');
    }
}
