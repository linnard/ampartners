<?php

namespace App\Models;

use App\Constants\Vacancy\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Vacancy extends Model
{
    use HasTranslations;
    protected $guarded = [];

    protected $appends = [
        'translated_title',
        'translated_content'
    ];

    public $translatable = ['title', 'content'];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function filterItems(){
        return $this->belongsToMany(FilterItem::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('status', Status::Visible);
    }

    public function scopeHiddenClosed($query)
    {
        return $query->where('status', Status::HiddenClosed);
    }

    public function getTranslatedTitleAttribute()
    {
        return $this->getTranslation('title', app()->getLocale());
    }

    public function getTranslatedContentAttribute()
    {
        return $this->getTranslation('content', app()->getLocale());
    }
}
