<?php

namespace App\Events\Client;

use App\Models\Client;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CountsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $counts;

    /**
     * Create a new event instance.
     *
     * @param array $counts
     * @return void
     */
    public function __construct($counts)
    {
        $this->counts = $counts;
    }

    public function broadcastOn()
    {
        return new Channel('Client');
    }

    public function broadcastAs()
    {
        return 'CountsUpdated';
    }

}
