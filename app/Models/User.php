<?php

namespace App\Models;

use App\Models\Client\Client;
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
        'login', 'password', 'firstname', 'lastname', 'patronymic', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    const ROLE_PARTNER = 'partner';
    const ROLE_ADMIN = 'admin';

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_REJECTED = 2;


    public function companies(){
        return $this->belongsToMany(Company::class);
    }

    public function logs(){
        return $this->hasMany(StatusLog::class);
    }

    public function clients(){
        return $this->hasMany(Client::class);
    }

    public function unreadLogs(){
        return $this->logs()->where('is_read', 0);
    }

    public function getVisibleClients()
    {
        if ($this->hasRole(static::ROLE_ADMIN)) {
            return Client::query();
        }

        return $this->clients()->getQuery();
    }

}
