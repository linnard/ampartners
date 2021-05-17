<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {

        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function clients(){
        return $this->hasMany(Client::class);
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
