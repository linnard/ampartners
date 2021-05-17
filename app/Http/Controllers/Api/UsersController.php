<?php

namespace App\Http\Controllers\Api;

use App\Constants\User\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UpdateStatusRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    public function index()
    {
        $this->authorize('index', User::class);

        $users = User::with('roles', 'permissions')->get();

        return new JsonResponse([
            'users' => $users
        ], 200);

    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if(isset($validated['password']) && strlen($validated['password'])){
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        unset($validated['roles']);
        unset($validated['permissions']);

        $user->update($validated);
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));
        $user->load(['roles', 'permissions']);

        return new JsonResponse([
            'user' => $user
        ], 200);

    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);

        unset($validated['roles']);
        unset($validated['permissions']);

        $validated['api_token'] = Str::random(60);
        $validated['status'] = Status::ENABLED;

        /* @var \App\Models\User $user */
        $user = User::create($validated);
        $user->assignRole($request->input('roles'));
        $user->givePermissionTo($request->input('permissions'));
        $user->load(['roles', 'permissions']);

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
