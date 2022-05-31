<?php

namespace App\Actions;

use App\Events\CheckoutPaid;
use App\Models\Checkout;
use Sebdesign\SM\Event\TransitionEvent;
use Carbon\Carbon;

class InviteCheckoutAction
{
    public static function before(Checkout $checkout, TransitionEvent $event)
    {
        $checkout->update(['paid_at' => Carbon::now(), 'amount' => 0]);
        $checkout->registrationsStatus($event->getTransition());
    }

    public static function after(Checkout $checkout, TransitionEvent $event)
    {
        CheckoutPaid::dispatch($checkout);
    }
}
