<?php

namespace Jenny05322\PassportGuard\App;

use Illuminate\Container\Container;

trait HasApiTokens
{
    /**
     * The current scopes for the authentication user.
     */
    protected $scopes;

    /**
     * Set the current Passport scopes for the user.
     *
     * @param  array  $scopes
     * @return $this
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * Determine if the current Passport token has a given scope.
     *
     * @param  string  $scope
     * @return bool
     */
    public function tokenCan($scope)
    {
        return in_array('*', $this->scopes) ||
               array_key_exists($scope, array_flip($this->scopes));
    }
}
