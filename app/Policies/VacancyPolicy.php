<?php

namespace App\Policies;

use App\Constants\User\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class VacancyPolicy
{
    use HandlesAuthorization;


    /*public function before(User $user)
    {
        if($user->hasRole(\App\Constants\User\Role::Admin)){
            return true;
        }

    }*/

    public function control(User $user)
    {
        return $user->hasPermissionTo(Permission::ControlVacancies);
    }

    public function view(User $user)
    {
        return $user->hasAnyPermission([Permission::ControlVacancies, Permission::ViewVacancies]);
    }


}
