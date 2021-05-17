<?php

namespace App\Policies;

use App\Constants\User\Role;
use App\Models\User;
use App\Models\ClientVacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientVacancyPolicy
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

    public function update(User $user, ClientVacancy $vacancy)
    {
        return  $user->hasRole(Role::ADMIN);
    }

    public function create(User $user)
    {
        return  $user->hasRole(Role::ADMIN);
    }
}
