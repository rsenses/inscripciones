<?php

namespace App\Mail;

use App\Models\Registration;
use App\Services\DynamicMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationCreated extends Mailable
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
        $domain = $this->registration->product->partners[0]->slug;
        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Solicitud recibida correctamente')
            ->from($from['address'], $from['name'])
            ->view('emails.' . $domain . '.registrations.created')
            ->text('emails.' . $domain . '.registrations.created_plain');
    }
}
