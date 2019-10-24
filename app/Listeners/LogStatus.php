<?php

namespace App\Listeners;

use App\Events\Client;
use App\Constants\Client\Status;
use App\Models\StatusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogStatus
{


    /**
     * Handle the event.
     *
     * @param  Client\StatusUpdated  $event
     * @return void
     */
    public function handle(Client\StatusUpdated $event)
    {
        $log = new StatusLog([
            'status' => $event->client->status,
        ]);

        $log->client()->associate($event->client);
        $log->save();
    }
}
