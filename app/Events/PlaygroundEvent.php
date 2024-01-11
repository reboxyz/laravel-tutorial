<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlaygroundEvent implements ShouldBroadcast  // Note! Make this event broadcastable
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            //new PrivateChannel('channel-name'),
            new Channel('public.playground.channel.1'),
        ];
    }

    // Note! This will setup the custom event name 
    public function broadcastAs()
    {
        return 'playground-winnux-here';
    }

    // Note! This will setup the data or payload to be broadcasted

    public function broadcastWith()
    {
        return [
            'heya' => 134
        ];
    }
}
