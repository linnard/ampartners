<?php

namespace App\Policies;

use App\Constants\User\Role;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
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

    public function update(User $user, Vacancy $vacancy)
    {
        return  $user->hasRole(Role::ADMIN);
    }

    public function create(User $user)
    {
        return  $user->hasRole(Role::ADMIN);
    }
}
