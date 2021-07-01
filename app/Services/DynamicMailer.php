<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;

class DynamicMailer
{
    public static function send(User $user, Mailable $mailable)
    {
        $mailer = self::mailer();

        Mail::mailer($mailer)
            ->to($user)
            ->send($mailable);
    }

    public static function getMailer()
    {
        $mailer = self::mailer();

        return Config::get('mail.mailers.' . $mailer);
    }

    private static function mailer()
    {
        $mailer = 'smtp';

        $domain = self::getDomain();

        if ($domain !== 'expansion') {
            $mailer = 'smtp_' . $domain;
        }

        return $mailer;
    }

    public static function getDomain()
    {
        $host = str_replace('.localhost', '', request()->getHost());
        $hostNames = explode('.', $host);
        return $hostNames[count($hostNames) - 2];
    }
}
