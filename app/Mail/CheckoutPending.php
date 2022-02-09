<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;

class CheckoutPending extends Mailable
{
    use Queueable, SerializesModels;

    public $checkout;
    public $registration;

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
        $folder = $this->checkout->campaign->folder;
        $fromAddress = $this->checkout->campaign->from_address;
        $fromName = $this->checkout->campaign->from_name;

        return $this->subject('Está a un paso de confirmar su plaza')
            ->from($fromAddress, $fromName)
            ->view('emails.' . $folder . '.checkouts.notpaid')
            ->text('emails.' . $folder . '.checkouts.notpaid_plain');
    }
}
