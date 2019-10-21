<?php

namespace App\Policies;

use App\Constants\User\Role;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    private $currentUser;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function update(User $user, Client $client)
    {
        return  $user->hasRole(Role::ADMIN) || $user->id === $client->user->id;
    }

    public function updateStatus(User $user, Client $client)
    {
        return $user->hasRole(Role::ADMIN) || $user->id === $client->user->id;
    }

    public function complete(User $user, Client $client)
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function downloadZip(User $user, Client $client)
    {
        return $user->hasRole(Role::ADMIN) || $user->id === $client->user->id;
    }

    public function uploadDocs(User $user, Client $client)
    {
        return $user->hasRole(Role::ADMIN) || $user->id === $client->user->id;
    }

}
