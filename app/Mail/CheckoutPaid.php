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
        $folder = $this->checkout->campaign()->folder;
        $name = $this->checkout->campaign()->partner->name;
        $from = DynamicMailer::getMailer()['from'];

        return $this->subject($name . ' te da la Bienvenida')
                ->from($from['address'], $from['name'])
                ->view('emails.' . $folder . '.checkouts.paid')
                ->text('emails.' . $folder . '.checkouts.paid_plain');
    }
}
