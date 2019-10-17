<?php

namespace App\Jobs;

use App\Events\Client\StatusUpdated;
use App\Models\Client\Client;
use App\Models\Client\Constants\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetClientCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $client;
    public $comment;

    /**
     * Create a new job instance
     *
     * @param Client $client
     */
    public function __construct(Client $client, $comment)
    {
        $this->client = $client;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client->update([
            'status' => Status::COMPLETED
        ]);

        event(new StatusUpdated($this->client, $this->comment));
    }
}
