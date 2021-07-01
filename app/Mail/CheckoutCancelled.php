<?php

namespace App\Mail;

use App\Models\Checkout;
use App\Services\DynamicMailer;
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
        $domain = DynamicMailer::getDomain();
        $from = DynamicMailer::getMailer()['from'];

        if ($this->checkout->status === 'paid') {
            return $this->subject('Cancelación de asistencia')
                ->from($from['address'], $from['name'])
                ->view('emails.' . $domain . '.checkouts.cancelled_paid')
                ->text('emails.' . $domain . '.checkouts.cancelled_paid_plain');
        } else {
            return $this->subject('Cancelación de asistencia')
                ->from($from['address'], $from['name'])
                ->view('emails.' . $domain . '.checkouts.cancelled')
                ->text('emails.' . $domain . '.checkouts.cancelled_plain');
        }
    }
}
