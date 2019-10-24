<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StatusLog extends Model
{
    protected $guarded = [];

    protected $appends = [
        'status_description'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getStatusDescriptionAttribute()
    {
        return __('statuses.'.$this->status);
    }

}