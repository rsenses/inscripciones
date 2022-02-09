<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;

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
        $folder = $this->checkout->campaign()->folder;
        $fromAddress = $this->checkout->campaign()->from_address;
        $fromName = $this->checkout->campaign()->from_name;

        return $this->subject('Aforo completo')
            ->from($fromAddress, $fromName)
            ->view('emails.' . $folder . '.checkouts.denied')
            ->text('emails.' . $folder . '.checkouts.denied_plain');
    }
}
