# imunew/tymon-jwt-auth
[![CircleCI](https://circleci.com/gh/imunew/tymon-jwt-auth.svg?style=svg)](https://circleci.com/gh/imunew/tymon-jwt-auth)  
This is the Laravel package to extend [tymon/jwt-auth](https://packagist.org/packages/tymon/jwt-auth).

## Extended what?
- Disable the `QueryString`, `InputSource` and `RouteParams` parsers
- Made the `AuthHeaders` parser optional (Default: disabled)
- Prefer the `Cookies` parser
- Made the cookie name changeable
- Add `AuthResource` (with cookie)
- Add `RefreshJwtToken` middleware (with cookie)

## Install
```bash
$ composer require imunew/tymon-jwt-auth
```

`vendor:publish`

```bash
$ php artisan vendor:publish --provider="Imunew\JWTAuth\Providers\ServiceProvider"
```

## Config

Set `JWT_AUTH_COOKIE_KEY` environment variable to change the cookie name.

```envfile
JWT_AUTH_COOKIE_KEY={cookie name here}
```

Set `JWT_AUTH_AUTH_HEADER_ENABLED` environment variable to enable the `AuthHeaders` parser.

```envfile
JWT_AUTH_AUTH_HEADER_ENABLED=true
```

## Use `AuthResource`
Returning `AuthResource` sets JWT token in cookie.

```php
// App\Http\Controllers\Auth\Login

    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only(['login_id', 'password']);
        if (! $token = $this->jwtGuard->attempt($credentials)) {
            throw new AuthenticationException();
        }

        return new AuthResource(new JwtToken($token, $this->factory->getTTL() * 60));
    }
```

## Use `RefreshJwtToken`

Add `\Imunew\JWTAuth\Middleware\RefreshJwtToken::class` before `\App\Http\Middleware\Authenticate::class`.

```php
// App\Http\Kernel

    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Imunew\JWTAuth\Middleware\RefreshJwtToken::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
```

Add `\Imunew\JWTAuth\Middleware\RefreshJwtToken::class` to `$middlewareGroups`.

```php
// App\Http\Kernel

    protected $middlewareGroups = [
        'web' => [
            // ...
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Imunew\JWTAuth\Middleware\RefreshJwtToken::class,
        ]
    ];
```
