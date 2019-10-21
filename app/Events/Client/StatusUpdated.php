<?php

namespace App\Events\Client;

use App\Models\Client;
use Illuminate\Queue\SerializesModels;

class StatusUpdated
{
    use SerializesModels;

    public $client;
    public $comment;

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
    }
}
