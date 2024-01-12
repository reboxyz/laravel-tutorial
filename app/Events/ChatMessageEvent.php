<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageEvent implements ShouldBroadcast  // Note! Make this event broadcastable
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, User $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            //new Channel('public.chat.channel.1'),
            //new PrivateChannel('private.chat.channel.1'),  // Note! Needs authorized user only
            new PresenceChannel('presence.chat.1'),          // Presence channel
        ];
    }

    // Note! This will setup the custom event name 
    public function broadcastAs()
    {
        return 'chat-message';
    }

    // Note! This will setup the data or payload to be broadcasted

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'user'=> $this->user->only(['name', 'email']),
        ];
    }
}
