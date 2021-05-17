<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;



class ConfigController extends Controller
{

    public function getFilters(Request $request)
    {
        return new JsonResponse([
            'config' => config('filters')
        ], 200);
    }


}
