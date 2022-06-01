<?php

namespace App\Actions;

use App\Notifications\CheckoutDenied as CheckoutDeniedNotification;
use App\Models\Checkout;
use Sebdesign\SM\Event\TransitionEvent;

class DenyCheckoutAction
{
    public static function before(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->registrationsStatus($event->getTransition());
    }

    public static function after(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->user->notify(new CheckoutDeniedNotification($checkout));
    }
}
