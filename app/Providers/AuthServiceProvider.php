<?php

namespace App\Providers;

use App\Helpers\ModuleHelper;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        //
    }
}
