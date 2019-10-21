<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
