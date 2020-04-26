# imunew/tymon-jwt-auth
[![CircleCI](https://circleci.com/gh/imunew/tymon-jwt-auth.svg?style=svg)](https://circleci.com/gh/imunew/tymon-jwt-auth)  
This is the Laravel package to extend [tymon/jwt-auth](https://packagist.org/packages/tymon/jwt-auth).

## Extended what?
- Disable the `QueryString`, `InputSource` and `RouteParams` parsers
- Made the `AuthHeaders` parser optional (Default: disabled)
- Prefer the `Cookies` parser
- Made the cookie name changeable

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

Set `JWT_AUTH_AUTH_HEADER_ENABLED` to enable the `AuthHeaders` parser

```envfile
JWT_AUTH_AUTH_HEADER_ENABLED=true
```
