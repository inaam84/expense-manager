<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Vehicle' => 'App\Policies\VehiclePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Enable email verification
        \Illuminate\Support\Facades\Gate::define('email-verified', function ($user) {
            return ! is_null($user->email_verified_at);
        });
    }
}
