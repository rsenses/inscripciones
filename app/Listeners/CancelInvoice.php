<?php

namespace App\Listeners;

use App\Events\CheckoutCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CancelInvoice
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
     * @param  CheckoutCancelled  $event
     * @return void
     */
    public function handle(CheckoutCancelled $event)
    {
        $checkout = $event->checkout;
        $invoice = $checkout->invoice;

        if ($invoice && $invoice->billed_at) {
            $negativeCheckout = $checkout->replicate();
            $negativeCheckout->amount = $checkout->amount * -1;

            $negativeCheckout->push();

            $negativeCheckout->invoice()->create([
                'address_id' => $invoice->address_id
            ]);
        } else {
            $invoice->delete();
        }
    }
}
