<?php

namespace App\Listeners;

use App\Events\CheckoutCreated as CheckoutCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CheckoutCreated implements ShouldQueue
{
    const PREMIOSMESA_ID = 16;

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
     * @param  CheckoutCreatedEvent  $event
     * @return void
     */
    public function handle(CheckoutCreatedEvent $event)
    {
        if ($event->checkout->products()->where('products.id', self::PREMIOSMESA_ID)->count()) {
            $this->mesaJuridicoTenInscriptions($event->checkout);
        }
    }

    private function mesaJuridicoTenInscriptions($checkout)
    {
        $registrations = $checkout->registrations;
        $registration = $checkout->registrations[0];
        $count = 10 - $registrations->count();

        for ($i=1; $i <= $count; $i++) {
            $newRegistration = $registration->replicate();
            $newRegistration->save();
        }
    }
}
