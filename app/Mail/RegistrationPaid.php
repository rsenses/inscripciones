<?php

namespace App\Mail;

use App\Models\Registration;
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
        $folder = $this->registration->campaign()->folder;
        $fromAddress = $this->registration->campaign()->from_address;
        $fromName = $this->registration->campaign()->from_name;

        return $this->subject('Bienvenido al ' . $this->registration->product->name)
            ->from($fromAddress, $fromName)
            ->view('emails.' . $folder . '.registrations.paid')
            ->text('emails.' . $folder . '.registrations.paid_plain');
    }
}
