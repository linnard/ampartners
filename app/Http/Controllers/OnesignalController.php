<?php

namespace App\Http\Controllers;


use App\Models\UserPush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnesignalController extends Controller
{

    public function subscribe(Request $request)
    {
        $user = Auth::user();

        $player_id = $request->post('player_id');

        UserPush::updateOrCreate(
            ['player_id' => $player_id],
            ['user_id' => $user->id]
        );

        return response()->json([]);
    }
}
