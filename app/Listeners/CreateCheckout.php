<?php

namespace App\Listeners;

use App\Events\CheckoutCreated;
use App\Events\RegistrationAccepted;
use App\Models\Checkout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateCheckout
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
     * @param  RegistrationAccepted  $event
     * @return void
     */
    public function handle(RegistrationAccepted $event)
    {
        $registration = $event->registration;

        $checkout = $registration->checkout();

        if (!$checkout) {
            $checkout = Checkout::create([
                'user_id' => $registration->user_id,
                'product_id' => $registration->product_id,
                'amount' => $event->invite ? 0.00 : $registration->product->price,
                'token' => uniqid()
            ]);
        } else {
            $checkout->status = 'new';
            $checkout->paid_at = null;
            $checkout->amount = $event->invite ? 0.00 : $checkout->amount;
            $checkout->save();
        }

        if ($event->sendEmail) {
            CheckoutCreated::dispatch($checkout);
        }
    }
}
