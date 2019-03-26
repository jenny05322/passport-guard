<?php

namespace Jenny05322\PassportGuard\App\Guards;

use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class PassportTokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        if (empty($jwt)) {
            $jwt = $this->request->bearerToken();
        }

        if (!empty($jwt)) {
            $jwtDecode = explode('.', $jwt);

            $content = json_decode(base64_decode($jwtDecode[1]), true);

            if ($content) {
                $clientId = $content['aud'];
                $issuedAt = $content['iat'];
                $notValidBefore = $content['nbf'];
                $expirationTime = $content['exp'];
                $userId = $content['sub'];
                $scopes = $content['scopes'];
            }

            if (time() >= $notValidBefore && time() <= $expirationTime && $userId) {
                $user = $this->provider->retrieveById($userId);
                if ($user) {
                    $user->setScopes($scopes);
                }
            }

        }

        return $this->user = $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return false;
    }
}
