<?php

namespace Tests\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Imunew\JWTAuth\Middleware\RefreshJwtToken;
use Symfony\Component\HttpFoundation\Cookie;
use Tests\TestCase;

/**
 * Class RefreshJwtTokenTest
 * @package Tests\Middleware
 */
class RefreshJwtTokenTest extends TestCase
{
    /**
     * @test
     */
    public function refresh_success()
    {
        $middleware = new RefreshJwtToken(FakeJwtAuth::create());
        $response = $middleware->handle(Request::create('/api/tests'), function (Request $request) {
            return response()->json();
        });
        /* @var Response $response */
        $cookies = $response->headers->getCookies();
        $this->assertInstanceOf(Cookie::class, $cookies[0]);
        $cookie = $cookies[0];
        /* @var Cookie $cookie */
        $this->assertSame(FakeJwtAuth::AUTH_TOKEN, $cookie->getValue());
    }

    /**
     * @test
     */
    public function refresh_fail_by_invalid_token()
    {
        $middleware = new RefreshJwtToken(FakeJwtAuth::create(false, true));
        $response = $middleware->handle(Request::create('/api/tests'), function (Request $request) {
            return response()->json();
        });
        /* @var Response $response */
        $cookies = $response->headers->getCookies();
        $this->assertEmpty($cookies);
    }

    /**
     * @test
     */
    public function refresh_fail_by_refresh_expired()
    {
        $middleware = new RefreshJwtToken(FakeJwtAuth::create(true, false, true));
        $response = $middleware->handle(Request::create('/api/tests'), function (Request $request) {
            return response()->json();
        });
        /* @var Response $response */
        $cookies = $response->headers->getCookies();
        $this->assertEmpty($cookies);
    }
}
