<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $guarded = [];

    protected $attributes = ['is_active' => 1];

    /*public function vacancy(){
        return $this->hasMany(Client::class);
    }*/
}
