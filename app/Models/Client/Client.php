<?php

namespace App\Models\Client;

use App\Models\ClientProperty;
use App\Models\Company;
use App\Models\StatusLog;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

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

    public function logs(){
        return $this->hasMany(StatusLog::class);
    }

    public function latest_log() {
        return $this->hasOne(StatusLog::class)->latest();
    }

}
