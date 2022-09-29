<?php

namespace App\Actions;

use App\Notifications\CheckoutPending as CheckoutPendingNotification;
use App\Models\Checkout;
use Sebdesign\SM\Event\TransitionEvent;

class HangCheckoutAction
{
    public static function before(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->registrationsStatus($event->getTransition());

        $checkout->update(['method' => 'transfer']);
    }

    public static function after(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->user->notify(new CheckoutPendingNotification($checkout));
    }
}
