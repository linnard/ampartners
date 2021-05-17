<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class UserPush extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'player_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
