<?php

namespace App\Actions;

use App\Events\CheckoutCancelled;
use App\Models\Checkout;
use Sebdesign\SM\Event\TransitionEvent;

class CancelCheckoutAction
{
    public static function before(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->registrationsStatus($event->getTransition());
    }

    public static function after(Checkout $checkout, TransitionEvent $event)
    {
        CheckoutCancelled::dispatch($checkout);
    }
}
