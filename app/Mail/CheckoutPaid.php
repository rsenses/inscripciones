<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;
use App\Models\Registration;
use App\Services\DynamicMailer;

class CheckoutPaid extends Mailable
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
        $domain = $this->checkout->products[0]->partners[0]->slug;
        $name = $this->checkout->products[0]->partners[0]->name;
        $from = DynamicMailer::getMailer()['from'];

        if ($this->checkout->status === 'paid') {
            return $this->subject($name . ' te da la Bienvenida')
                ->from($from['address'], $from['name'])
                ->view('emails.' . $domain . '.checkouts.paid')
                ->text('emails.' . $domain . '.checkouts.paid_plain');
        } else {
            return $this->subject('Está a un paso de confirmar su plaza')
                ->from($from['address'], $from['name'])
                ->view('emails.' . $domain . '.checkouts.notpaid')
                ->text('emails.' . $domain . '.checkouts.notpaid_plain');
        }
    }
}
