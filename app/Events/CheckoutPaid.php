<?php

namespace App\Events;

use App\Models\Checkout;
use App\Models\Registration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutPaid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $checkout;
    public $registration;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Checkout $checkout, Registration $registration)
    {
        $this->checkout = $checkout;
        $this->registration = $registration;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
