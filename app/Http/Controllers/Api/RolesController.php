<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index()
    {
        $roles = Role::all();

        $roles->map(function($item){
            return $item->name = ucfirst($item->name);
        });
        return new JsonResponse([
            'roles' => $roles
        ], 200);

    }
}
