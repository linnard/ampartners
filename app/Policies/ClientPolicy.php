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

    public function control(User $user, Client $client)
    {
        return $user->getVisibleClients()->where('id', $client->id)->count() > 0;
    }

    public function update(User $user, Client $client)
    {
        return $this->control($user, $client);
    }

    public function updateStatus(User $user, Client $client)
    {
        return $this->control($user, $client);
    }

    public function complete(User $user, Client $client)
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function downloadZip(User $user, Client $client)
    {
        return $this->control($user, $client);
    }

    public function uploadDocs(User $user, Client $client)
    {
        return $this->control($user, $client);
    }

}
