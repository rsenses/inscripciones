<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;
use Illuminate\Support\Facades\URL;

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
        $protocol = config('app.env') === 'production' ? 'https' : 'http';
        $local = config('app.env') === 'production' ? '' : '.localhost';
        URL::forceRootUrl("$protocol://inscripciones.{$this->checkout->campaign->partner->url}$local");

        $folder = $this->checkout->campaign->folder;
        $name = $this->checkout->campaign->partner->name;
        $fromAddress = $this->checkout->campaign->from_address;
        $fromName = $this->checkout->campaign->from_name;

        return $this->subject($name . ' ' . ($name === 'Expansión' ? 'le' : 'te') . ' da la Bienvenida')
            ->from($fromAddress, $fromName)
            ->view('emails.' . $folder . '.checkouts.paid')
            ->text('emails.' . $folder . '.checkouts.paid_plain');
    }
}
