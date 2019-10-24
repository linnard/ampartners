<?php

namespace App\Listeners;

use App\Events\Client;
use App\Events\Company\NotificationCreated;
use App\Models\Notification;


class CreateNotification
{


    /**
     * Handle the event.
     *
     * @param  Client\StatusUpdated  $event
     * @return void
     */
    public function handle(Client\StatusUpdated $event)
    {
        if ($event->comment){
            $notify = new Notification([
                'body' => $event->comment,
                'event' => __('statuses.'.$event->client->status),
            ]);

            $notify->client()->associate($event->client);
            $notify->company()->associate($event->client->company);
            $notify->save();

            broadcast(new NotificationCreated($notify));
        }

    }
}
