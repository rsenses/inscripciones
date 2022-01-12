<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;
use App\Services\DynamicMailer;

class CheckoutDenied extends Mailable
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
        $domain = $this->checkout->products[0]->partners[0]->slug;
        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Aforo completo')
            ->from($from['address'], $from['name'])
            ->view('emails.' . $domain . '.checkouts.denied')
            ->text('emails.' . $domain . '.checkouts.denied_plain');
    }
}
