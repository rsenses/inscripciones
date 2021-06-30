<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class DynamicMailer
{
    public static function send(User $user, Mailable $mailable)
    {
        Mail::mailer(self::selectMailer())
            ->to($user)
            ->send($mailable);
    }

    private static function selectMailer()
    {
        $mailer = 'smtp';

        $host = str_replace('.localhost', '', request()->getHost());
        $hostNames = explode('.', $host);
        $domain = $hostNames[count($hostNames) - 2];

        if ($domain !== 'expansion') {
            $mailer = 'smtp_' . $domain;
        }

        return $mailer;
    }
}
