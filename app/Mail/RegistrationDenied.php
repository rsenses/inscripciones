<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Registration;
use App\Services\DynamicMailer;

class RegistrationDenied extends Mailable
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
        $domain = DynamicMailer::getDomain();
        $from = DynamicMailer::getMailer()['from'];

        return $this->subject('Aforo completo')
            ->from($from['address'], $from['name'])
            ->view('emails.' . $domain . '.registrations.denied')
            ->text('emails.' . $domain . '.registrations.denied_plain');
    }
}
