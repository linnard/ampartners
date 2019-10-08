<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
