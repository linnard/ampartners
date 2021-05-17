<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientVacancy extends Model
{
    protected $guarded = [];

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $attributes = ['is_active' => self::STATUS_ENABLED];

}
