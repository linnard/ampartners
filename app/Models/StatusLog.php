<?php

namespace App\Models;

use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $guarded = [];

    protected $appends = [
        'status_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
