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
        $folder = $this->checkout->campaign->folder;
        $fromAddress = $this->checkout->campaign->from_address;
        $fromName = $this->checkout->campaign->from_name;

        if ($this->checkout->status === 'paid') {
            return $this->subject('Cancelación de asistencia')
                ->from($fromAddress, $fromName)
                ->view('emails.' . $folder . '.checkouts.cancelled_paid')
                ->text('emails.' . $folder . '.checkouts.cancelled_paid_plain');
        } else {
            return $this->subject('Cancelación de asistencia')
                ->from($fromAddress, $fromName)
                ->view('emails.' . $folder . '.checkouts.cancelled')
                ->text('emails.' . $folder . '.checkouts.cancelled_plain');
        }
    }
}
