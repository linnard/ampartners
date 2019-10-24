<?php

namespace App\Events\Client;

use App\Models\Client;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class StatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client;
    public $comment;
    public $status_description;

    /**
     * Create a new event instance.
     *
     * @param Client $client
     * @return void
     */
    public function __construct(Client $client, $comment = '')
    {
        $this->client = $client;
        $this->comment = $comment;
        $this->status_description = __('statuses.'.$client->status);
    }

    public function broadcastOn()
    {
        return new Channel('Client');
    }

    public function broadcastAs()
    {
        return 'StatusUpdated';
    }

}
