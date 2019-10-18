<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        echo 'ok';
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return new JsonResponse([
            'user' => $user
        ], 200);

    }
}
