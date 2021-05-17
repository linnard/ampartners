<?php

namespace App\Listeners;

use App\Constants\User\Permission;

use App\Notifications\Vacancy\VacancyCreatedNotification;
use App\Notifications\Vacancy\VacancyUpdatedNotification;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class VacancyEventListener
{

    public function onVacancyCreated($event)
    {
        /* @var $vacancy Vacancy */
        $vacancy = $event->vacancy;

        $users = User::permission([Permission::ViewVacancies])->get();


        if ($users->count()) {
            Notification::send($users, new VacancyCreatedNotification($vacancy));
        }


    }

    public function onVacancyUpdated($event)
    {
        /* @var $vacancy Vacancy */
        $vacancy = $event->vacancy;

        $users = User::permission([Permission::ViewVacancies])->get();

        if ($users->count()) {
            Notification::send($users, new VacancyUpdatedNotification($vacancy));
        }

    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Vacancy\Created',
            'App\Listeners\VacancyEventListener@onVacancyCreated'
        );

        $events->listen(
            'App\Events\Vacancy\Updated',
            'App\Listeners\VacancyEventListener@onVacancyUpdated'
        );

    }
}
