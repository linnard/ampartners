<?php

namespace App\Providers;

use App\Events\Client\StatusUpdated;
use App\Listeners\CreateNotification;
use App\Listeners\LogStatus;
use App\Listeners\UpdateCounts;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        StatusUpdated::class => [
            LogStatus::class,
            CreateNotification::class,
            UpdateCounts::class
        ]
    ];

    protected $subscribe = [
        'App\Listeners\VacancyEventListener',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
