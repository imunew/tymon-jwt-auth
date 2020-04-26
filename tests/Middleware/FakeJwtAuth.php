<?php

namespace Tests\Middleware;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Parser\Parser;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;

class FakeJwtAuth extends JWTAuth
{
    /** @var string */
    const AUTH_TOKEN = 'test-auth-token';

    /** @var bool */
    private $willTokenExpired;

    /** @var bool */
    private $willInvalidToken;

    /** @var bool */
    private $willRefreshExpired;

    /**
     * @param bool $willTokenExpired
     * @param bool $willInvalidToken
     * @param bool $willRefreshExpired
     * @return FakeJwtAuth
     */
    public static function create(
        bool $willTokenExpired = true,
        bool $willInvalidToken = false,
        bool $willRefreshExpired = false
    ) {
        $manager = app(Manager::class);
        $auth = app(Auth::class);
        $parser = app(Parser::class);
        $instance = new self($manager, $auth, $parser);
        $instance->willTokenExpired = $willTokenExpired;
        $instance->willInvalidToken = $willInvalidToken;
        $instance->willRefreshExpired = $willRefreshExpired;
        return $instance;
    }

    /**
     * @return JWTAuth|FakeJwtAuth
     * @throws JWTException
     */
    public function parseToken()
    {
        if ($this->willInvalidToken) {
            throw new JWTException('Invalid token');
        }
        return $this;
    }

    /**
     * @throws TokenExpiredException
     */
    public function authenticate()
    {
        if ($this->willTokenExpired) {
            throw new TokenExpiredException();
        }
        return (new class implements JWTSubject {
            public function getJWTIdentifier()
            {
                return 1;
            }

            public function getJWTCustomClaims()
            {
                return [];
            }
        });
    }

    /**
     * @param bool $forceForever
     * @param bool $resetClaims
     * @return string
     * @throws JWTException
     */
    public function refresh($forceForever = false, $resetClaims = false)
    {
        if ($this->willRefreshExpired) {
            throw new JWTException('Refresh expired');
        }
        return self::AUTH_TOKEN;
    }
}
