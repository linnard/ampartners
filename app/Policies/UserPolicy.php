<?php

namespace App\Policies;

use App\Constants\User\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function update(User $currentUser, User $user)
    {
        return  $currentUser->hasRole(Role::ADMIN) || $currentUser->id === $user->id;
    }

    public function updateStatus(User $currentUser, User $user)
    {
        return  $currentUser->hasRole(Role::ADMIN);
    }
}
