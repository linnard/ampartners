<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $guarded = [];

    public function vacancy(){
        return $this->hasMany(Client::class);
    }
}
