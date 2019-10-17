<?php

namespace App\Models;

use App\Models\Client\Client;
use App\Models\Client\Constants\Status;
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

        $statuses = [
            Status::CREATING => 'Стадія створення',
            Status::BOOKING_CONFIRMATION_EXPECTED => 'Очікує підтвердження бронювання',
            Status::BOOKING_CONFIRMATION_REJECTED => 'Повернення',
            Status::TICKET_EXPECTED => 'Очікує завантаження квитка',
            Status::TICKET_CONFIRMATION_EXPECTED => 'Очікує підтвердження квитка',
            Status::TICKET_CONFIRMATION_REJECTED => 'Повернення',
            Status::COMPLETED => 'Успішно завершений',
        ];

        return $statuses[$this->status];
    }

}
