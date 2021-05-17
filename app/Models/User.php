<?php

namespace App\Models;

use App\Constants\User\Role;
use App\Models\Client;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password', 'api_token', 'firstname', 'lastname', 'patronymic', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function pushes()
    {
        return $this->hasMany(UserPush::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function getVisibleClients()
    {
        if ($this->hasRole(Role::ADMIN)) {
            return Client::query();
        }

        return $this->clients()->getQuery();
    }

    public function getVisibleCompanies()
    {
        if ($this->hasRole(Role::ADMIN)) {
            return Company::query();
        }

        return $this->companies()->getQuery();
    }

    public function notifications()
    {
        return Notification::whereIn('client_id', $this->clientIds());
    }

    public function logs()
    {
        return StatusLog::whereIn('client_id', $this->clientIds());
    }

    public function clientIds()
    {
        return $this->clients()->pluck('id')->toArray();
    }



}
