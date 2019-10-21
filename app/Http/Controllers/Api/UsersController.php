<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UpdateStatusRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return new JsonResponse([
            'user' => $user
        ], 200);

    }

    public function updateStatus(UpdateStatusRequest $request, User $user)
    {
        $this->authorize('updateStatus', $user);

        $user->update($request->validated());

        return new JsonResponse([
            'user' => $user
        ], 200);

    }
}
