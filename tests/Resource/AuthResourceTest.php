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
        $request = Request::create('api/tests');
        $token = new JwtToken('test-access-token');
        $response = (new AuthResource($token))->toResponse($request);
        $cookies = $response->headers->getCookies();
        $this->assertInstanceOf(Cookie::class, $cookies[0]);
        $cookie = $cookies[0];
        /* @var Cookie $cookie */
        $this->assertSame($token->accessToken, $cookie->getValue());
    }
}
