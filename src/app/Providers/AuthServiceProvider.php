<?php

namespace Jenny05322\PassportGuard\App\Providers;

use Auth;
use Jenny05322\PassportGuard\App\Guards\PassportTokenGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as BaseAuthServiceProvider;

class AuthServiceProvider extends BaseAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('passportToken', function ($app, $name, array $config) {
            return new PassportTokenGuard(Auth::createUserProvider($config['provider']), request());
        });
    }
}
