<?php

namespace App\Mail;

use App\Models\Checkout;
use App\Models\Discount;
use App\Services\DynamicMailer;
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

        $partner = $this->checkout->products[0]->partners[0];

        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Solicitud de registro de ' . $partner->name .' aceptada')
            ->from($from['address'], $from['name'])
            ->with([
                'promo' => $promo,
                'discount' => $discount,
                'partner' => $partner,
            ])
            ->view('emails.' . $partner->slug . '.checkouts.accepted')
            ->text('emails.' . $partner->slug . '.checkouts.accepted_plain');
    }
}
