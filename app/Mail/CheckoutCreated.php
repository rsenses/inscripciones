<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;
use App\Services\DynamicMailer;

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
        $promo = $this->checkout->registration('accepted')->promo;
        $discount = $this->checkout->product->discounts->find(1);

        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Solicitud aceptada')
            ->from($from['address'], $from['name'])
            ->with([
                'promo' => $promo,
                'discount' => $discount,
            ])
            ->view('emails.checkouts.created')
            ->text('emails.checkouts.created_plain');
    }
}
