<?php

namespace App\Policies;

use App\Constants\User\Role;
use App\Models\Client;
use App\Models\ClientProperty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPropertyPolicy
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

    public function update(User $user, ClientProperty $property)
    {
        return  $user->hasRole(Role::ADMIN) || $user->id === $property->client->user->id;
    }

}
