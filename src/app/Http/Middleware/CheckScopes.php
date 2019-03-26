<?php

namespace Jenny05322\PassportGuard\App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Jenny05322\PassportGuard\App\Exceptions\MissingScopeException;

class CheckScopes
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$scopes
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\AuthenticationException
     * @throws \Laravel\Passport\Exceptions\MissingScopeException
     */
    public function handle($request, $next, ...$scopes)
    {
        if (! $request->user()) {
            throw new AuthenticationException;
        }

        foreach ($scopes as $scope) {
            if (! $request->user()->tokenCan($scope)) {
                throw new MissingScopeException($scope);
            }
        }

        return $next($request);
    }
}
