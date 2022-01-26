<?php

namespace App\Mail;

use App\Models\Registration;
use App\Services\DynamicMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $partner = $this->registration->product->partners[0];
        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Bienvenido al ' . $this->registration->product->name)
            ->from($from['address'], $from['name'])
            ->view('emails.' . $partner->slug . '.registrations.paid')
            ->text('emails.' . $partner->slug . '.registrations.paid_plain');
    }
}
