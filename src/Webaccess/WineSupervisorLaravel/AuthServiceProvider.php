<?php

namespace Webaccess\WineSupervisorLaravel;

use DateTime;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Services\ClientManager;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
