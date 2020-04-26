<?php

namespace Tests\Providers;

use Tests\TestCase;
use Tymon\JWTAuth\Http\Parser\Cookies;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class ServiceProviderTest
 * @package Tests\Providers
 */
class ServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function cookies_key()
    {
        $jwtAuth = app(JWTAuth::class);
        $this->assertInstanceOf(JWTAuth::class, $jwtAuth);

        $chains = $jwtAuth->parser()->getChain();
        $this->assertInstanceOf(Cookies::class, $chains[0]);
        $cookies = $chains[0];
        /* @var Cookies $cookies */
        $this->assertSame('test-auth-token', $cookies->getKey());
    }
}
