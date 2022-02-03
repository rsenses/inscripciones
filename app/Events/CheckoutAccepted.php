<?php

namespace App\Events;

use App\Models\Checkout;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $checkout;
    public $invite;
    public $sendEmail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Checkout $checkout, bool $invite = false, bool $sendEmail = true)
    {
        $this->checkout = $checkout;
        $this->invite = $invite;
        $this->sendEmail = $sendEmail;
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