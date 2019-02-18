<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Admin as AdminModel;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define Gates
        $this->defineGates();
    }

    /**
     * Admin management Gates
     */
    protected function defineGates() {
        Gate::define('manage-adminuser', function (AdminModel $admin) {
            return $admin->isSuperAdmin();
        });
    }
}
