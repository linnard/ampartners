<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\ClientProperty;
use App\Models\User;
use App\Models\ClientVacancy;
use App\Models\Vacancy;
use App\Policies\ClientPolicy;
use App\Policies\ClientPropertyPolicy;
use App\Policies\UserPolicy;
use App\Policies\ClientVacancyPolicy;
use App\Policies\VacancyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Client::class => ClientPolicy::class,
        ClientProperty::class => ClientPropertyPolicy::class,
        ClientVacancy::class => ClientVacancyPolicy::class,
        Vacancy::class => VacancyPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
