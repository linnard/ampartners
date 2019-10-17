<?php

namespace App\Http\Controllers\Api;

use App\Events\Client\StatusUpdated;
use App\Http\Controllers\Controller;

use App\Http\Requests\Client\PatchRequest;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateStatusRequest;
use App\Models\Client\Client;
use App\Models\Client\Constants\Status;
use App\Models\StatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        $unread = $user->unreadLogs()->count();
        $logs =  $user->logs()->with('user', 'client')->orderBy('id', 'desc')->get();

        //dd($logs->toArray());
        return response()->json([
            'logs' => $logs,
            'unread' => $unread
        ]);
    }

    public function read(Request $request)
    {
        $user = Auth::user();

        $user->logs()->update([
            'is_read' => 1
        ]);

        $logs = $user->logs();

        return response()->json([
            'logs' => $logs
        ]);
    }



}
