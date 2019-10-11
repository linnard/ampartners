<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Client extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = [];

    protected $attributes = [
        'firstname' => '',
        'lastname' => '',
        'vacancy_id' => 0,
        'note' => ''
    ];

    public function vacancy(){
        return $this->hasOne(Vacancy::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function properties(){
        return $this->hasMany(ClientProperty::class);
    }
}
