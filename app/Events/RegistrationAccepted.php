<?php

namespace App\Events;

use App\Models\Registration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $registration;
    public $invite;
    public $sendEmail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Registration $registration, bool $invite = false, bool $sendEmail = true)
    {
        $this->registration = $registration;
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
