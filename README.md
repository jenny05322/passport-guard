# Passport Guard
This package separate the resource server from the passport. It doesn't need to install passport package.

## Install
Install by composer package manager.

```
composer require jenny05322/passport-guard
```

Next, register service provider in `config/app.php`.

```
Jenny05322\PassportGuard\App\Providers\ServiceProvider::class,
```

Add `HasApiTokens` trait to `User` model.


```
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenny05322\PassportGuard\App\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
}
```

In `config/auth.php` file, set the api driver to `passportToken`.

```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passportToken',
        'provider' => 'users',
    ],
],
```

## Checking Scopes
Just like Laravel, so you can look at [Checking Scopes](https://laravel.com/docs/5.4/passport#checking-scopes) in Laravel Document.