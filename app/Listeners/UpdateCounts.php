<?php

namespace App\Listeners;

use App\Constants\Client\Status;
use App\Events\Client;


class UpdateCounts
{

    /**
     * Handle the event.
     *
     */
    public function handle()
    {
        $new = \App\Models\Client::whereIn('status', [
            Status::TICKET_CONFIRMATION_EXPECTED,
            Status::BOOKING_CONFIRMATION_EXPECTED
        ])->where('is_updated', 1)->count();

        $counts = [
            'new_clients' => $new
        ];

        broadcast(new Client\CountsUpdated($counts));
    }
}
