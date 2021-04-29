<?php

namespace App\Mail;

use App\Models\Checkout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $checkout;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->checkout->status === 'paid') {
            return $this->subject('Cancelación de asistencia')
                ->view('emails.checkouts.cancelled_paid')
                ->text('emails.checkouts.cancelled_paid_plain');
        } else {
            return $this->subject('Cancelación de asistencia')
                ->view('emails.checkouts.cancelled')
                ->text('emails.checkouts.cancelled_plain');
        }
    }
}
