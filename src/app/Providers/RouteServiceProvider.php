<?php

namespace Jenny05322\PassportGuard\App\Providers;

use Illuminate\Support\Facades\Route;
use Jenny05322\PassportGuard\App\Http\Middleware\CheckScopes;
use Jenny05322\PassportGuard\App\Http\Middleware\CheckForAnyScope;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * The package's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'scopes' => CheckScopes::class,
        'scope'  => CheckForAnyScope::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->aliasMiddleware();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
    }

    protected function aliasMiddleware()
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            Route::aliasMiddleware($key, $middleware);
        }
    }
}
