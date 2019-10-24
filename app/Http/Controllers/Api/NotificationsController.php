<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $unread = $user->notifications()->unread()->count();
        $notifications =  $user->notifications()->with('client')->get();

        return response()->json([
            'notifications' => $notifications,
            'unread' => $unread
        ]);
    }

    public function read(Request $request)
    {
        $user = Auth::user();

        $user->notifications()->unread()->update([
            'is_read' => 1
        ]);

        return response()->json([
            'notifications' => $user->notifications()
        ]);
    }



}
