<?php

namespace App\Providers;

use App\Helpers\ModuleHelper;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (ModuleHelper::getModelPolicyClasses() as $modelClass => $policyClass) {
            $this->policies[$modelClass] = $policyClass;
        }
        $this->registerPolicies();

        foreach (ModuleHelper::getRouteBaseNamePolicyClasses() as $routeBaseName => $policyClass) {
            // Gate::resource($routeBaseName, $policyClass);
        }
    }
}
