<?php

namespace App\Actions;

use App\Notifications\CheckoutAccepted as CheckoutAcceptedNotification;
use App\Models\Checkout;
use Sebdesign\SM\Event\TransitionEvent;

class AcceptCheckoutAction
{
    public static function before(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->registrationsStatus($event->getTransition());
    }

    public static function after(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->user->notify(new CheckoutAcceptedNotification($checkout));
    }
}
