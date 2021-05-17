<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('position', 'asc');
        });
    }

    public function items(){
        return $this->hasMany(FilterItem::class);
    }
}
