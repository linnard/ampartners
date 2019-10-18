<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusesController extends Controller
{

    public function index(Request $request)
    {
        return response()->json([
            'statuses' => __('statuses')
        ]);
    }


}
