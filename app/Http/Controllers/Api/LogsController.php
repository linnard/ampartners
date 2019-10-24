<?php

namespace App\Http\Controllers\Api;

use App\Constants\Client\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $logs =  $user->logs()->with('client')->whereNotIn('status', [
            Status::TICKET_CONFIRMATION_REJECTED,
            Status::BOOKING_CONFIRMATION_REJECTED,
            Status::TICKET_EXPECTED,
            Status::COMPLETED
        ])->get();

        //dd($logs->toArray());
        return response()->json([
            'logs' => $logs,
        ]);
    }


}
