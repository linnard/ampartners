<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterItem extends Model
{
    protected $guarded = [];

    public function filter(){
        return $this->belongsTo(Filter::class);
    }

    public function vacancies(){
        return $this->belongsToMany(Vacancy::class);
    }
}
