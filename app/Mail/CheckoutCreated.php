<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;

class CheckoutCreated extends Mailable
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
        $partner = $this->checkout->campaign->partner;
        $folder = $this->checkout->campaign->folder;
        $fromAddress = $this->checkout->campaign->from_address;
        $fromName = $this->checkout->campaign->from_name;

        return $this->subject('Solicitud registrada')
            ->from($fromAddress, $fromName)
            ->with([
                'partner' => $partner,
            ])
            ->view('emails.' . $folder . '.checkouts.created')
            ->text('emails.' . $folder . '.checkouts.created_plain');
    }
}
