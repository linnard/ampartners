<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;


class PermissionsController extends Controller
{


    public function index()
    {
        $permissions = Permission::all();

        return new JsonResponse([
            'permissions' => $permissions
        ], 200);

    }
}
