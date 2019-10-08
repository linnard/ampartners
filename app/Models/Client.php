<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $guarded = [];

    public function vacancy(){
        return $this->hasOne(Vacancy::class);
    }
}
