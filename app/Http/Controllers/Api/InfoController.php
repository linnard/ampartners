<?php

namespace App\Http\Controllers\Api;

use App\Constants\Client\Status;
use App\Http\Controllers\Controller;
use App\Models\Client;



class InfoController extends Controller
{
    public function counts()
    {
        $new = Client::whereIn('status', [
            Status::TICKET_CONFIRMATION_EXPECTED,
            Status::BOOKING_CONFIRMATION_EXPECTED
        ])->where('is_updated', 1)->count();

        $counts = [
            'new_clients' => $new
        ];

        return response()->json([
            'counts' => $counts
        ]);
    }

}
