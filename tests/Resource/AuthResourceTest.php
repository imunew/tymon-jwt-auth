<?php

namespace Tests\Resources;

use Imunew\JWTAuth\Resources\AuthResource;
use Imunew\JWTAuth\ValueObjects\JwtToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Tests\TestCase;

class AuthResourceTest extends TestCase
{
    /**
     * @test
     */
    public function with_cookie()
    {
        $request = Request::create('http://localhost:8000/api/tests');
        $token = new JwtToken('test-access-token');
        $cookie = $this->assertResource($request, $token);
        $this->assertSame($token->accessToken, $cookie->getValue());
        $this->assertSame('localhost', $cookie->getDomain());
    }

    /**
     * @test
     */
    public function with_cookie_sub_domain()
    {
        $request = Request::create('http://test.example.com/api/tests');
        $token = new JwtToken('test-access-token');
        $cookie = $this->assertResource($request, $token);
        $this->assertSame($token->accessToken, $cookie->getValue());
        $this->assertSame('.example.com', $cookie->getDomain());
    }

    /**
     * @test
     */
    public function with_cookie_domain()
    {
        $this->app->get('config')->set('session.domain', 'test.example.com');
        $request = Request::create('http://test.example.com/api/tests');
        $token = new JwtToken('test-access-token');
        $cookie = $this->assertResource($request, $token);
        $this->assertSame($token->accessToken, $cookie->getValue());
        $this->assertSame('test.example.com', $cookie->getDomain());
    }

    /**
     * @param Request $request
     * @param JwtToken $jwtToken
     * @return Cookie
     */
    private function assertResource(Request $request, JwtToken $jwtToken)
    {
        $response = (new AuthResource($jwtToken))->toResponse($request);
        $cookies = $response->headers->getCookies();
        $cookie = $cookies[0];
        $this->assertInstanceOf(Cookie::class, $cookie);
        return $cookie;
    }
}
