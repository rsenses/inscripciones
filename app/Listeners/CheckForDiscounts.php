<?php

namespace App\Listeners;

use App\Events\CheckoutCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckForDiscounts
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CheckoutCreated  $event
     * @return void
     */
    public function handle(CheckoutCreated $event)
    {
        $checkout = $event->checkout;

        $discount = $checkout->CheckForDiscounts();

        if ($discount) {
            $checkout->amount = $checkout->amount - $discount['amount'];
            $checkout->save();
        }
    }
}
