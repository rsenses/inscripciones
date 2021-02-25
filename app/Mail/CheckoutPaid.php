<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;

class CheckoutPaid extends Mailable
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
            return $this->subject('Bienvenido al Foro Económico Internacional Expansión')
                ->view('emails.checkouts.paid')
                ->text('emails.checkouts.paid_plain');
        } else {
            return $this->subject('Está a un paso de confirmar su plaza')
                ->view('emails.checkouts.notpaid')
                ->text('emails.checkouts.notpaid_plain');
        }
    }
}
