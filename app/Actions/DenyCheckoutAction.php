<?php

namespace App\Actions;

use App\Events\CheckoutDenied;
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
        CheckoutDenied::dispatch($checkout);
    }
}
