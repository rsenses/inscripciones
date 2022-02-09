<?php

namespace App\Mail;

use App\Models\Checkout;
use App\Models\Discount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutAccepted extends Mailable
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
        $promo = $this->checkout->registrations()->where('status', 'accepted')->first()->promo;
        $discount = Discount::where('code', $promo)->first();

        $partner = $this->checkout->campaign->partner;
        $folder = $this->checkout->campaign->folder;

        $fromAddress = $this->checkout->campaign->from_address;
        $fromName = $this->checkout->campaign->from_name;

        return $this->subject('Solicitud de registro de ' . $partner->name .' aceptada')
            ->from($fromAddress, $fromName)
            ->with([
                'promo' => $promo,
                'discount' => $discount,
                'partner' => $partner,
            ])
            ->view('emails.' . $folder . '.checkouts.accepted')
            ->text('emails.' . $folder . '.checkouts.accepted_plain');
    }
}
