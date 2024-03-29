<?php

namespace App\Listeners;

use App\Events\CheckoutCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Multitenancy\Jobs\TenantAware;

class CancelInvoice implements ShouldQueue, TenantAware
{
    /**
     * Create the event listener.s
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

        if ($invoice && $checkout->status === 'cancelled') {
            if ($invoice->billed_at) {
                $negativeCheckout = $checkout->replicate();
                $negativeCheckout->amount = $checkout->amount * -1;
                $negativeCheckout->status = 'paid';

                $negativeCheckout->push();

                foreach ($checkout->registrations()->get() as $registration) {
                    $negativeCheckout->registrations()->create($registration->toArray());
                }

                $negativeCheckout->invoice()->create([
                    'address_id' => $invoice->address_id
                ]);
            } else {
                $invoice->delete();
            }
        }
    }
}
